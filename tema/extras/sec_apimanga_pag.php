<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	//Determinalos la url del manga y obtenemos contenido
	$urlmanga = "http://es.ninemanga.com/chapter/{$mangaslug1}/{$capituloslug}-{$capnum}.html";
	$getter = new getterdatos($urlmanga);

	$capdatos = array();

	$capdatosid = explode('-', $capituloslug);
	$capdatos['pagid'] = $capdatosid[0];
	$capdatos['pagnum'] = ( isset( $capdatosid[1] ) ? $capdatosid[1] : 1 );
	$capdatos['pagslug1'] = $mangaslug1;
	$capdatos['pagslug'] = $getter->getCadena('/chapter\/(.*?)\/(.*?).html/is');
	$capdatos['pagimg'] = $getter->getCadena('/<img class="(.*?)" i="1" e="1" src="(.*?)"(.*?)\/>/is', true)[0][2];
	$capdatos['pagtitle'] = $getter->getCadena('/<meta property="og:title" content="(.*?)"\/>/is');

	$capdatosopciones = $getter->getCadena('/<select(.*?)id="(chapter|page)"(.*?)>(.*?)<\/select>/is', true);

	$pagtotalcaps = $getter->getCadenaPatron($capdatosopciones[0][4], '/<option(.*?)>(.*?)<\/option>/is', true);
	$capdatos['pagtotalcaps'] = count($pagtotalcaps);

	$listatotalcaps = array();
	if( !$pagtotalcaps ) $pagtotalcaps = array();
	foreach($pagtotalcaps as $k => $v){
		$actualmatch = $getter->getCadenaPatron($v[1], '/chapter\/(.*?)\/(.*?).html/', true);
		$listatotalcaps[] = $actualmatch[0][2];
	}
	$listatotalcaps = array_reverse($listatotalcaps);

	$pagtotal = $getter->getCadenaPatron($capdatosopciones[1][4], '/<option(.*?)>(.*?)<\/option>/is', true);
	$capdatos['pagtotal'] = count($pagtotal);

	$capdatos['pagactual'] = $capnum;
	$capdatos['paganterior'] = ( ($capnum-1) > 0 ) ? $capnum-1 : 1;
	$capdatos['pagsiguiente'] = ( ($capnum+1) <= $capdatos['pagtotal'] ) ? $capnum+1 : $capdatos['pagtotal'];

	$capactual = array_search($capdatos['pagid'], $listatotalcaps);
	$capdatos['capanterior'] = ( ($capactual-1)>=0 ) ? $listatotalcaps[$capactual-1] : '';
	$capdatos['capsiguiente'] = ( ($capactual+1)<(count($listatotalcaps)) ) ? $listatotalcaps[$capactual+1] : '';

	if( $estado == 1 ) echo json_encode($capdatos);
