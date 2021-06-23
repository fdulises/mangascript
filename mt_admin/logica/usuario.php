<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Clase encargada del sistema de usuarios
	* Provee todos los metodos requeridos para trabajar con los usuarios
	*/
	require 'datos/db_usuario.php';
	class usuario extends db_usuario{

		public $error = array();
		private $SITIO_DIRECCION = SITIO_DIRECCION;
		private $SITIO_EMAIL = SITIO_EMAIL;

		public function __construct(){
			//Iniciamos sesion segura
		    $this->sessionStart();
		}

		/*
		* Metodo para establecer el inicio de sesion seguro
		*/
		public function sessionStart(){
			//Personalizamos los parametros del inicio de sesion
			$session_name = S_ID;
			$secure = false;
			$httponly = true;
			if(ini_set('session.use_only_cookies', 1) === FALSE)
				exit(header("Location: ?error=Error_de_sesion_ini_set"));
			//Establecemos los parametros de inicio de sesion
			$cookieParams = session_get_cookie_params();
			session_set_cookie_params(
				$cookieParams["lifetime"],
				$cookieParams["path"],
				$cookieParams["domain"],
				$secure, $httponly
			);
			session_name($session_name);
			session_start();
			session_regenerate_id();
		}

		/*
		* Metodo para verificar si se ha guardado la sesion del usuario
		*/
		private function rememberLogingCheck(){
			$resultado = $this->dbListarSesion(array(
				'huella' => extras::escaparDB($_COOKIE[S_LOGING])
			));
			//id+ip+agent+tiempo+sal
			if( $resultado ){
				return $this->inicioSesion(array(
					'id' => $resultado['usuario'],
					'nickname' => $resultado['nickname'],
					'clave' => $resultado['clave'],
					'email' => $resultado['email'],
				));
			}
			return 0;
		}

		/*
		* Metodo para mantener sesion de usuario iniciada
		*/
		private function sesionRecordar($datos){
			$tiempo = date('U');
			$huella = hash('sha256',
				$datos['usuario'].
				$_SERVER['REMOTE_ADDR'].
				$_SERVER['HTTP_USER_AGENT'].
				$tiempo.
				$datos['salt']
			);
			$resultado2 = $this->dbInsertarSesion(array(
				'usuario' => $datos['usuario'],
				'tiempo' => $tiempo,
				'ip' => $_SERVER['REMOTE_ADDR'],
				'agent' => $_SERVER['HTTP_USER_AGENT'],
				'huella' => $huella,
			));
			if( $resultado2 )
				setcookie(S_LOGING, $huella, time()+60*60*24*30, '/', '', false, true);
			return false;
		}

		/*
		* Metodo para eliminar la sesion de usuario que se mantiene iniciada
		*/
		private function salirSesionRecordar(){
			if( isset($_COOKIE[S_LOGING]) ){
				$resultado = $this->dbBorrarSesion(array(
					'huella' => $_COOKIE[S_LOGING],
				));
				setcookie(S_LOGING, "", time() - 3600, '/', '', false, true);
				unset($_COOKIE[S_LOGING]);
			}
		}

		/*
		* Metodo para verificar que se haya iniciado sesion
		*/
		public function logingCheck(){
			if( isset($_SESSION[S_USERID], $_SESSION[S_USERNAME], $_SESSION[S_STRING]) ){
				$userId = dbConector::escape($_SESSION[S_USERID]);
				$clave = $this->dbGetClaveById($userId);
				if( $clave ){
					$logingcheck = hash( 'sha512', $clave.$_SERVER['HTTP_USER_AGENT'] );
					if( $logingcheck === $_SESSION[S_STRING] ) return 1;
				}
			}else if( isset($_COOKIE[S_LOGING]) ) return $this->rememberLogingCheck();
			return 0;
		}

		/*
		* Metodo para crear nuevo usuario
		*/
		public function crear($datos){
			//Verificamos que los campos no esten vacios y los sanitizamos
			$this->verifCampoVacio(array(
				'nickname' => $datos['nickname'],
				'email' => $datos['email'],
				'clave' => $datos['clave'],
				'grupo' => $datos['grupo'],
			));
			$this->limpiarCadenas($datos);
			//Validamos que el usuario y la contraseña sean Validamos
			$this->validaUsuario($datos['nickname']);
			$this->validaClave($datos['clave']);
			$this->validaEmail($datos['email']);
			$this->validaGrupo($datos['grupo']);

			//Validamos si ya existen correo o nickname repetido
			if( !count($this->error) )
				$this->existeUsuarioDatos($datos['email'], $datos['nickname']);

			//Si no hay ningun error con la clave y la contraseña procedemos
			if( !count($this->error) ){
				$sal = $this->randomSalt();
				$usuario_datos = array(
					'nickname' => $datos['nickname'],
					'email' => $datos['email'],
					'clave' => hash( 'sha512', $datos['clave'].$sal),
					'salt' => $sal,
					'ip' => $_SERVER['REMOTE_ADDR'],
					'fregistro' => date('Y-m-d'),
					'estado' => 1,
					'grupo' => $datos['grupo'],
				);
				$resultado = $this->dbInsertar( extras::escaparDB($usuario_datos) );
				if( $resultado ){
					$this->dbInsertarPerfil(array(
						'nombre' => $datos['nombre'],
						'descrip' => $datos['descrip'],
						'sitio' => $datos['sitio'],
					));
				}
				db_entrada::dbActulizarContS('total_u', 1);
				return $resultado;
			}
			return 0;
		}

		/*
		* Metodo para editar datos de un usuario
		*/
		public function editar($datos){
			//Verificamos que los campos no esten vacios y los sanitizamos
			$this->verifCampoVacio(array(
				'id' => $datos['id'],
				'email' => $datos['email'],
				'grupo' => $datos['grupo']
			));
			$this->limpiarCadenas($datos);
			//Validamos que el usuario y la contraseña sean Validamos
			$this->validaEmail($datos['email']);
			$this->validaGrupo($datos['grupo']);

			//Si no hay ningun error procedemos
			if( !count($this->error) ){
				$usuario_datos = array(
					'id' => $datos['id'],
					'email' => $datos['email'],
					'grupo' => $datos['grupo'],
					'nombre' => $datos['nombre'],
					'descrip' => $datos['descrip'],
					'sitio' => $datos['sitio'],
				);
				$resultado = $this->dbEditar( extras::escaparDB($usuario_datos) );
				if( $resultado ) $this->claveEditar(array(
					'id' => $datos['id'],
					'clave' => $datos['clave'],
				));
				return $resultado;
			}
			return 0;
		}

		/*
		* Metodo para eliminar nuevo usuario
		*/
		public function eliminar($id){
			$resultado = $this->dbEliminar( dbConector::escape($id) );
			db_entrada::dbActulizarContS('total_u', -1);
			return $resultado;
		}

		/*
		* Metodo para obtener lista de usuarios
		*/
		public function listar(){
			$resultado = $this->dbListar();
			foreach ($resultado as $k => $v) {
				$resultado[$k]['fregistro'] = extras::fechaF1($v['fregistro']);
			}
			return $resultado;
		}

		/*
		* Metodo para obtener datos de un usuario por su id
		*/
		public function listarById($id){
			$id = (INT) $id;
			$resultado = $this->dbGetUsuarioByID(dbConector::escape($id));
			if($resultado) return $resultado[0];
			return array();
		}

		/*
		* Metodo para generar una sal aleatoria para usarla en contraseñas
		*/
		private function randomSalt(){
			//return uniqid(mt_rand(1, mt_getrandmax()), true);
			return hash( 'sha512', uniqid(openssl_random_pseudo_bytes(16), true) );
		}

		/*
		* Metodo para iniciar sesion con los datos seguros
		*/
		private function inicioSesion($datos){
			$_SESSION[S_USERID] = $datos['id'];
			$_SESSION[S_USERNAME] = $datos['nickname'];
			$_SESSION[S_USERMAIL] = $datos['email'];
			$_SESSION[S_STRING] = hash( 'sha512', $datos['clave'].$_SERVER['HTTP_USER_AGENT'] );
			return 1;
		}

		/*
		* Metodo para cerrar la sesion de forma segura
		*/
		public function cierraSesion(){
			$this->salirSesionRecordar();
			$_SESSION = array();
			$sesionParams = session_get_cookie_params();
			setcookie(
				session_name(),
				'', time()-42000,
				$sesionParams['path'],
				$sesionParams['domain'],
				$sesionParams['secure'],
				$sesionParams['httponly']
			);
			session_destroy();
			header('location: acceso');
			exit();
		}

		/*
		* Metodo para procesar inicio de sesion de usuario
		*/
		public function acceso($datos){
			//Verificamos que los campos no esten vacios y los sanitizamos
			$this->verifCampoVacio($datos);
			$this->limpiarCadenas($datos);
			//Validamos que el usuario y la contraseña sean Validamos
			$this->validaUsuario($datos['usuario']);
			$this->validaClave($datos['clave']);

			//Si no hay ningun error con la clave y la contraseña procedemos
			if( !count($this->error) ){
				//Obtenemos los datos del usuario solicitado
				$usuarioDatos = $this->getUsuarioAcceso(dbConector::escape($datos['usuario']));
				if($usuarioDatos){
					//Verificamos intentos de sesion fallidos para evitar ataques de fuerza bruta
					if( $this->checkbrute($usuarioDatos['id']) ) return 0;
					//Comparamos la contraseña ingresada con la guardada en la base de datos
					if( (hash('sha512', $datos['clave'].$usuarioDatos['salt']) === $usuarioDatos['clave']) && !count($this->error) ){
						//Inicamos sesion si todo es correcto
						$resultado = $this->inicioSesion(array(
							'id' => $usuarioDatos['id'],
							'nickname' => $usuarioDatos['nickname'],
							'clave' => $usuarioDatos['clave'],
							'email' => $usuarioDatos['email'],
						));
						if( isset($datos['recordars']) ) if( $datos['recordars'] )
							$this->sesionRecordar(array(
								'usuario' => $usuarioDatos['id'],
								'salt' => $usuarioDatos['salt'],
							));
						return $resultado;
					}else{
						$this->registrarIntento(array(
							'tiempo' => time(),
							'id' => $usuarioDatos['id'],
						));
						$this->error[] = 'clave_incorrecta';
					}
				}
			}
			return 0;
		}

		/*
		* Metodo que obtiene datos de un usuario para iniciar sesion
		*/
		private function getUsuarioAcceso($dato){
			//Determinamos si se esta accediendo por email o por nickname
			$resultado = array();
			if( filter_var($dato, FILTER_VALIDATE_EMAIL) ) $resultado = $this->dbGetUsuarioByEmail($dato);
			else $resultado = $this->dbGetUsuarioByNickname($dato);
			if( count($resultado) ) return $resultado[0];
			else $this->error[] = 'usuario_incorrecto';
			return 0;
		}

		/*
		* Metodo para generar gravarar
		*/
		public function urlGravatar($email, $size){
			$hash = md5( strtolower( trim( $email ) ) );
			return "http://www.gravatar.com/avatar/{$hash}.jpg?s={$size}&d=mm";
		}

		/*
		* Metodo para verificar campos vacios
		*/
		private function verifCampoVacio($datos){
			$err = 0;
			foreach ($datos as $k => $v) {
				if($v === "") $this->error[]=$k.'_vacio';
				$err += 1;
			}
			if($err) return 0;
			return 1;
		}

		/*
		* Metodos para sanitizar campos de acceso
		*/
		private function limpiarCadenas($datos){
			if( is_array($datos) ) foreach ($datos as $k => $v)
					$datos[$k] = filter_var($v, FILTER_SANITIZE_STRING);
			else $datos = filter_var($datos, FILTER_SANITIZE_STRING);
			return $datos;
		}

		/*
		* Metodo para verificar si es email o usuario y validarlo
		*/
		private function validaUsuario($dato){
			if( filter_var($dato, FILTER_VALIDATE_EMAIL) ) return 1;
			else if( preg_match('/^[a-zA-Z0-9\-_]{4,16}$/', $dato) ) return 2;
			else $this->error[] = "usuario_incorrecto";
			return 0;
		}

		/*
		* Metodo para validar la configuracion de la clave (sha512)
		*/
		private function validaClave($dato){
			if( (strlen($dato) !== 128) || !ctype_xdigit($dato) )
				$this->error[] = 'clave_configuracion';
		}

		/*
		* Metodo para validar la configuracion de la huella (sha256)
		*/
		private function validaHuella($dato){
			if( (strlen($dato) !== 64) || !ctype_xdigit($dato) )
				$this->error[] = 'huella_configuracion';
		}

		/*
		* Metodo para validar emails
		*/
		private function validaEmail($dato){
			if( filter_var($dato, FILTER_VALIDATE_EMAIL) ) return 1;
			else $this->error[] = "email_incorrecto";
			return 0;
		}

		/*
		* Metodo para grupo de usuarios
		*/
		private function validaGrupo($dato){
			require 'inclusiones/inc_grupos.php';
			if( isset($grupos[$dato]) ) return 1;
			else $this->error[] = "grupo_incorrecto";
			return 0;
		}

		/*
		* Metodo para impedir ataques de fuerza bruta
		*/
		private function checkbrute($id){
			$tiempoLimite = time() - (2*60*60);
			$intentos = $this->dbListarIntentos(array(
				'tiempo' => $tiempoLimite,
				'id' => $id,
			));
			if(count($intentos) >= INTENTOS_FALLIDOS){
				$this->error[] = 'limite_intentos';
				return true;
			}
			return 0;
		}

		/*
		* Metodo para registrar intentos de sesion fallidos e impedir ataques de fuerza bruta
		*/
		private function registrarIntento($datos){
			//$this->error[] = 'intento_fallido';
			return $this->dbinsertarIntento($datos);
		}

		/*
		* Metodo para cambiar la clave del usuario solicitado
		*/
		public function claveEditar($datos){
			//Validamos que la clave sea valida para proceder
			$this->validaClave($datos['clave']);
			if( !count($this->error) ){
				$sal = $this->randomSalt();
				return $this->dbClaveEditar(extras::escaparDB(array(
					'id' => $datos['id'],
					'clave' => hash( 'sha512', $datos['clave'].$sal),
					'salt' => $sal,
				)));
			}
			return 0;
		}

		/*
		* Metodo para saber si existe correo o nickname
		*/
		public function existeUsuarioDatos($correo, $nickname){
			$correo = extras::escaparDB($correo);
			$nickname = extras::escaparDB($nickname);
			if( $this->dbExtraeUsuario($correo, $nickname) )
				$this->error[] = 'usuario_repetido';
		}

		/*
		* Metodo para ayudar al usuario a restablecer su clave
		* Genera una huella unica y la manda por email para validar el email
		*/
		public function ayudaRestableceClave($datos){
			$datos = $this->limpiarCadenas($datos['usuario']);
			$valida = $this->validaUsuario($datos);
			if( $valida == 1 ) $usuario = $this->dbGetUsuarioByEmail($datos);
			else if( $valida == 2 ) $usuario = $this->dbGetUsuarioByNickname($datos);
			else $usuario = 0;
			if( $usuario ){
				$usuario = $usuario[0];
				$huella = hash( 'sha256', $this->randomSalt() );
				$datos_huella = array('huella' => $huella, 'id' => $usuario['id']);
				if( $this->dbActualizarHuella( $datos_huella ) ){
					correos::restableceClave(array(
						'destino' => $usuario['email'],
						'usuario' => $usuario['nickname'],
						'huella' => $huella,
					));
					return 1;
				}
			}else $this->error[] = 'usuario_incorrecto';
			return 0;
		}

		/*
		* Metodo para restablecer clave de usuario
		*/
		public function restableceClave($datos){
			$datos = $this->limpiarCadenas($datos);
			$this->validaHuella($datos['id']);
			$this->validaClave($datos['clave']);
			if( !count($this->error) ){
				$usuario = $this->dbGetUsuarioByHuella(
					extras::escaparDB($datos['id'])
				);
				if( $usuario ){
					$resultado = $this->claveEditar(array(
						'id' => $usuario['id'],
						'clave' => $datos['clave'],
					));
					//Reiniciamos la huella
					$this->dbActualizarHuella(array(
						'huella' => hash('sha256', $this->randomSalt()),
						'id' => $usuario['id'],
					));

					if( $resultado ) return 1;
				}
			}
			return 0;
		}
	}
