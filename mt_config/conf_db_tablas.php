<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	define('t_colecciones', DB_PREF.'colecciones');
	define('t_comentarios', DB_PREF.'comentarios');
	define('t_entradas', DB_PREF.'entradas');
	define('t_perfiles', DB_PREF.'perfil');
	define('t_sesiones', DB_PREF.'sesiones');
	define('t_sesioneserr', DB_PREF.'intentosf');
	define('t_sitio', DB_PREF.'sitio');
	define('t_temas', DB_PREF.'temas');
	define('t_usuarios', DB_PREF.'usuario');

	abstract class db_tablas{
		protected function __construct(){}

		public $t_colecciones = t_colecciones;
		public $t_comentarios = t_comentarios;
		public $t_entradas = t_entradas;
		public $t_perfiles = t_perfiles;
		public $t_sesiones = t_sesiones;
		public $t_sesioneserr = t_sesioneserr;
		public $t_sitio = t_sitio;
		public $t_temas = t_temas;
		public $t_usuarios = t_usuarios;
	}
