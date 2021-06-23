<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	$lista_articulos = $mt->getEntrada(array(
		'columnas' => array(
			'e.id as articulo_id',
			'e.titulo as articulo_titulo',
			'e.portada as articulo_portada',
			'e.descrip as articulo_descrip',
			'e.fecha_u as articulo_fecha',
			'e.total_coment as articulo_comentarios',
			'col.nombre as articulo_coleccion_nombre',
			'enlace as articulo_enlace',
		),
		'tipo' => 2,
		'orden' => 'e.fecha_u',
		'disp' => 'DESC',
		'paginacion' => true,
	));

	//Mostramos/ocultamos contendor de articulos
	$mt->plantilla->setCondicion('si_articulos', count($lista_articulos['entradas']));
	$mt->plantilla->setBloque('lista_articulos', $lista_articulos['entradas']);

	//Generamos etiquetas con la ruta de las paginas anterior/siguiente
	$paginacion_cond = ( $lista_articulos['paginacion']['enlace_a'] || $lista_articulos['paginacion']['enlace_s']);
	$mt->plantilla->setCondicion('si_paginacion', $paginacion_cond);
	$mt->plantilla->setCondicion('is_paginacion_a', $lista_articulos['paginacion']['enlace_a']);
	$mt->plantilla->setCondicion('is_paginacion_s', $lista_articulos['paginacion']['enlace_s']);
	$mt->plantilla->setEtiqueta(array(
		'paginacion_enlace_a' => "{$mt->seccion['enlace']}/pagina/{$lista_articulos['paginacion']['enlace_a']}",
		'paginacion_enlace_s' => "{$mt->seccion['enlace']}/pagina/{$lista_articulos['paginacion']['enlace_s']}",
	));

	$mt->plantilla->setBloque('lista_20ent', $mt->getEntrada(array(
		'columnas' => array(
			'e.id as articulo_id',
			'e.titulo as articulo_titulo',
			'e.portada as articulo_portada',
			'e.descrip as articulo_descrip',
			'e.fecha_u as articulo_fecha',
			'e.total_coment as articulo_comentarios',
			'col.nombre as articulo_coleccion_nombre',
			'enlace as articulo_enlace',
		),
		'tipo' => 2,
		'orden' => 'e.total_coment',
		'disp' => 'DESC',
		'limit' => 18,
		'filtro' => "( (tags LIKE '%aventura%') OR (tags LIKE '%comedia%') OR (tags LIKE '%accion%') )",
	)));

	$mt->plantilla->setBloque('lista_articulos_1', $mt->getEntrada(array(
		'columnas' => array(
			'e.id as articulo_id',
			'e.titulo as articulo_titulo',
			'e.portada as articulo_portada',
			'e.descrip as articulo_descrip',
			'e.fecha_u as articulo_fecha',
			'e.total_coment as articulo_comentarios',
			'col.nombre as articulo_coleccion_nombre',
			'enlace as articulo_enlace',
		),
		'tipo' => 2,
		'orden' => 'e.titulo',
		'disp' => 'DESC',
		'limit' => 4,
		'filtro' => "tags LIKE '%yuri%'",
	)));
	$mt->plantilla->setBloque('lista_articulos_2', $mt->getEntrada(array(
		'columnas' => array(
			'e.id as articulo_id',
			'e.titulo as articulo_titulo',
			'e.portada as articulo_portada',
			'e.descrip as articulo_descrip',
			'e.fecha_u as articulo_fecha',
			'e.total_coment as articulo_comentarios',
			'col.nombre as articulo_coleccion_nombre',
			'enlace as articulo_enlace',
		),
		'tipo' => 2,
		'orden' => 'e.titulo',
		'disp' => 'DESC',
		'limit' => 4,
		'filtro' => "tags LIKE '%accion%'",
	)));

	$mt->plantilla->display('tpl/blog');
