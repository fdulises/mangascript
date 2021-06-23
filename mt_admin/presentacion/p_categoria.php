<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la seccion categoria
	*/

	$plantilla->setBloque(
		'lista_categorias', $entrada->listarCategorias(),
		array('categoria_id', 'categoria_nombre', 'categoria_url', 'categoria_descrip', 'categoria_total_e')
	);

	$plantilla->display($plantilla->getHTML('categoria-listar'));
