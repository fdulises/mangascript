<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	/* Archivo principal de la aplicacion */

	//Incluimos todos los archivos rqueridos por la aplicacion
	require '../mt_config/conf_db.php';
	require 'inclusiones/inc_config.php';
	require 'inclusiones/inc_grupos.php';
	require 'logica/dbConector.php';
	require 'logica/extras.php';
	require 'logica/principal.php';
	require 'logica/usuario.php';
	require 'logica/entrada.php';
	require 'logica/templates.php';
	require 'logica/correos.php';

	//Instanciamos las clases de la aplicacion
	$principal = new principal;
	$usuario = new usuario;
	$entrada = new entrada;
	$plantilla = new templates(TEMA_DIR, TEMA_EXT);
	correos::setPlantilla();

	//Verificamos que se haya iniciado sesion para poder acceder a las secciones protegidas
	if( !$usuario->logingCheck() &&
		( $principal->seccion['nombre'] != 'acceso' )
	) header('location: acceso');

	//Incluimos la seccion solicitada
	if( file_exists($principal->seccion['ruta']) ){
		require 'inclusiones/inc_config_plantilla.php';
		require $principal->seccion['ruta'];
	}else die("Ocurrio un error con la sección solicitada.");
