<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
    /*
    * Archivo de seccion - Acceso
    */

    //Determinamos y mostramos la presentacion de la seccion o subseccion solicitada
    $accion = 'login';
    if( isset( $_GET['accion'] ) ) $accion = $_GET['accion'];
    if(      $accion == 'claveperdida' ) require "presentacion/p_acceso_claveperdida.php";
    else if( $accion == 'restablececlave' ) require "presentacion/p_acceso_restablececlave.php";
    else require "presentacion/p_acceso.php";
