<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
class singleton{

	private static $instance;

	public static function getInstance(){
		if (null === self::$instance)
			self::$instance = new singleton();
		return self::$instance;
	}

	protected function __construct(){}
	private function __clone(){}
	private function __wakeup(){}
}
