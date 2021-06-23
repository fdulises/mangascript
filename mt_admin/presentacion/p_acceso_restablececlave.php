<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
    /*
    * Archivo de presentacion para la subseccion clave perdida de la seccion acceso
    */

    if( isset($_GET['enviar']) ){
        $datos = array(
          'clave' => '',
		  'id' => '',
        );
        if( isset( $_POST['clave'] ) ) $datos['clave'] = $_POST['clave'];
        if( isset( $_POST['id'] ) ) $datos['id'] = $_POST['id'];
        if( $usuario->restableceClave($datos) )
			echo json_encode(array('result' => 1, 'error' => 0));
        else echo json_encode(array('result' => 0, 'error' => $usuario->error));
        exit();
    }

	if( isset( $_GET['id'] ) ){
	    //Mostramos la interfaz de la seccion
		$plantilla->setEtiqueta('id', $_GET['id']);
	    $plantilla->display($plantilla->getHTML('usuario-acceso-restablececlave'));
	}else{
		header('location: acceso?error');
	}
