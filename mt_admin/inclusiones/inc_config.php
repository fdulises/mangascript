<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo con constantes de datos de configuracion del sistema
	*/

	//Constante con datos para las sesiones
	define('S_PRE',			'xp_');
	define('S_ID',			S_PRE.'session_id');
	define('S_USERID',		S_PRE.'userid');
	define('S_USERNAME',	S_PRE.'username');
	define('S_USERMAIL',	S_PRE.'usermail');
	define('S_STRING',		S_PRE.'string');
	define('S_LOGING',		S_PRE.'loging');

	//constantes con datos del sitio
	define('SITIO_TITULO', 'Mictlan CMS');
	define('TEMA_DIR', 'tema');
	define('TEMA_EXT', 'tpl');

	//Constantes con los nombres de las tablas de la base de datos
	define('t_entrada', 	DB_PREF.'entradas');
	define('t_coleccion', 	DB_PREF.'colecciones');
	define('t_sitio', 		DB_PREF.'sitio');
	define('t_usuario', 	DB_PREF.'usuario');
	define('t_perfil', 		DB_PREF.'perfil');
	define('t_comentario', 	DB_PREF.'comentarios');
	define('t_intentos', 	DB_PREF.'intentosf');
	define('t_sesiones', 	DB_PREF.'sesiones');
