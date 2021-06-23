<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	$cadenabusqueda = '';
	if( isset( $_GET['b'] ) ) $cadenabusqueda = trim($_GET['b']);
	$opciones = array(
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
		'disp' => 'ASC',
		'paginacion' => true,
		'limit' => 10,
	);
	if( str_word_count($cadenabusqueda) < 2 ){
		$opciones['filtro'] = "(
			e.titulo LIKE '%{$cadenabusqueda}%' OR
			e.descrip LIKE '%{$cadenabusqueda}%' OR
			e.tags LIKE '%{$cadenabusqueda}%'
		)";
		if( isset( $_GET['filtro'] ) ){
			if( 'l' == $_GET['filtro'] ){
				if( isset( $_GET['fn'] ) ) $opciones['filtro'] = "e.titulo regexp '^[0-9\W].'";
				else $opciones['filtro'] = "e.titulo LIKE '{$cadenabusqueda}%'";
			}
		}
	}else if( $cadenabusqueda ){
		$opciones['busqueda'] = array(
			'campos' => array('e.titulo', 'e.descrip'),
			'cadena' => $cadenabusqueda,
		);
		$opciones['orden'] = 'score';
	}
	$lista_articulos = $mt->getEntrada($opciones);
	
	$lista_cats = $mt->getColeccion(array(
		'columnas' => array('id', 'url', 'nombre'),
	));
	$mt->plantilla->setBloque('lista_cats', $lista_cats);

	$cadenabusqueda = htmlentities($cadenabusqueda);
	$mt->plantilla->setEtiqueta('pagina_titulo', "Lista de mangas: {$cadenabusqueda}");

	//Mostramos/ocultamos contendor de articulos
	$mt->plantilla->setCondicion('si_articulos', count($lista_articulos['entradas']));
	$mt->plantilla->setBloque('lista_articulos', $lista_articulos['entradas']);

	//Generamos etiquetas con la ruta de las paginas anterior/siguiente
	$paginacion_cond = ( $lista_articulos['paginacion']['enlace_a'] || $lista_articulos['paginacion']['enlace_s']);
	$mt->plantilla->setCondicion('si_paginacion', $paginacion_cond);
	$mt->plantilla->setCondicion('is_paginacion_a', $lista_articulos['paginacion']['enlace_a']);
	$mt->plantilla->setCondicion('is_paginacion_s', $lista_articulos['paginacion']['enlace_s']);
	$enlace_anterior = "{$mt->seccion['enlace']}/pagina/{$lista_articulos['paginacion']['enlace_a']}?b={$cadenabusqueda}";
	$enlace_siguiente = "{$mt->seccion['enlace']}/pagina/{$lista_articulos['paginacion']['enlace_s']}?b={$cadenabusqueda}";
	$mt->plantilla->setEtiqueta(array(
		'paginacion_enlace_a' => $enlace_anterior,
		'paginacion_enlace_s' => $enlace_siguiente,
	));

	$mt->plantilla->display('tpl/busqueda');
