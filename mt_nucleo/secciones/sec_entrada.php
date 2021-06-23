<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Facade para la seccion entrada
	*/

	if( isset( $_GET['comentar'] ) ){
		$datos = array(
			'destino' =>  $mt->seccion['id'],
			'autor' => '',
			'email' => '',
			'sitio' => '',
			'contenido' => '',
			'captchaResponse' => '',
		);

		if( isset($_POST['autor']) ) $datos['autor'] = $_POST['autor'];
		if( isset($_POST['email']) ) $datos['email'] = $_POST['email'];
		if( isset($_POST['sitio']) ) $datos['sitio'] = $_POST['sitio'];
		if( isset($_POST['contenido']) ) $datos['contenido'] = $_POST['contenido'];
		if( isset($_POST['captchaResponse']) ) $datos['captchaResponse'] = $_POST['captchaResponse'];

		echo($mt->setComentario($datos));
		exit();
	}

	require "{$mt->getInfo('tema_url')}/sec_entrada.php";
