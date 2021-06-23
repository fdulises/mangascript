<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
    /*
    * Archivo de presentacion para la seccion acceso
    */

    if( isset($_GET['iniciar']) ){
        $datos = array(
          'usuario' => '',
          'clave' => '',
		  'recordars' => false,
        );
        if( isset( $_POST['usuario'] ) ) $datos['usuario'] = $_POST['usuario'];
        if( isset( $_POST['clave'] ) ) $datos['clave'] = $_POST['clave'];
        if( isset( $_POST['recordars'] ) ) $datos['recordars'] = $_POST['recordars'];
        if( $usuario->acceso($datos) ) echo json_encode(array('result' => 1, 'error' => 0));
        else echo json_encode(array('result' => 0, 'error' => $usuario->error));
        exit();
    }

    //Mostramos la interfaz de la seccion
    $plantilla->display($plantilla->getHTML('usuario-acceso'));
