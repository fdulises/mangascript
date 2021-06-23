<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
class getterdatos{
	public $html;
	public function __construct($url){
		$this->html = $this->getContents($url);
	}

	private function getContents($url){
		return file_get_contents($url);
	}

	public function getCadenaPatron($cadena, $patron, $todos = false){
		if(!$todos){
			preg_match($patron, $cadena, $resultado);
			if($resultado) return $resultado[1];
		}else{
			preg_match_all($patron, $cadena, $resultado, PREG_SET_ORDER);
			if($resultado) return $resultado;
		}
		return false;
	}

	public function getCadena($patron, $todos = false){
		return $this->getCadenaPatron($this->html, $patron, $todos);
	}

	public function formatoDate($fecha, $formato){
		$start = DateTime::createFromFormat('d/m/Y', $fecha);
		return $start->format($formato);
	}

}
