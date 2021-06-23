<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* CLase principal del sistema
	* Encapsula el funcionamiento de los demas objetos del sistema - mediator
	*/
	class mt extends db_sitio{

		/*
		* Implementacion del patron Singleton
		*/
		private static $instance;
		public static function getInstance(){
			if (null === self::$instance) self::$instance = new mt();
			return self::$instance;
		}
		private function __clone(){}
		private function __wakeup(){}

		public static $hooks;
		public $seccion = array();
		public $sitio;
		public $plantilla;
		public $entrada;
		public $foundRows;

		protected function __construct(){
			//Instanciamos la clase encargada de los hooks
			self::$hooks = new Hooks;

			//Implementamos el modo mantenimiento si esta habilitado
			if( MODO_MANTENIMIENTO ) self::$hooks->add_action(
				'beforeBegin', extras::modoMantenimiento()
			);

			self::$hooks->do_action('beforeBegin');

			$this->setZonaHoraria();

			//Realizamos la coneccion con la base de datos
			dbConnector::connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			$this->getInfo('url', 'tema_url', 'tema_ext', 'conf_enlaces', 'conf_enlaces_anidar');
			$this->plantilla = new templates(
				"{$this->getInfo('tema_url')}",
				$this->getInfo('tema_ext')
			);

			$this->entrada = new l_entrada;
		}

		private $buscadoresSecc = array(
			'buscaSecInterna',
			'buscaEntrada',
			'buscaColeccion',
		);

		/*
		* Metodo encargado de determinar la seccion solicitada
		*/
		public function getSeccion(){
			//Obtenemos la url de la seccion solicitada y eliminamos la ultima /
			$url = ( isset($_GET['url']) ) ? rtrim( $_GET['url'], '/' ) : 'inicio';

			self::$hooks->do_action( 'determinarSec' );

			//Establecemos la pagina de error como seccion por defecto
			$seccion = $this->getSec('error404');

			//Usamos las funciones definidas para la busqueda de la seccion
			$resultadoSS = array();
			require 'mt_nucleo/inclusiones/inc_buscsec.php';
			foreach ($this->buscadoresSecc as $k => $v) {
				$resultadoSS = $v($url);
				if( $resultadoSS ) break;
			}
			if( $resultadoSS ) $seccion = $resultadoSS;

			$this->seccion = $seccion;
			return $this->seccion;
		}

		/*
		* Metodo para obtener secciones internas del sistema
		*/
		public function getSec($url = null){
			//Optenemos las secciones del archivo de configuracion
			$lista_secciones = $GLOBALS['secciones'];
			$seccion = array();

			//Si no se especifica la url de la seccion retornamos todas
			if( is_null($url) ){
				foreach ($lista_secciones as $k => $v) {
					//Establecemos el enlace web para la seccion solicitada
					$lista_secciones[$k]['enlace'] = "{$this->getInfo('url')}/{$v['url']}";

					//Establecemos el archivo con la logica para la seccion
					if( 0 == $lista_seccions[$k]['tipo'] )
						$lista_secciones[$k]['filesec'] = "mt_nucleo/secciones/{$v['filesec']}.php";
					else if( 1 == $lista_seccions[$k]['tipo'] )
						$lista_secciones[$k]['filesec'] = "{$this->getInfo('tema_url')}/{$v['filesec']}.php";
				}
				return $lista_secciones;
			}else{
				//Si se especifico la url de la seccion
				//Buscamos la seccion en el arreglo de secciones
				if( isset( $lista_secciones[$url]['url'] ) ){
					$seccion = $lista_secciones[$url];

					//Establecemos el enlace web para la seccion solicitada
					$seccion['enlace'] = "{$this->getInfo('url')}/{$seccion['url']}";

					//Establecemos el archivo con la logica para la seccion
					if( 0 == $seccion['tipo'] )
						$seccion['filesec'] = "mt_nucleo/secciones/{$seccion['filesec']}.php";
					else if( 1 == $seccion['tipo'] )
						$seccion['filesec'] = "{$this->getInfo('tema_url')}/{$seccion['filesec']}.php";
				}
			}

			return $seccion;
		}

		/*
		* Metodo para agregar mas secciones internas
		*/
		public function setSec( $datos ){
			if( isset( $datos['id'], $datos['url'], $datos['filesec'] ) ){
	 			$datos['clase'] = 'seccion';
	 			$datos['tipo'] = 1;
				if( !isset( $datos['titulo'] ) ) $datos['titulo'] = '';
			 	$GLOBALS['secciones'][$datos['url']] = $datos;
			}else echo '<p><strong>Error al añadir secciones</strong></p>';
		}

		/*
		* Metodo para obtener entradas bajo los criteros solicitados
		*/
		public function getEntrada($datos = null, $columnas = null){
			if( is_null($datos) ) $datos = array();
			if( is_int($datos) ) $datos = array( 'id' => $datos );
			if( is_array($columnas) ){
				if( is_array($datos) ) $datos['columnas'] = $columnas;
				else $datos = array('columnas' => $columnas);
			}
			$paginar = false;
			$campocolnombre = false;
			$campoportada = false;
			//Este bloque permite obtener los datos necesarios para generar la columna enlace
			$generarEnlace = false;
			$numoffset = isset( $datos['limit'] ) ? $datos['limit'] : $this->getInfo('conf_epp');
			if( isset($datos['columnas']) ){

				//Definimos si se requere el campo enlace buscandolo en las columnas
				$campoenlace = null;
				$coincidencias = array();
				foreach ($datos['columnas'] as $k => $v) {
					preg_match('/^(e\.)*enlace(\sas\s)*(.?)*$/is', $v, $coincideActual);
					if( $coincideActual ){
						unset( $datos['columnas'][$k] );
						$coincidencias = $coincideActual[0];
					}
					//Definimos si se requiere el nombre para la coleccion
					preg_match('/^(col\.)*nombre(\sas\s)*(.?)*$/is', $v, $coincideActual);
					if( $coincideActual ) $campocolnombre = $coincideActual[0];
					//Definimos si se requiere la imagen de portada
					preg_match('/^(e\.)*portada(\sas\s)*(.?)*$/is', $v, $coincideActual);
					if( $coincideActual ) $campoportada = $coincideActual[0];
				}
				if( $coincidencias ){
					$generarEnlace = true;
					$generaFaltantes = $this->adCamposFaltantesEnlace($datos['columnas']);
					$datos['columnas'] = $generaFaltantes[1];
				}
			}
			if( isset($datos['paginacion']) ) if( $datos['paginacion'] ){
				$paginar = true;
				$datos['limit'] = isset( $datos['limit'] ) ? $datos['limit'] : $this->getInfo('conf_epp');
				$datos['offset'] = ($this->getNumPagina()-1)*$numoffset;
				$datos['foundrows'] = true;
			}
			$resultado = $this->entrada->getEntrada($datos);
			if( isset( $datos['foundrows'] ) ) if( $datos['foundrows'] ){
				$this->foundRows = dbConnector::foundRows();
			}

			//Generamos dinamicamente el enlace si se solicito
			if( $resultado && $generarEnlace ){
				$resultado = $this->generarEnlace($resultado, $coincidencias);
				foreach ($resultado as $k => $v) {
					foreach ($generaFaltantes[0] as $c => $b) {
						unset($resultado[$k][$c]);
					}
				}
			}

			//Agregamos el nombre por defecto a las entradas sin nombre de categoría
			if( $campocolnombre ){
				$campocolnombre = preg_split('/ as /is', $campocolnombre);
				if( isset($campocolnombre[1]) ) $campocolnombre = $campocolnombre[1];
				else if ( isset($campocolnombre[0]) ) $campocolnombre = $campocolnombre[0];
				foreach( $resultado as $k => $v ){
					if( $v[$campocolnombre] == '' )
						$resultado[$k][$campocolnombre] = 'Sin categoría';
				}
			}

			//Agregamos el imagen de portada por defecto
			if( $campoportada && isset($datos['portada_default']) ){
				$campoportada = preg_split('/ as /is', $campoportada);
				if( isset($campoportada[1]) ) $campoportada = $campoportada[1];
				else if ( isset($campoportada[0]) ) $campoportada = $campoportada[0];
				foreach( $resultado as $k => $v ){
					if( $v[$campoportada] == '' )
						$resultado[$k][$campoportada] = $datos['portada_default'];
				}
			}

			//Si se obtuvo la entrada por su id retornamos fila unica
			if( $resultado && isset($datos['id']) ) return $resultado[0];
			else if( $resultado && $paginar ) return array(
				'entradas' => $resultado,
				'paginacion' => $this->paginacionAS($this->foundRows, $numoffset),
			);
			else if( !$resultado && $paginar ) return array(
				'entradas' => array(),
				'paginacion' => $this->paginacionAS($this->foundRows, $numoffset),
			);
			return $resultado;

		}

		/*
		* Metodo para obtener entradas bajo los criteros solicitados
		*/
		public function getColeccion($datos = null, $columnas = null){
			if( is_null($datos) ) $datos = array();
			if( is_int($datos) ) $datos = array( 'id' => $datos );
			if( is_array($columnas) ){
				if( is_array($datos) ) $datos['columnas'] = $columnas;
				else $datos = array('columnas' => $columnas);
			}

			$generarEnlace = false;
			if( isset($datos['columnas']) ){
				//Definimos si se requere el campo enlace buscandolo en las columnas
				$campoenlace = null;
				$coincidencias = array();
				foreach ($datos['columnas'] as $k => $v) {
					preg_match('/^(col\.)*enlace(\sas\s)*(.?)*$/is', $v, $coincideActual);
					if( $coincideActual ){
						unset( $datos['columnas'][$k] );
						$coincidencias = $coincideActual[0];
					}
				}
				if( $coincidencias ){
					$generarEnlace = true;
					$generaFaltantes = $this->adCamposFaltantesEnlaceCol($datos['columnas']);
					$datos['columnas'] = $generaFaltantes[1];
				}
			}

			$resultado = $this->entrada->getColeccion($datos, $columnas);

			//Generamos dinamicamente el enlace si se solicito
			if( $resultado && $generarEnlace ){

				//Definimos el alias para el campo enlace
				$aliascampo = preg_split('/ as /is', $coincidencias);
				if( isset($aliascampo[1]) ) $aliascampo = $aliascampo[1];
				else if ( isset($aliascampo[0]) ) $aliascampo = $aliascampo[0];

				foreach ($resultado as $k => $v) {
					if(  $v['tipo'] == 1  ){
						$coleccion_superiores = array();
						if( $v['superior'] ){
							$idactual = $v['superior'];
							do{
								$colsup = $this->getColeccion(array(
									'id' => $idactual,
									'columnas' => array('id', 'url', 'superior'),
								));
								$idactual = $colsup['superior'];
								$coleccion_superiores[] = $colsup['url'];
							}while($idactual);
						}

						$enlaceActual = implode('/', array_reverse($coleccion_superiores)).'/'.$v['url'];
						$enlaceActual = ltrim( $enlaceActual, '/');

						$resultado[$k][$aliascampo ] = "{$this->getInfo('url')}/{$enlaceActual}";
					}else if( $v['tipo'] == 2 ){
						$resultado[$k][$aliascampo ] = "{$this->getInfo('url')}/tag/{$v['url']}";
					}
					//Eliminamos los campos que se incluyeron dinamicamente para obtener enlace
					foreach ($generaFaltantes[0] as $c => $b) {
						unset($resultado[$k][$c]);
					}
				}
			}

			//Si se obtuvo la coleccion por su id retornamos fila unica
			if( $resultado && isset($datos['id']) ) return $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para establecer la zona horaria del sitio
		*/
		public function setZonaHoraria(){
			date_default_timezone_set( ZONA_HORARIA );
		}

		/*
		* Metodo para generar dinamicamente el enlace de las entradas
		*/
		private function generarEnlace($resultado, $nombrecampo){
			foreach ($resultado as $k => $v) {
				if( $v['tipo'] == 2 ){

					//Este bloque permite determinar la url de las colecciones para la entrada
					$entrada_colecciones = array();
					if( $v['coleccion_id'] ) $entrada_colecciones[] = $v['coleccion_url'];
					if( $v['coleccion_superior'] ){
						$colsupactual = (INT) $v['coleccion_superior'];
						while( $colsup = $this->getColeccion(
							$colsupactual, array('col.id', 'col.url', 'col.superior')
						)  ){
							$entrada_colecciones[] = $colsup['url'];
							if( $colsup['superior'] ) $colsupactual = $colsup['id'];
							else break;
						}
					}

					$enlaceActual = $this->generarEnlaceT2(array(
						'nombre' => $v['url'],
						'id' => $v['id'],
						'y' => extras::formatoDate($v['fecha_u'], 'Y'),
						'm' => extras::formatoDate($v['fecha_u'], 'm'),
						'd' => extras::formatoDate($v['fecha_u'], 'd'),
						'h' => extras::formatoDate($v['fecha_u'], 'H'),
						'i' => extras::formatoDate($v['fecha_u'], 'i'),
						's' => extras::formatoDate($v['fecha_u'], 's'),
						'autor' => $v['autor_nickname'],
						'col' => implode('/', array_reverse($entrada_colecciones)),
					));

					$aliascampo = preg_split('/ as /is', $nombrecampo);
					if( isset($aliascampo[1]) ) $nombrecampo = $aliascampo[1];
					else if ( isset($aliascampo[0]) ) $nombrecampo = $aliascampo[0];

					$resultado[$k][$nombrecampo] = "{$this->getInfo('url')}/{$enlaceActual}";
				}else if(  $v['tipo'] == 1  ){
					//Este bloque permite determinar la url de las colecciones para la entrada
					$entrada_colecciones = array();
					if( $v['superior'] ){
						$idactual = $v['superior'];
						do{
							$colsup = $this->getEntrada(array(
								'id' => $idactual,
								'columnas' => array('e.id', 'e.url', 'e.superior'),
							));
							$idactual = $colsup['superior'];
							$entrada_colecciones[] = $colsup['url'];
						}while($idactual);
					}

					$enlaceActual = implode('/', array_reverse($entrada_colecciones)).'/'.$v['url'];
					$enlaceActual = ltrim( $enlaceActual, '/');

					$aliascampo = preg_split('/ as /is', $nombrecampo);
					if( isset($aliascampo[1]) ) $nombrecampo = $aliascampo[1];
					else if ( isset($aliascampo[0]) ) $nombrecampo = $aliascampo[0];

					$resultado[$k][$nombrecampo] = "{$this->getInfo('url')}/{$enlaceActual}";
				}
			}
			return $resultado;
		}

		/*
		* Metodo para genernr dinamicamente el enlace de entradas tipo 2
		*/
		private function generarEnlaceT2($datos){
			$conf_enlace = $this->getInfo('conf_enlaces');

			$regexenlaces = array(
				'nombre' => '/\{nombre\}/is',
				'col' => '/\{col\}/is',
				'id' => '/\{id\}/is',
				'y' => '/\{y\}/is',
				'm' => '/\{m\}/is',
				'd' => '/\{d\}/is',
				'h' => '/\{h\}/is',
				'i' => '/\{i\}/is',
				's' => '/\{s\}/is',
				'autor' => '/\{autor\}/is',
			);

			$replace = array(
				$regexenlaces['nombre'] => $datos['nombre'],
				$regexenlaces['id'] => $datos['id'],
				$regexenlaces['y'] => $datos['y'],
				$regexenlaces['m'] => $datos['m'],
				$regexenlaces['d'] => $datos['d'],
				$regexenlaces['h'] => $datos['h'],
				$regexenlaces['i'] => $datos['i'],
				$regexenlaces['s'] => $datos['s'],
				$regexenlaces['autor'] => $datos['autor'],
				$regexenlaces['col'] => $datos['col'],
				'/\/\//is' => '/',
			);

			$resultado = preg_replace(
				array_keys($replace), array_values($replace), $conf_enlace
			);

			return ltrim( $resultado, '/');
		}

		/*
		* Metodo para añadir campos faltantes para generar columna enlace a la consulta a la base de datos
		*/
		private function adCamposFaltantesEnlace($datos){
			$camposE = array(
				'id' => 'e.id',
				'url' => 'e.url',
				'fecha_u' => 'e.fecha_u',
				'superior' => 'e.superior',
				'tipo' => 'e.tipo',
				'coleccion_id' => 'e.coleccion AS coleccion_id',
				'coleccion_url' => 'col.url AS coleccion_url',
				'coleccion_tipo' => 'col.tipo AS coleccion_tipo',
				'coleccion_superior' => 'col.superior AS coleccion_superior',
				'autor_nickname' => 'u.nickname autor_nickname',
			);
			$faltantes = array();
			foreach ($camposE as $k => $v) {
				if( !in_array($v, $datos) ) $faltantes[$k] = $v;
			}
			return array(
				$faltantes,
				array_merge( $datos, $faltantes ),
			);
		}

		/*
		* Metodo para añadir campos faltantes para generar columna enlace a la consulta a la base de datos
		*/
		private function adCamposFaltantesEnlaceCol($datos){
			$camposE = array(
				'id' => 'col.id',
				'url' => 'col.url',
				'tipo' => 'col.tipo',
				'superior' => 'col.superior',
			);
			$faltantes = array();
			foreach ($camposE as $k => $v) {
				if( !in_array($k, $datos) ) $faltantes[$k] = $v;
			}
			return array(
				$faltantes,
				array_merge( $datos, $faltantes ),
			);
		}

		/*
		* Metodo para generar la paginacion al estilo anterior/siguiente
		*/
		public function paginacionAS($total_e, $nepp){
			$actual = $this->getNumPagina();
			if( $nepp == 0 ) $total_p = 0;
			else $total_p = ceil( $total_e / $nepp );
			$anterior = 0;
			$siguiente = 0;
			if( ($actual+1) <= $total_p ) $siguiente = $actual+1;
			if( ($actual-1) > 0 ){
				$anterior = $actual-1;
				if( $anterior > $total_p ) $anterior = $total_p;
			}
			return array(
				'actual' => $actual,
				'enlace_a' => $anterior,
				'enlace_s' => $siguiente,
			);
		}

		/*
		* Metodo para establecer el numero de la pagina actual
		*/
		public function getNumPagina(){
			if( isset($_GET['pagina']) ){
				if( $_GET['pagina']>0 ) return (INT) $_GET['pagina'];
			}
			return 1;
		}

		/*
		* Metodo para obtener comentarios bajo los criteros solicitados
		*/
		public function getComentario($datos = null, $columnas = null){
			if( is_null($datos) ) $datos = array();
			if( is_int($datos) ) $datos = array( 'id' => $datos );
			if( is_array($columnas) ){
				if( is_array($datos) ) $datos['columnas'] = $columnas;
				else $datos = array('columnas' => $columnas);
			}

			$resultado = $this->entrada->getComentario($datos, $columnas);

			//Si se obtuvo el resultado por su id retornamos fila unica
			if( $resultado && isset($datos['id']) ) return $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para insertar nuevos comentarios
		*/
		public function setComentario($datos){
			$errores = array();
			$resultado = array();

			if( $this->getInfo('conf_coment') != 0  ){
				$datos = extras::limpiarCadenas($datos);
				$ckeckCamposVacios = extras::checkCampoVacio(array(
					'destino' => $datos['destino'],
					'autor' => $datos['autor'],
					'email' => $datos['email'],
					'contenido' => $datos['contenido'],
				));
				if( !filter_var( $datos['email'], FILTER_VALIDATE_EMAIL ) ) $errores[] = 'email_incorrecto';
				if( !filter_var( $datos['sitio'], FILTER_VALIDATE_URL ) && !empty($datos['sitio']) )
					$errores[] = 'urlsitio_incorrecto';

				$validacaptcha = extras::validaReCaptcha(RECAPTCHA_SECRET_KEY, $datos['captchaResponse']);
				if( !$validacaptcha ) $errores[] = 'recaptcha_incorrecto';

				if( !$ckeckCamposVacios && !$errores ){
					$opciones = array(
						'destino' => (INT) $datos['destino'],
						'usuario' => 0,
						'autor' => $datos['autor'],
						'email' => $datos['email'],
						'sitio' => $datos['sitio'],
						'contenido' => $datos['contenido'],
						'tipo' => 1,
						'superior' => 0,
						'estado' => $this->getInfo('conf_coment'),
					);
					if( !$this->getComentarioAntiflood( $opciones['destino'] ) ){
						$resultado = $this->entrada->setComentario($opciones);
					}else{
						$resultado = array('demasiados_comentarios');
					}
				}else if( $errores || $ckeckCamposVacios ){
					$resultado = array_merge( $ckeckCamposVacios, $errores );
				}
			}else $resultado = array('comentarios_deshabilitados');

			if( is_array($resultado) ) return json_encode(array('result' => 0, 'error' => $resultado));
			else if( $resultado ) return json_encode(array('result' => 1, 'error' => array()));
		}

		/*
		* Metodo para obtener los comentarios mas recientes hechos desde la misma ip
		*/
		public function getComentarioAntiflood($datos){
			$fecha = strtotime ( '-2 minute' , strtotime ( date('Y-m-d H:i:s') ) ) ;
			$fecha = date ( 'Y-m-d H:i:s' , $fecha );
			$resultado = $this->getComentario(array(
				'destino' => $datos,
				'columnas' => array('id'),
				'filtro' => "( ip='{$_SERVER['REMOTE_ADDR']}' AND fecha >='{$fecha}' )",
			));
			return $resultado;
		}


	}
