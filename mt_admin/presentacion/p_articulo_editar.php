<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la subseccion editar de la seccion pagina
	*/
if( isset($_GET['id']) ){
	if( isset($_GET['guardar']) ){
		$datos = array(
			'id' => $_GET['id'],
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
		if( $entrada->editarArticulo($datos) ) echo json_encode(array('result' => 1, 'error' => 0));
		else echo json_encode(array('result' => 0, 'error' => $entrada->error));
		exit();
	}

	//Obtenemos los datos del articulo a editar
	$datos_articulo = extras::htmlentities($entrada->listarArticulo($_GET['id']));
	//verificamos si exite el articulo
	if($datos_articulo) $plantilla->setEtiqueta(array(
		'entrada_id' => $datos_articulo['id'],
		'entrada_titulo' => $datos_articulo['titulo'],
		'entrada_url' => $datos_articulo['url'],
		'entrada_fecha' => $datos_articulo['fecha'],
		'entrada_descrip' => $datos_articulo['descrip'],
		'entrada_contenido' => $datos_articulo['contenido'],
		'entrada_categoria' => $datos_articulo['categoria'],
		'entrada_categoria_id' => $datos_articulo['categoria_id'],
		'entrada_categoria_url' => $datos_articulo['categoria_url'],
		'entrada_portada' => $datos_articulo['portada'],
		'entrada_autor' => $datos_articulo['autor'],
		'entrada_estado' => $datos_articulo['estado'],
		'entrada_tags' => $datos_articulo['tags'],
		'entrada_manga_api' => $datos_articulo['manga_api'],
		'entrada_manga_api_id' => $datos_articulo['manga_api_id'],
	));
	else header('location: articulo?error');

	//Creamos bloque dinamico con la lista de estados
	require "inclusiones/inc_estados.php";
	foreach ($estados as $key => $value) {
		if( $datos_articulo['estado'] == $value['id'] ) $estados[$key]['active'] = 'selected';
		else $estados[$key]['active'] = '';
	}
	$plantilla->setBloque('lista_estados', $estados, array('id', 'nombre', 'selected'));

	$contimport = array(
		1 => array('id' => 1, 'nombre' => 'Ninemanga'),
		2 => array('id' => 2, 'nombre' => 'Tumangaonline'),
	);
	foreach ($contimport as $key => $value) {
		if( $datos_articulo['manga_api'] == $value['id'] ) $contimport[$key]['active'] = 'selected';
		else $contimport[$key]['active'] = '';
	}
	$plantilla->setBloque('lista_contimport', $contimport, array('id', 'nombre', 'selected'));

	//Creamos bloque dinamico con la lista de las categorias
	$lista_categorias = $entrada->listarMenuCategorias();
	foreach ($lista_categorias as $key => $value) {
		if( $datos_articulo['categoria_id'] == $value['id'] ) $lista_categorias[$key]['active'] = 'selected';
		else $lista_categorias[$key]['active'] = '';
	}
	$plantilla->setBloque(
		'lista_categorias', $lista_categorias, array('id', 'nombre', 'selected')
	);

	$plantilla->display($plantilla->getHTML('articulo-editar'));
}else header('location: articulo?error');
