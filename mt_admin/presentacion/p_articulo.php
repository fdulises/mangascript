<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la seccion articulo
	*/

	//Obtenemos lista de articulos
	$artlimit = 50;
	$entopc = array(
		'paginacion' => true,
		'limite' => $artlimit,
	);
	if( isset( $_GET['b'] ) ){
		$_GET['b'] = dbConector::escape(extras::addslashes($_GET['b']));
		$entopc['busqueda'] = $_GET['b'];
	}
	$lista_articulos = extras::htmlentities($entrada->listarArticulos($entopc), true);
	//Generamos la paginación para la lista de articulos
	$total_articulos = $entrada->foundRows();
	$pnum = isset( $_GET['pagina'] ) ? (INT) $_GET['pagina'] : 1;
	$totalpags = ceil( $total_articulos / $artlimit );
	$pnum = ( $pnum <= 0 ) ? 1 : $pnum;
	$beacon = ( $pnum <= 1 ) ? '' : '$1';
	$bescon = ( $pnum >= $totalpags ) ? '' : '$1';
	$plantilla->setPatron('/\{bloque_enlace_a\}(.*?)\{\/bloque_enlace_a\}/is', $beacon);
	$plantilla->setPatron('/\{bloque_enlace_s\}(.*?)\{\/bloque_enlace_s\}/is', $bescon);
	$enlace_pag_a = ( $pnum <= 1 ) ? 1: $pnum-1;
	$enlace_pag_s = ( $pnum >= $totalpags ) ? $totalpags : $pnum+1;
	$plantilla->setEtiqueta('enlace_pag_a', "?pagina={$enlace_pag_a}");
	$plantilla->setEtiqueta('enlace_pag_s', "?pagina={$enlace_pag_s}");

	//Damos formato a los campos que lo necesitan
	foreach ($lista_articulos as $k => $v){
		if( $v['categoria_id'] == 0 ) $lista_articulos[$k]['categoria'] = 'Sin categoría';
	}
	//Creamos bloque dinamico con la lista de articulos
	$plantilla->setBloque('lista_articulos', $lista_articulos, array(
		'articulo_id',
		'articulo_titulo',
		'articulo_url',
		'articulo_fecha',
		'articulo_usuario',
		'articulo_categoria',
		'articulo_categoria_id',
		'articulo_categoria_url',
		'articulo_estado',
		'articulo_total_c',
		'articulo_capitulos',
		'articulo_enlace',
	));
	//Mostramos la interfaz
	$plantilla->display($plantilla->getHTML('articulo-listar'));
