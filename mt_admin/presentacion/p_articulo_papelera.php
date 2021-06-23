<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la subseccion papelera de la seccion pagina
	*/

	$lista_entradas = $entrada->listarArticulosPapelera();

	$plantilla->setBloque('lista_entradas', $lista_entradas,
		array(
		'entrada_id', 'entrada_titulo', 'entrada_url', 'entrada_fecha', 'entrada_usuario',
		'entrada_estado', 'entrada_categoria', 'entrada_categoria_url', 'entrada_categoria_id'
		)
	);

	$plantilla->display($plantilla->getHTML('articulo-papelera'));
