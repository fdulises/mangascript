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
          'usuario' => '',
        );
        if( isset( $_POST['usuario'] ) ) $datos['usuario'] = $_POST['usuario'];
        $usuario->ayudaRestableceClave($datos);
		header('location: acceso?accion=claveperdida&enviado');
        exit();
    }

    //Mostramos la interfaz de la seccion
	if( isset( $_GET['enviado'] ) ) $plantilla->display(
		$plantilla->getHTML('usuario-acceso-enviado')
	);
	else $plantilla->display(
		$plantilla->getHTML('usuario-acceso-claveperdida')
	);
