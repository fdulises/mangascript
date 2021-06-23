<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la subseccion ver de la seccion articulo
	*/

	if( isset($_GET['id']) ){
		$datos_articulo = $entrada->listarArticulo($_GET['id']);
		$plantilla->setEtiqueta(array(
			'entrada_id' => $datos_articulo['id'],
			'entrada_titulo' => $datos_articulo['titulo'],
			'entrada_url' => $datos_articulo['url'],
			'entrada_fecha' => $datos_articulo['fecha'],
			'entrada_descrip' => $datos_articulo['descrip'],
			'entrada_contenido' => $datos_articulo['contenido'],
			'entrada_categoria' => $datos_articulo['categoria'],
			'entrada_categoria_id' => $datos_articulo['categoria_id'],
			'entrada_categoria_url' => $datos_articulo['categoria_url'],
			'entrada_portada' => $datos_articulo['portada'],
			'entrada_autor' => $datos_articulo['autor'],
			'entrada_estado' => $datos_articulo['estado'],
			'entrada_tags' => $datos_articulo['tags'],
		));
		$plantilla->display($plantilla->getHTML('articulo-ver'));
	}else die("Error con la entrada solicitada");
