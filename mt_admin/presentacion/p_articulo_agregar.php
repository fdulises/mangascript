<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la subseccion agregar de la seccion pagina
	*/

	if( isset($_GET['guardar']) ){
		$datos = array(
			'titulo' => '',
			'contenido' => '',
			'descrip' => '',
			'portada' => '',
			'url' => '',
			'estado' => '',
			'categoria' => '',
			'tags' => '',
			'manga_api' => '',
			'manga_api_id' => '',
		);
		if( isset( $_POST['titulo'] ) ) $datos['titulo'] = $_POST['titulo'];
		if( isset( $_POST['contenido'] ) ) $datos['contenido'] = $_POST['contenido'];
		if( isset( $_POST['descrip'] ) ) $datos['descrip'] = $_POST['descrip'];
		if( isset( $_POST['portada'] ) ) $datos['portada'] = $_POST['portada'];
		if( isset( $_POST['estado'] ) ) $datos['estado'] = $_POST['estado'];
		if( isset( $_POST['url'] ) ) $datos['url'] = $_POST['url'];
		if( isset( $_POST['categoria'] ) ) $datos['categoria'] = $_POST['categoria'];
		if( isset( $_POST['tags'] ) ) $datos['tags'] = $_POST['tags'];
		if( isset( $_POST['manga_api'] ) ) $datos['manga_api'] = $_POST['manga_api'];
		if( isset( $_POST['manga_api_id'] ) ) $datos['manga_api_id'] = $_POST['manga_api_id'];
		//Mostramos datos en json con el resultado
		if( $entrada->agregarArticulo($datos) )
			echo json_encode(array('result' => 1, 'error' => 0));
		else
			echo json_encode(array('result' => 0, 'error' => $entrada->error));
		exit();
	}

	//Creamos bloque dinamico con la lista de estados
	require "inclusiones/inc_estados.php";
	$plantilla->setBloque('lista_estados', $estados, array('id', 'nombre'));

	//Creamos bloque dinamico con la lista de las categorias
	$plantilla->setBloque(
		'lista_categorias', $entrada->listarMenuCategorias(), array('id', 'nombre')
	);

	$plantilla->display($plantilla->getHTML('articulo-agregar'));
