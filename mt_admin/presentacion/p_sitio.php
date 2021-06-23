<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la seccion sitio
	*/

	//Procesamos formulario de edicion de datos de sitio
	if( isset( $_GET['guardar'] ) ){
		$datos = array(
			'titulo' => '',
			'lema' => '',
			'descrip' => '',
			'url' => '',
			'email' => '',
		);
		if( isset( $_POST['titulo'] ) ) $datos['titulo'] = $_POST['titulo'];
		if( isset( $_POST['lema'] ) ) $datos['lema'] = $_POST['lema'];
		if( isset( $_POST['descrip'] ) ) $datos['descrip'] = $_POST['descrip'];
		if( isset( $_POST['url'] ) ) $datos['url'] = $_POST['url'];
		if( isset( $_POST['email'] ) ) $datos['email'] = $_POST['email'];
		//Mostramos datos en json con el resultado
		if( $principal->editarInfo($datos) ) echo json_encode(array('result' => 1, 'error' => 0));
		else echo json_encode(array('result' => 0, 'error' => $principal->error));
		exit();
	}

	//Obtenemos todos los datos del sitio y definimos etiquetas con ellos
	$sitioInfo = $principal->sitioInfo();;
	$plantilla->setEtiqueta(array(
		'sitio_titulo' => $sitioInfo['titulo'],
		'sitio_lema' => $sitioInfo['lema'],
		'sitio_descrip' => $sitioInfo['descrip'],
		'sitio_url' => $sitioInfo['url'],
		'cms_info' => $sitioInfo['cms_info'],
		'cms_v' => $sitioInfo['cms_v'],
		'sitio_email' => $sitioInfo['email'],
	 ));

	$plantilla->display($plantilla->getHTML('sitio-informacion'));
