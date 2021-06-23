<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Facade para la seccion lector
	*/

	//Determinamos el slug del manga a mostrar
	$mangaslug = ( isset($_GET['url']) ) ? rtrim( $_GET['url'], '/' ) : '';
	$mangaslug = explode('/', $mangaslug);
	$mangaslug1 = ( isset($mangaslug[1]) ) ? $mangaslug[1] : '';

	$mangaslug1 = rawurlencode($mangaslug1);
	$urlapi = "{$mt->getInfo('url')}/apimanga/{$mangaslug1}";
	$contenido = json_decode(file_get_contents($urlapi));

	$capnum = 0;
	$mangapage = 1;
	$subsec = 'inicio';
	if( isset( $mangaslug[2] ) ){
		 $capnum = (INT) $mangaslug[2];
		 $subsec = 'capitulo';
		 if( isset( $mangaslug[3] ) ) $mangapage = $mangaslug[3];
	}
	if( $capnum < 0 ) $capnum = 0;
	if( !isset($contenido->caps[$capnum]) ) die( "<h1>Error 404: Página no encontrada</h1>" );

	$capnums = array(
		'cap' => $capnum+1,
		'pag' => $mangapage,
	);
	$capcont = json_decode(file_get_contents("{$urlapi}/{$capnums['cap']}/{$capnums['pag']}"));

	foreach ($contenido->generos as $k => $v) {
		$contenido->generos[$k] = "<a class=\"manga_cat\" href=\"{$mt->getInfo('url')}/busqueda?b={$v}\">{$v}</a>";
	}
	$contenido->generos = implode(' ', $contenido->generos);

	$lista_capitulos = array();
	foreach ($contenido->caps as $k => $v) {
		$actual = array();
		$actual['title'] = $v->title;
		$actual['id'] = $v->id;
		$numactual = $k;
		$actual['enlace'] = "{$mt->seccion['enlace']}/{$mangaslug1}/{$numactual}";
		$lista_capitulos[] = $actual;
	}

	if( $capcont->paganterior == $capcont->pagactual ) $capcont->paganterior = 0;
	if( $capcont->pagsiguiente == $capcont->pagactual ) $capcont->pagsiguiente = 0;

	$mt->plantilla->setEtiqueta(array(
		'pagina_titulo' => $contenido->titulo,
		'manga_cover' => $contenido->cover,
		'manga_title' => $contenido->titulo,
		'manga_descrip' => $contenido->descrip,
		'manga_autor' => $contenido->autor,
		'manga_generos' => $contenido->generos,
		'manga_pagina' => $capcont->pagimg,
		'manga_pagina_title' => $capcont->pagtitle,
		'manga_pagina_anterior' => "{$mt->seccion['enlace']}/{$mangaslug1}/{$capnum}/{$capcont->paganterior}",
		'manga_pagina_siguiente' => "{$mt->seccion['enlace']}/{$mangaslug1}/{$capnum}/{$capcont->pagsiguiente}",
		'manga_slug' => $capcont->pagslug,
	));
	$mt->plantilla->setBloque('lista_capitulos', $lista_capitulos);

	$paginacion_cond = ("{$mt->seccion['enlace']}/{$mangaslug1}/{$capnum}/{$capcont->paganterior}" || "{$mt->seccion['enlace']}/{$mangaslug1}/{$capnum}/{$capcont->pagsiguiente}");
	$mt->plantilla->setCondicion('si_paginacion', $paginacion_cond);
	$mt->plantilla->setCondicion('is_paginacion_a', $capcont->paganterior);
	$mt->plantilla->setCondicion('is_paginacion_s', $capcont->pagsiguiente);

	$mt->plantilla->setEtiqueta('pagina_enlace_manga', "{$mt->getInfo('url')}/lector/{$mangaslug1}");

	$tplsec = 'tpl/lector';
	if( $subsec == 'capitulo' ) $tplsec = 'tpl/lector_capitulo';
	$mt->plantilla->display($tplsec);
