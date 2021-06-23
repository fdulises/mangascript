<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	/*
	* Clase de la capa de logica para entradas
	*
	* Permite realizar transacciones con entradas y colecciones
	*/
	class l_entrada extends db_entrada{

		public function __construct(){}

		/*
		* Metodo para recuperar entradas usando peticiones personalizadas
		*/
		public function getEntrada($datos = null, $columnas = null){

			if( is_null($datos) ) $datos = array();
			if( is_int($datos) ) $datos = array( 'id' => $datos );
			if( is_array($columnas) ) $datos['columnas'] = $columnas;

			$resultado = $this->dbGetEntrada($datos);
			return $resultado;
		}

		/*
		* Metodo para recuperar colecciones usando peticiones personalizadas
		*/
		public function getColeccion($datos = null, $columnas = null){

			if( is_null($datos) ) $datos = array();
			if( is_int($datos) ){
				$datos = array( 'id' => $datos );
			}
			if( is_array($columnas) ) $datos['columnas'] = $columnas;
			$resultado = $this->dbGetColeccion($datos);

			return $resultado;
		}

		/*
		* Metodo para recuperar comentarios usando peticiones personalizadas
		*/
		public function getComentario($datos = null, $columnas = null){

			if( is_null($datos) ) $datos = array();
			if( is_int($datos) ){
				$datos = array( 'id' => $datos );
			}
			if( is_array($columnas) ) $datos['columnas'] = $columnas;
			$resultado = $this->dbGetComentario($datos);

			return $resultado;
		}

		/*
		* Metodo para insertar comentarios
		*/
		public function setComentario($datos){
			$opciones = array(
				'destino' => (INT) $datos['destino'],
				'usuario' => (INT) $datos['usuario'],
				'autor' => $datos['autor'],
				'email' => $datos['email'],
				'sitio' => $datos['sitio'],
				'contenido' => $datos['contenido'],
				'fecha' => date('Y-m-d H:i:s'),
				'ip' => $_SERVER['REMOTE_ADDR'],
				'agent' => $_SERVER['HTTP_USER_AGENT'],
				'tipo' => (INT) $datos['tipo'],
				'superior' => (INT) $datos['superior'],
				'estado' => (INT) $datos['estado'],
			);
			$resultado = $this->dbSetComentario($opciones);
			if( $resultado ) $this->dbUpdateComentCont($datos['destino']);
			return $resultado;
		}

	}
