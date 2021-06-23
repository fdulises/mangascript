<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
/*
* Arvhico de seccion - Comentario
*/
//Determinamos y mostramos la presentacion de la seccion o subseccion solicitada
$accion = 'listar';
if( isset( $_GET['accion'] ) ) $accion = $_GET['accion'];
if( $accion == 'ver' ) require "presentacion/p_comentario_ver.php";
else if( $accion == 'editar' ) require "presentacion/p_comentario_editar.php";
else if( $accion == 'eliminar' ) require "presentacion/p_comentario_eliminar.php";
else if( $accion == 'spam' ) require "presentacion/p_comentario_spam.php";
else if( $accion == 'papelera' ) require "presentacion/p_comentario_papelera.php";
else require "presentacion/p_comentario.php";
