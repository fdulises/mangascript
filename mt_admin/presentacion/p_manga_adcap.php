<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	if( isset($_GET['guardar']) ){
		$datos = array(
			'titulo' => '',
			'idcapitulo' => '',
			'paginas' => '',
			'mangaid' => '',
		);
		if( isset( $_POST['titulo'] ) ) $datos['titulo'] = $_POST['titulo'];
		if( isset( $_POST['idcapitulo'] ) ) $datos['idcapitulo'] = $_POST['idcapitulo'];
		if( isset( $_POST['paginas'] ) ) $datos['paginas'] = $_POST['paginas'];
		if( isset( $_GET['id'] ) ) $datos['mangaid'] = (INT) $_GET['id'];
		//Mostramos datos en json con el resultado
		if( $entrada->agregarMangaCap($datos) )
			echo json_encode(array('result' => 1, 'error' => 0));
		else
			echo json_encode(array('result' => 0, 'error' => $entrada->error));
		exit();
	}
	if( isset($_GET['id']) ) $_GET['id'] = (INT) $_GET['id'];
	else die("Error: Se requiere la id del manga para continuar");

	$plantilla->setEtiqueta('entrada_id', $_GET['id']);

	$plantilla->display($plantilla->getHTML('manga-adcap'));
