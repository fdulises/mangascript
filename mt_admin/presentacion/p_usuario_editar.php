<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
  /*
  * Archivo de presentacion para la subseccion editar de la seccion usuario
  */

	if( isset($_GET['guardar']) && isset($_GET['id']) ){
		$datos = array(
			'id' => $_GET['id'],
			'email' => '',
			'clave' => '',
			'grupo' => '',
			'nombre' => '',
			'descrip' => '',
			'sitio' => '',
		);
		if( isset( $_POST['email'] ) ) $datos['email'] = $_POST['email'];
		if( isset( $_POST['clave'] ) ) $datos['clave'] = $_POST['clave'];
		if( isset( $_POST['grupo'] ) ) $datos['grupo'] = $_POST['grupo'];
		if( isset( $_POST['nombre'] ) ) $datos['nombre'] = $_POST['nombre'];
		if( isset( $_POST['descrip'] ) ) $datos['descrip'] = $_POST['descrip'];
		if( isset( $_POST['sitio'] ) ) $datos['sitio'] = $_POST['sitio'];
		//Mostramos datos en json con el resultado
		if( $usuario->editar($datos) ) echo json_encode(array('result' => 1, 'error' => 0));
		else echo json_encode(array('result' => 0, 'error' => $usuario->error));
		exit();
	}

	//Obtenemos los datos del usuario solicitado
	if( !isset( $_GET['id'] ) ) die(header('location: usuario?error=no_id'));
	$datos_usuario = $usuario->listarById($_GET['id']);
	//verificamos si exite el usuario
	if($datos_usuario)
		//Definimos etiquetas con los datos del usuario solicitado
		$plantilla->setEtiqueta(array(
			'usuario_id' => $datos_usuario['id'],
			'usuario_nickname' => $datos_usuario['nickname'],
			'usuario_email' => $datos_usuario['email'],
			'usuario_grupo' => $datos_usuario['grupo'],
			'usuario_nombre' => $datos_usuario['nombre'],
			'usuario_descrip' => $datos_usuario['descrip'],
			'usuario_sitio' => $datos_usuario['sitio'],
		));
	else header('location: articulo?error');

	//Definimos bloque dinamico con el grupo del usuario
	$lista_grupos = array();
	foreach ($grupos as $k => $v) {
		$fila = $v;
		$fila['active'] = '';
		if( $datos_usuario['grupo'] == $v['id'] ) $fila['active'] = 'selected';
		$lista_grupos[$k] = $fila;
	}
	$plantilla->setBloque('lista_grupos', $lista_grupos, array('id', 'nombre', 'selected'));

	//Mostramos la interfaz de la seccion
	$plantilla->display($plantilla->getHTML('usuario-editar'));
