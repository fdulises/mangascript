<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	/*
	* Archivo principal del sitema - Frontcontroller
	*
	* Recibe y procesa todas las peticiones
	*/

	require 'mt_config/conf_db.php';
	require 'mt_config/conf_sitio.php';
	require 'mt_config/conf_db_tablas.php';
	require 'mt_config/conf_secciones.php';

	require 'mt_nucleo/librerias/'.DB_CONECTOR.'.php';
	require 'mt_nucleo/librerias/dbConsultas.php';
	require 'mt_nucleo/librerias/templates.php';
	require 'mt_nucleo/librerias/phpHooks.php';
	require 'mt_nucleo/librerias/mtExtras.php';
	require 'mt_nucleo/librerias/basicache.php';
	require 'mt_nucleo/librerias/getterdatos.php';
	require 'mt_nucleo/librerias/apilector1.php';

	require 'mt_nucleo/datos/db_sitio.php';
	require 'mt_nucleo/datos/db_entrada.php';

	require 'mt_nucleo/logica/l_mt.php';
	require 'mt_nucleo/logica/l_entrada.php';

	require 'mt_nucleo/librerias/recaptcha-master/src/autoload.php';


	$mt = mt::getInstance();
	//Incluimos el archivo de configuracion de la plantilla
	if( file_exists( "{$mt->getInfo('tema_url')}/config.php" ) )
	require "{$mt->getInfo('tema_url')}/config.php";

	//Obtenemos e insertamos el facade de la seccion solicitada
	$mt->getSeccion();
	if( file_exists($mt->seccion['filesec']) ){
		require 'mt_config/conf_plantilla.php';
		require $mt->seccion['filesec'];
	}else die('Error: No se encontro la sección solicitada');
