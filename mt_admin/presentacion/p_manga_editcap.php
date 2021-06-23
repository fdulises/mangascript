<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	if( isset($_GET['id']) ) $_GET['id'] = (INT) $_GET['id'];
	else die("Error: Se requiere la id del manga para continuar");

	if( isset($_GET['guardar'], $_GET['coleccion']) ){
		$datos = array(
			'id' => $_GET['id'],
			'titulo' => '',
			'contenido' => '',
			'descrip' => '',
			'portada' => '',
			'url' => 'null',
			'estado' => '1',
			'tags' => '',
			'categoria' => $_GET['coleccion'],
		);
		if( isset( $_POST['titulo'] ) ) $datos['titulo'] = $_POST['titulo'];
		if( isset( $_POST['paginas'] ) ) $datos['contenido'] = $_POST['paginas'];
		if( isset( $_POST['idcapitulo'] ) ) $datos['descrip'] = $_POST['idcapitulo'];
		//Mostramos datos en json con el resultado
		if( $entrada->editarArticulo($datos) ) echo json_encode(array('result' => 1, 'error' => 0));
		else echo json_encode(array('result' => 0, 'error' => $entrada->error));
		exit();
	}


	//Obtenemos los datos del articulo a editar
	$datos_articulo = extras::htmlentities($entrada->listarManga($_GET['id']));
	if($datos_articulo){
		$datos_articulo['contenido'] = explode(',', $datos_articulo['contenido']);
		$lista_manga_paginas = array();
		foreach ($datos_articulo['contenido'] as $k => $v) {
			$actual = array();
			$actual['imgurl'] = $v;
			$lista_manga_paginas[] = $actual;
		}
		$plantilla->setBloque('lista_manga_paginas', $lista_manga_paginas, array('imgurl'));
		$plantilla->setEtiqueta(array(
			'entrada_id' => $datos_articulo['id'],
			'entrada_titulo' => $datos_articulo['titulo'],
			'entrada_url' => $datos_articulo['url'],
			'entrada_descrip' => $datos_articulo['descrip'],
			'entrada_coleccion' => $datos_articulo['coleccion'])
		);
	}//else header('location: manga?error');

	$plantilla->display($plantilla->getHTML('manga-editcap'));
