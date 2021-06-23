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

	$estado = 1;

	require "sec_apimanga_serie.php";
	if( isset($mangaslug[2], $_GET['all']) ){
		$listaall = array();
		$estado = 0;
		--$mangaslug[2];
		$capituloslug = $mangadatos['caps'][$mangaslug[2]]['id'];
		$capnum = 1;
		require "sec_apimanga_pag.php";
		$listaall['pagid'] = $mangaslug[2]+1;
		$listaall['pagtitle'] = $capdatos['pagtitle'];
		$listaall['pagtotal'] = $capdatos['pagtotalcaps'];
		$listaall['pages'] = array();
		for($i=1; $i<=$listaall['pagtotal']; $i++){
			$capnum = $i;
			require "sec_apimanga_pag.php";
			$listaall['pages'][] = $capdatos['pagimg'];
		}
		echo json_encode($listaall);
	}else if( !isset( $mangaslug[2] ) ){
		echo json_encode($mangadatos);
	}else{
		--$mangaslug[2];
		$capituloslug = $mangadatos['caps'][$mangaslug[2]]['id'];
		$capnum = 1;
		if( isset( $mangaslug[3] ) ) $capnum = $mangaslug[3];
		require "sec_apimanga_pag.php";
	}
