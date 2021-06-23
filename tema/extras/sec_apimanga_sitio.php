<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	if( !isset($_GET['id']) ) exit();
	
	$_GET['id'] = (INT) $_GET['id'];
	$_GET['p'] = isset( $_GET['p'] ) ? $_GET['p'] : 1;
	
	$mangacap = $mt->getEntrada(array(
		'id' => $_GET['id'],
		'columnas' => array(
			'e.id as pagid',
			'e.titulo as pagtitle',
			'e.contenido as pages',
		),
		'tipo' => 3,
	));
	if($mangacap){
		$mangacap['pages'] = explode(',', $mangacap['pages']);
		$mangacap['pagtotal'] = count($mangacap['pages']);
		echo json_encode($mangacap);
	}else{
		echo json_encode(array(
			'pagid' => 0,
			'pagtitle' => '',
			'pages' => array(),
			'pagtotal' => 0,
		));
	}