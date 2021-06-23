<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
		Sistema de plantillas - Script Creado Por Ulises Rendón
	*/
	
	/*---------- Clase Encargada del sistema de Plantillas ----------*/
	class templates{
		
		//Propiedades que contendran las etiquetas bloques y patrones a remplazar
		private $etiquetas = array();
		private $bloques = array();
		private $patrones = array();
		
		//Propiedades con datos de configuración
		private $directorio = '';
		private $extension = '';
		private $delimitadorabrir = '{';
		private $delimitadorcerrar = '}';
		
		public function __construct($dir='', $ext=''){
			//Establecemos la ruta del directorio con los archivos de plantilla y la extension de los arhivos
			$this->setDir($dir);
			$this->setExt($ext);
			//Patron para ocultar comentarios en codigo
			$this->setPatron('/\{\*(.*?)\*\}/is', '');
			$this->setPatron('/\{\*\}(.*?)\{\/\*\}/is', '');
		}
		
		//Metodo para obtener el contenido de un archivo
		private function getFile($ruta){
			if( file_exists($ruta) ){
				$cadena = file_get_contents($ruta);
			}else{
				$cadena = 'Error de plantilla: Archivo "'.htmlentities($ruta).'" no encontrado. <br />';
			}
			return $cadena;
		}
		
		//Metodo para dar funcionamiento a la etiqueta {include}
		private function sustIncludes($cadena){
			$patron = '/\{include=(.*?)\}/is';
			$rutas = array();
			$inclusiones = array();
			while($matches = $this->getCadenaPatron($cadena, $patron, true)){
				foreach($matches as $v){
					$ruta = $this->directorio.$v[1].$this->extension;
					if(!array_key_exists($v[1], $rutas)){
						$rutas[$v[1]] = $ruta;
						$html = $this->getFile($ruta);
						$inclusiones[$v[0]] = $html;
					}
				}
				$cadena = $this->sustEtiquetas($cadena, $inclusiones);
			}
			return $cadena;
		}
		
		//Metodo para buscar una cadena en otra cadena apartir de un patron
		private function getCadenaPatron($cadena, $patron, $todos = false){
			if(!$todos){
				preg_match($patron, $cadena, $resultado);
				if($resultado) return $resultado[1];
			}else{
				preg_match_all($patron, $cadena, $resultado, PREG_SET_ORDER);
				if($resultado) return $resultado;
			}
			return false;
		}
		
		//Metodo para sustituir etiquetas en una cadena apartir de un array con los datos de las etiquetas
		private function sustEtiquetas($cadena, $tags = false, $valores = false){
			//Si se proporciona un array con las etiquetas las usamos para la sustitucion
			if( is_array($tags) ){
				if( is_array($valores) ){
					$cadena = str_replace($tags, $valores, $cadena);
				}else{
					$cadena = str_replace(array_keys($tags), array_values($tags), $cadena);
				}
			}else{
				//Si no se proporciona un array hacemos la sustitucion usando la propiedad de la clase etiquetas
				$cadena = str_replace(array_keys($this->etiquetas), array_values($this->etiquetas), $cadena);
			}
			return $cadena;
		}
		
		//Metodo para hacer la sustitucion de todos lo bloques
		private function sustBloques($cadena){
			$render = array();
			foreach($this->bloques as $k => $v){
				$fragmento = $this->getCadenaPatron($cadena, $v['patron']);
				$render[$v['patron']] = '';
				foreach($v['datos'] as $a){
					$render[$v['patron']] .= $this->sustEtiquetas($fragmento, $v['tags'], $a);
				}
			}
			$cadena = preg_replace(array_keys($render), array_values($render), $cadena);
			return $cadena;
		}
		
		//Metodo para realizar las sustituciones de patrones en la cadena indicada
		private function sustPatrones($cadena){
			$render = preg_replace(array_keys($this->patrones), array_values($this->patrones), $cadena);
			return $render;
		}
		
		//Metodo para establecer la ruta al directorio con los archivos de plantilla
		public function setDir($dir){
			if($dir == '') $this->directorio = '';
			else $this->directorio = $dir.'/';
		}
		
		//Metodo para establecer la extension de los archivos de plantilla
		public function setExt($ext){
			if($ext == '') $this->extension = '';
			else $this->extension = '.'.$ext;
		}
		
		//Metodo para establecer los delimitadores de variables y bloques
		public function setDelimitadores($dela, $delc){
			$this->delimitadorabrir = $dela;
			$this->delimitadorcerrar = $delc;
		}
		
		//Metodo para establecer una etiqueta con su nombre y su valor
		public function setEtiqueta($clave, $valor = ''){
			if( !is_array($clave) ){
				$clave = $this->delimitadorabrir.$clave.$this->delimitadorcerrar;
				$this->etiquetas[$clave] = $valor;
			}else{
				foreach($clave as $k => $v){
					$clavetag = $this->delimitadorabrir.$k.$this->delimitadorcerrar;
					$this->etiquetas[$clavetag] = $v;
				}
			}
		}
		
		//Metodo para establecer un bloque
		public function setBloque($nombre, $datos, $tags){
			$dabrir = "\\".$this->delimitadorabrir;
			$dcerrar = "\\".$this->delimitadorcerrar;
			$patron = "/{$dabrir}{$nombre}{$dcerrar}(.*?){$dabrir}\/{$nombre}{$dcerrar}/is";
			foreach($tags as $k => $v){
				$tags[$k] = $this->delimitadorabrir.$v.$this->delimitadorcerrar;
			}
			$this->bloques[$nombre] = array(
				'patron' => $patron,
				'datos' => $datos,
				'tags' => $tags
			);
		}
		
		//Metodo para asignar nuevo patron
		public function setPatron($patron, $valor){
			$this->patrones[$patron] = $valor;
		}
		
		//Metodo para obtener el contenido de un archivo de plantilla
		public function getHTML($nombre){
			$ruta = $this->directorio.$nombre.$this->extension;
			$html = $this->getFile($ruta);
			return $html;
		}
		
		//Metodo para realizar las sustituciones
		public function parse($cadena){
			$cadena = $this->sustIncludes($cadena);
			$cadena = $this->sustBloques($cadena);
			$cadena = $this->sustPatrones($cadena);
			$cadena = $this->sustEtiquetas($cadena);
			return $cadena;
		}
		
		//Metodo para mostrar el codigo final
		public function display($cadena){
			$cadena = $this->parse($cadena);
			print($cadena);
		}
	}