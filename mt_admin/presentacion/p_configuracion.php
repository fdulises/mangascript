<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la seccion configuracion del sitio
	*/

	if( isset($_GET['guardar']) ){
		$datos = array(
			'epp' => '',
			'coment' => '',
			'intentos' => '',
			'registro' => '',
			'validaemail' => '',
			'tema_nombre' => '',
			'tema_url' => '',
			'tema_ext' => '',
		);
		if( isset( $_POST['epp'] ) ) $datos['epp'] = $_POST['epp'];
		if( isset( $_POST['comentarios'] ) ) $datos['coment'] = $_POST['comentarios'];
		if( isset( $_POST['intentos'] ) ) $datos['intentos'] = $_POST['intentos'];
		if( isset( $_POST['registro'] ) ) $datos['registro'] = $_POST['registro'];
		if( isset( $_POST['validaemail'] ) ) $datos['validaemail'] = $_POST['validaemail'];
		if( isset( $_POST['tema_nombre'] ) ) $datos['tema_nombre'] = $_POST['tema_nombre'];
		if( isset( $_POST['tema_url'] ) ) $datos['tema_url'] = $_POST['tema_url'];
		if( isset( $_POST['tema_ext'] ) ) $datos['tema_ext'] = $_POST['tema_ext'];
		//Mostramos datos en json con el resultado
		if( $principal->editarConfig($datos) ) echo json_encode(
			array('result' => 1, 'error' => 0)
		);
		else echo json_encode(array('result' => 0, 'error' => $principal->error));
		exit();
	}


	$lista_sitio = $principal->listarConfig();
	$plantilla->setEtiqueta(array(
		'sitio_epp' => $lista_sitio['conf_epp'],
		'sitio_intentos' => $lista_sitio['conf_intentos'],
		'sitio_comentarios' => $lista_sitio['conf_coment'],
		'sitio_validaemail' => $lista_sitio['conf_validaemail'],
		'sitio_registro' => $lista_sitio['conf_registro'],
		'tema_nombre' => $lista_sitio['tema_nombre'],
		'tema_url' => $lista_sitio['tema_url'],
		'tema_ext' => $lista_sitio['tema_ext'],
	));

	//Estas lineas crean un bloque dinamico para el select de opciones de comentarios
	$lista_opciones_coment = array(
		array(0, 'Desactivar Comentarios', ''),
		array(1, 'Publicar Inmediatamente', ''),
		array(2, 'Esperar por Revisión', ''),
	);
	if( $lista_sitio['conf_coment'] == $lista_opciones_coment[0][0] )
		$lista_opciones_coment[0][2] = 'selected';
	elseif( $lista_sitio['conf_coment'] == $lista_opciones_coment[1][0] )
		$lista_opciones_coment[1][2] = 'selected';
	elseif( $lista_sitio['conf_coment'] == $lista_opciones_coment[2][0] )
		$lista_opciones_coment[2][2] = 'selected';
	$plantilla->setBloque('lista_opciones_coment', $lista_opciones_coment, array(
		'valor', 'nombre', 'selected'
	));

	$plantilla->display($plantilla->getHTML('sitio-configuracion'));
