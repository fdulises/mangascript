<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la subseccion editar de la seccion categoria
	*/
if( isset($_GET['id']) ){
	if( isset($_GET['guardar']) ){
		$datos = array(
			'id' => $_GET['id'],
			'nombre' => '',
			'url' => '',
			'descrip' => '',
		);
		if( isset( $_POST['nombre'] ) ) $datos['nombre'] = $_POST['nombre'];
		if( isset( $_POST['url'] ) ) $datos['url'] = $_POST['url'];
		if( isset( $_POST['descrip'] ) ) $datos['descrip'] = $_POST['descrip'];
		//Mostramos datos en json con el resultado
		if( $entrada->editarCategoria($datos) ) echo json_encode(array('result' => 1, 'error' => 0));
		else echo json_encode(array('result' => 0, 'error' => $entrada->error));
		exit();
	}

	$categoria_datos = $entrada->listarCategoria($_GET['id']);
	//verificamos si exite la categoria
	if($categoria_datos)
		$plantilla->setEtiqueta(array(
			'categoria_id' => $categoria_datos['id'],
			'categoria_nombre' => $categoria_datos['nombre'],
			'categoria_url' => $categoria_datos['url'],
			'categoria_descrip' => $categoria_datos['descrip'],
		));
	else header('location: articulo?error');

	$plantilla->display($plantilla->getHTML('categoria-editar'));
}else header('location: categoria');
