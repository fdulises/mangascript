<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/**
	* Clase correspondiente a la capa de datos
	* Provee de metodos para realizar peticiones relacionadas con el sitio
	*/
	abstract class db_sitio{
		protected $t_sitio = t_sitio;

		/*
		* Metodo para obtener informacion del sitio
		*/
		protected function dbListarInfo(){
			$query = "SELECT
				titulo, lema, descrip, url, cms_info, cms_v, email FROM {$this->t_sitio}
			";
			$resultado = dbConector::query($query);
			if($resultado) $resultado = $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para editar los datos del sitio
		*/
		protected function dbEditarInfo($datos){
			$query = "UPDATE {$this->t_sitio} SET
				titulo = '{$datos['titulo']}',
				lema = '{$datos['lema']}',
				descrip = '{$datos['descrip']}',
				url = '{$datos['url']}',
				email = '{$datos['email']}'
			";
			$resultado = dbConector::sendQuery($query);
			return $resultado;
		}

		/*
		* Metodo para obtener datos de configuracion del sitio
		*/
		protected function dbListarConfig(){
			$query = "SELECT
				conf_epp, conf_coment, conf_intentos, conf_registro, conf_validaemail,
				tema_nombre, tema_url, tema_ext
				FROM {$this->t_sitio}
			";
			$resultado = dbConector::query($query);
			if($resultado) $resultado = $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para obtener datos de configuracion solicitados
		*/
		protected function dbListarSitioConfig($datos){
			$query = "SELECT {$datos} FROM {$this->t_sitio}";
			$resultado = dbConector::query($query);
			if($resultado) $resultado = $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para editar los datos de configuracion del sitio
		*/
		protected function dbEditarConfig($datos){
			$query = "UPDATE {$this->t_sitio} SET
				conf_epp = '{$datos['epp']}',
				conf_coment = '{$datos['coment']}',
				conf_intentos = '{$datos['intentos']}',
				conf_registro = '{$datos['registro']}',
				conf_validaemail = '{$datos['validaemail']}',
				tema_nombre = '{$datos['tema_nombre']}',
				tema_url = '{$datos['tema_url']}',
				tema_ext = '{$datos['tema_ext']}'
			";
			$resultado = dbConector::sendQuery($query);
			return $resultado;
		}

	}
