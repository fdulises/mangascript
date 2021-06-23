<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/**
	* Clase correspondiente a la capa de datos
	* Provee de metodos para realizar peticiones relacionadas con el sistema de usuarios
	*/
	abstract class db_usuario{
		protected $t_usuario = t_usuario;
		protected $t_perfil = t_perfil;
		protected $t_intentos = t_intentos;
		protected $t_sitio = t_sitio;
		protected $t_sesiones = t_sesiones;

		/*
		* Metodo para insertar usuario nuevo
		*/
		protected function dbInsertar($datos){
			$query = "INSERT INTO {$this->t_usuario}(
				nickname, email, clave, salt, ip, fregistro, estado, grupo
			) VALUES(
				'{$datos['nickname']}',
				'{$datos['email']}',
				'{$datos['clave']}',
				'{$datos['salt']}',
				'{$datos['ip']}',
				'{$datos['fregistro']}',
				'{$datos['estado']}',
				'{$datos['grupo']}'
			)";
			$resultado = dbConector::sendQuery($query);
			return $resultado;
		}

		/*
		* Metodo para insertar Perfil de nuevo Usuario
		*/
		protected function dbInsertarPerfil($datos){
			return dbConector::sendQuery(
				"INSERT INTO {$this->t_perfil}(
					nombre, descrip, sitio
				) VALUES(
					'{$datos['nombre']}',
					'{$datos['descrip']}',
					'{$datos['sitio']}'
				)"
			);
		}

		/*
		* Metodo para obtener lista de usuarios
		*/
		protected function dbListar(){
			$query = "SELECT u.id, u.nickname, u.email, u.fregistro, u.grupo, p.nombre, u.total_e
				FROM {$this->t_usuario} u
				LEFT JOIN {$this->t_perfil} p ON u.id = p.id
				WHERE u.estado=1
			";
			$resultado = dbConector::query($query);
			return $resultado;
		}

		/*
		* Metodo para actualizar datos de usuario
		*/
		protected function dbEditar($datos){
			$query = "UPDATE {$this->t_usuario} u
				LEFT JOIN {$this->t_perfil} p ON u.id = p.id
				SET
				u.email = '{$datos['email']}',
				u.grupo = '{$datos['grupo']}',
				p.nombre = '{$datos['nombre']}',
				p.descrip = '{$datos['descrip']}',
				p.sitio = '{$datos['sitio']}'
				WHERE u.id='{$datos['id']}'
			";
			$resultado = dbConector::sendQuery($query);
			return $resultado;
		}

		/*
		* Metodo para eliminar usuarios por su id
		*/
		protected function dbEliminar($id){
			return dbConector::sendQuery(
				"UPDATE {$this->t_usuario} SET estado=0 WHERE id={$id}"
			 );
		}

		/*
		* Metodo para obtener la clave de un usuario apartir de su id
		*/
		protected function dbGetClaveById($id){
			$query = "SELECT clave FROM {$this->t_usuario} WHERE id='{$id}' AND estado=1";
			$resultado = dbConector::query($query);
			if($resultado) return $resultado[0]['clave'];
		}

		/*
		* Metodo para registrar intendos de inicio de sesion fallidos
		*/
		protected function crearSesionFallida($datos){
			$query ="INSERT INTO mt_sesiones_fallidas(id, tiempo) VALUES(
				'{$datos['id']}',
				'{$datos['tiempo']}'
			)";
			return dbConector::sendQuery($query);
		}

		/*
		* Metodo que obtiene datos de un usuario para iniciar sesion apartir de su email
		*/
		protected function dbGetUsuarioByEmail($dato){
			$query = "SELECT id, nickname, email, clave, salt
				FROM {$this->t_usuario} WHERE email = '{$dato}' AND estado=1 LIMIT 1";
			$resultado = dbConector::query($query);
			return $resultado;
		}

		/*
		* Metodo que obtiene datos de un usuario para iniciar sesion apartir de su nickname
		*/
		protected function dbGetUsuarioByNickname($dato){
			$query = "SELECT id, nickname, email, clave, salt
			FROM {$this->t_usuario} WHERE nickname = '{$dato}' AND estado=1 LIMIT 1";
			$resultado = dbConector::query($query);
			return $resultado;
		}

		/*
		* Metodo que obtiene datos de un usuario usando su id
		*/
		protected function dbGetUsuarioById($id){
			$query = "SELECT
				u.id,
				u.nickname,
				u.email,
				u.grupo,
				p.nombre,
				p.descrip,
				p.sitio
				FROM {$this->t_usuario} u
				LEFT JOIN {$this->t_perfil} p ON u.id = p.id
				WHERE u.id = '{$id}' AND estado=1
			";
			$resultado = dbConector::query($query);
			return $resultado;
		}

		/*
		* Metodo que obtiene datos de un usuario usando su id
		*/
		protected function dbGetUsuarioByHuella($huella){
			$query = "SELECT
				id,
				nickname,
				email,
				grupo
				FROM {$this->t_usuario}
				WHERE huella = '{$huella}' AND estado=1
			";
			$resultado = dbConector::query($query);
			if( $resultado ) return $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para registrar los intentos de inicio de sesion fallidos
		*/
		protected function dbinsertarIntento($datos){
			$query = "INSERT INTO {$this->t_intentos}(tiempo, usuario) VALUES(
				'{$datos['tiempo']}',
				'{$datos['id']}'
			)";
			return dbConector::sendQuery($query);
		}

		/*
		* Metodo para obtener los intentos de inicio de sesion fallidos de un usuario
		*/
		protected function dblistarIntentos($datos){
			$query = "SELECT tiempo, usuario FROM {$this->t_intentos}
			WHERE usuario='{$datos['id']}' AND tiempo > '{$datos['tiempo']}' ";
			return dbConector::query($query);
		}

		/*
		* Metodo para actualizar clave de usuario
		*/
		protected function dbClaveEditar($datos){
			$resultado = dbConector::sendQuery("UPDATE {$this->t_usuario} SET
				clave = '{$datos['clave']}',
				salt = '{$datos['salt']}'
				WHERE id='{$datos['id']}'
			");
			return $resultado;
		}

		/*
		* Metodo para insertar sesion de usuario
		*/
		protected function dbInsertarSesion($datos){
			return dbConector::sendQuery("INSERT INTO {$this->t_sesiones}(
				usuario, tiempo, ip, agent, huella
			) VALUES(
				'{$datos['usuario']}',
				'{$datos['tiempo']}',
				'{$datos['ip']}',
				'{$datos['agent']}',
				'{$datos['huella']}'
			)");
		}

		/*
		* Metodo para buscar sesion de usuario
		*/
		protected function dbListarSesion($datos){
			$resultado = dbConector::query(
				"SELECT s.id, s.usuario, s.tiempo, s.ip, s.agent, u.nickname, u.clave,
				u.email, u.salt
				FROM {$this->t_sesiones} s
				LEFT JOIN {$this->t_usuario} u ON s.usuario = u.id
				WHERE s.huella = '{$datos['huella']}'"
			);
			if($resultado) return $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para buscar sesion de usuario
		*/
		protected function dbBorrarSesion($datos){
			$resultado = dbConector::sendQuery(
				"DELETE FROM {$this->t_sesiones} WHERE huella = '{$datos['huella']}'"
			);
			return $resultado;
		}

		/*
		* Metodo para extraer el datos
		*/
		protected function dbExtraeUsuario($email, $nickname){
			$query = "SELECT id FROM {$this->t_usuario}
				WHERE email = '{$email}'
				OR nickname = '{$nickname}'
				";
			return dbConector::query($query);
		}

		/*
		* Metodo para actualizar datos de usuario
		*/
		protected function dbActualizarHuella($datos){
			$resultado = dbConector::sendQuery(
				"UPDATE {$this->t_usuario} SET huella = '{$datos['huella']}'
				WHERE id='{$datos['id']}'"
			);
			return $resultado;
		}

	}
