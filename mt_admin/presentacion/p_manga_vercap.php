<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	if( isset($_GET['id']) ) $_GET['id'] = (INT) $_GET['id'];
	else die("Error: Se requiere la id del manga para continuar");
	//Obtenemos lista de capitulos
	$lista_articulos = extras::htmlentities($entrada->listarMangaCapsId($_GET['id']), true);

	//Creamos bloque dinamico con la lista de articulos
	$plantilla->setBloque('lista_articulos', $lista_articulos, array(
		'articulo_id',
		'articulo_titulo',
		'articulo_descrip',
		'articulo_fecha',
	));

	$plantilla->setEtiqueta("id_cap", $_GET['id']);
	$plantilla->display($plantilla->getHTML('manga-vercap'));
