<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	//Determinalos la url del manga
	$urlmanga = "http://es.ninemanga.com/manga/{$mangaslug1}.html";
	if( isset($_GET['warning']) ) $urlmanga .= '?waring=1';

	$cachedir = 'mt_cache/cache_manga';
	$contenido = basicache::get($cachedir, $mangaslug1);

	if( $contenido ) $mangadatos = unserialize($contenido);
	else{
		//Obtenemos el contenido del sitio
		$getter = new getterdatos($urlmanga);
		$generalinfo = $getter->getCadena('/<div class="bookintro">(.*?)<\/div>/is');

		//Obtenemos la lista de capitulos
		$capshtml = $getter->getCadena('/<div class="silde">(.*?)<\/div>/is');
		if( !$capshtml && !isset($_GET['warning']) ) header("location: {$mt->getInfo('url')}/apimanga/{$mangaslug1}?warning");
		$capshtmllist = $getter->getCadenaPatron($capshtml, '/<a class="chapter_list_a"(.*?)<\/a>/i', true);
		if( !$capshtmllist ) $capshtmllist = array();
		$capslist = array();
		foreach ($capshtmllist as $v) {
			$actual = array();
			$actual['href'] = $getter->getCadenaPatron($v[1], '/href="(.*?)"/i');
			$actual['title'] = $getter->getCadenaPatron($v[1], '/title="(.*?)"/i');
			$capslist[] = $actual;
		}

		//Obtenemos datos del manga
		$mangadatos = array();
		if( $generalinfo ) $mangadatos['estado'] = 1;
		else $mangadatos['estado'] = 0;
		$mangadatos['cover'] = $getter->getCadenaPatron($generalinfo, '/<img (.*?) src="(.*?)"(.*?)>/i', true)[0][2];
		$mangadatosinfo = $getter->getCadenaPatron($generalinfo, '/<ul class="message">(.*?)<\/ul>/is');
		$mangadatos['titulo'] = $getter->getCadenaPatron($mangadatosinfo, '/<li><b>Nombre del libro:<\/b> <span>(.*?)<\/span><\/li>/i');
		$mangadatosgeneros = $getter->getCadenaPatron($mangadatosinfo, '/<li itemprop="genre">(.*?)<\/li>/is');
		$mangadatosgeneros = $getter->getCadenaPatron($mangadatosgeneros, '/<a href="(.*?)">(.*?)<\/a>/is', true);
		if( !$mangadatosgeneros ) $mangadatosgeneros = array();
		$mangadatos['generos'] = array();
		foreach ($mangadatosgeneros as $k => $v) $mangadatos['generos'][] = $v[2];
		$mangadatos['autor'] = $getter->getCadenaPatron($mangadatosinfo,
			'/<a itemprop="author" href="(.*?)">(.*?)<\/a>/i', true
		)[0][2];
		$mangadatos['descrip'] = $getter->getCadena('/<p itemprop="description">(.*?)<\/p>/is');

		$mangadatos['caps'] = array();
		foreach ($capslist as $k => $v) {
			$actualv = array();
			$actualv['title'] = $v['title'];
			$actualmatch = $getter->getCadenaPatron($v['href'], '/chapter\/(.*?)\/(.*?).html/', true);
			$actualv['id'] = $actualmatch[0][2];
			$mangadatos['caps'][] = $actualv;
		}
		$mangadatos['caps'] = array_reverse($mangadatos['caps']);
		basicache::put($cachedir, $mangaslug1, serialize($mangadatos), (7*24*60*60));
	}
