<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/**
	* Clase principal del Backend
	*/
	require 'datos/db_sitio.php';
	class principal extends db_sitio{

		public $seccion = array();
		public $error = array();

		function __construct(){
			//Conectamos con la base de datos
			dbConector::conectar(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			//Determinamos la seccion solicitada
			$this->determinarSeccion();

			//Numero de intentos permitidos al iniciar sesion antes de ser bloqueado
			$intentos = $this->listarSitioConfig(array('conf_intentos'));
			define( 'INTENTOS_FALLIDOS', $intentos['conf_intentos'] );
			define( 'SITIO_DIRECCION', $this->listarSitioConfig(array('url'))['url'] );
			define( 'SITIO_EMAIL', $this->listarSitioConfig(array('email'))['email'] );
		}

		/*
		* Metodo encargado de determinar la seccion solicitada por get
		*/
		public function determinarSeccion(){
			require 'inclusiones/inc_secciones.php';
			$this->seccion = $secciones['inicio'];
			if( isset($_GET['seccion']) )
				if( isset( $secciones[$_GET['seccion']] ) )
					$this->seccion = $secciones[$_GET['seccion']];
			else $this->seccion = $secciones['error404'];
		}

		/*
		* Metodo encargado de obtener toda la informacion del sitio
		*/
		public function sitioInfo(){
			return $this->dbListarInfo();
		}

		/*
		* Metodo encargado de procesar formulario de edicion de datos de sitio
		*/
		public function editarInfo($datos){
			$error = extras::verifCampoVacio($datos);
			if( count($error) ) $this->error = $error;
			else return $this->dbEditarInfo( extras::escaparDB($datos) );
			return 0;
		}

		/*
		* Metodo para obtener datos de configuracion del sitio
		*/
		public function listarConfig(){
			$resultado = $this->dbListarConfig();
			return $resultado;
		}

		/*
		* Metodo para obtener datos de configuracion del sitio
		*/
		public function listarSitioConfig($datos = ''){
			$campos = '*';
			if( is_array($datos) ){
				$campos = '';
				foreach ($datos as $value) $campos .= "{$value}, ";
				$campos = extras::eliminaUltimoC(trim($campos), ',');
			}
			$resultado = $this->dbListarSitioConfig( extras::escaparDB($campos) );
			return $resultado;
		}

		/*
		* Metodo encargado de procesar formulario de edicion de configuracion del sitio
		*/
		public function editarConfig($datos){
			$error = extras::verifCampoVacio($datos);
			if( count($error) ) $this->error = $error;
			else return $this->dbEditarConfig( extras::escaparDB($datos) );
			return 0;
		}

		/*
		* Metodo para obtener estadisticas del sitios
		*/
		public function listarEstadisticas(){
			$campos = $this->listarSitioConfig(array(
				'total_u', 'total_a', 'total_p', 'total_c', 'total_cat', 'total_t'
			));
			return $campos;
		}
	}
