<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	if( !isset($_GET['id']) ) die("<h1>Error 404: Página no encontrada</h1>");
	$api = new apilector1;
	if( isset($_GET['cap']) ) --$_GET['cap'];

	if( isset($_GET['cap']) && !isset($_GET['all'])  ){
		$getcap = ( isset($_GET['cap']) ) ? (INT) $_GET['cap'] : 0;
		$getpag = ( isset($_GET['pag']) ) ? (INT) $_GET['pag'] : 0;
		echo json_encode( $api->getCap($getcap, $getpag) );
	}else if( isset($_GET['cap'], $_GET['all']) ){
		$getcap = ( isset($_GET['cap']) ) ? (INT) $_GET['cap'] : 0;
		echo json_encode( $api->getCapFull($getcap) );
	}else{
		echo json_encode($api->datos);
	}
