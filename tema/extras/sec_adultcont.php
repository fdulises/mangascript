<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	//Determinamos el slug del manga a mostrar
	if( isset( $_GET['id'] ) ) $enlace = $_GET['id'].'?adultcont';
	else header('location: inicio');

	$mt->plantilla->setEtiqueta('enlace_adult', $enlace);

	$mt->plantilla->display('tpl/adultcont');
