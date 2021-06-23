<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la subseccion agregar de la seccion categoria
	*/

	if( isset($_GET['guardar']) ){
		$datos = array(
			'nombre' => '',
			'url' => '',
			'descrip' => '',
			'tipo' => '',
			'superior' => '',
		);
		if( isset( $_POST['nombre'] ) ) $datos['nombre'] = $_POST['nombre'];
		if( isset( $_POST['url'] ) ) $datos['url'] = $_POST['url'];
		if( isset( $_POST['descrip'] ) ) $datos['descrip'] = $_POST['descrip'];
		//Mostramos datos en json con el resultado
		if( $entrada->creaCategoria($datos) )
			echo json_encode(array('result' => 1, 'error' => 0));
		else
			echo json_encode(array('result' => 0, 'error' => $entrada->error));
		exit();
	}

	$plantilla->display($plantilla->getHTML('categoria-agregar'));
