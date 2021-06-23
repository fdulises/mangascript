<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
  /*
  * Archivo de presentacion para la subseccion agregar de la seccion pagina
  */

	if( isset($_GET['guardar'], $_GET['id']) ){
		$datos = array(
			'id' => $_GET['id'],
			'titulo' => '',
			'url' => '',
			'descrip' => '',
			'contenido' => '',
			'portada' => '',
			'estado' => '',
			'plantilla' => '',
		);
		if( isset( $_POST['titulo'] ) ) $datos['titulo'] = $_POST['titulo'];
		if( isset( $_POST['url'] ) ) $datos['url'] = $_POST['url'];
		if( isset( $_POST['descrip'] ) ) $datos['descrip'] = $_POST['descrip'];
		if( isset( $_POST['contenido'] ) ) $datos['contenido'] = $_POST['contenido'];
		if( isset( $_POST['portada'] ) ) $datos['portada'] = $_POST['portada'];
		if( isset( $_POST['estado'] ) ) $datos['estado'] = $_POST['estado'];
		if( isset( $_POST['plantilla'] ) ) $datos['plantilla'] = $_POST['plantilla'];
		//Mostramos datos en json con el resultado
		if( $entrada->editarPagina($datos) ) echo json_encode(array('result' => 1, 'error' => 0));
		else echo json_encode(array('result' => 0, 'error' => $entrada->error));
		exit();
	}

	if( isset($_GET['id']) ){
		$datos_pagina = extras::htmlentities($entrada->listarPagina($_GET['id']));
		//verificamos si exite la pagina
		if($datos_pagina)
			$plantilla->setEtiqueta(array(
				'entrada_id' => $datos_pagina['id'],
				'entrada_titulo' => $datos_pagina['titulo'],
				'entrada_url' => $datos_pagina['url'],
				'entrada_fecha' => $datos_pagina['fecha'],
				'entrada_descrip' => $datos_pagina['descrip'],
				'entrada_contenido' => $datos_pagina['contenido'],
				'entrada_superior' => $datos_pagina['superior'],
				'entrada_portada' => $datos_pagina['portada'],
				'entrada_autor' => $datos_pagina['autor'],
				'entrada_estado' => $datos_pagina['estado'],
				'entrada_plantilla' => $datos_pagina['plantilla'],
			));
		else header('location: articulo?error');

		//Creamos bloque dinamico con la lista de estados
		require "inclusiones/inc_estados.php";
		foreach ($estados as $key => $value) {
			if( $datos_pagina['estado'] == $value['id'] ) $estados[$key]['active'] = 'selected';
			else $estados[$key]['active'] = '';
		}
		$plantilla->setBloque('lista_estados', $estados, array('id', 'nombre', 'selected'));

		$plantilla->display($plantilla->getHTML('pagina-editar'));
	}else die("Error con la entrada solicitada");
