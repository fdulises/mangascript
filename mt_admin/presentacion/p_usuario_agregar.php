<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
  /*
  * Archivo de presentacion para la subseccion agregar de la seccion usuario
  */

  if( isset($_GET['guardar']) ){
      $datos = array(
        'nickname' => '',
        'email' => '',
        'clave' => '',
        'grupo' => '',
        'nombre' => '',
        'descrip' => '',
        'sitio' => ''
      );
      if( isset( $_POST['nickname'] ) ) $datos['nickname'] = $_POST['nickname'];
      if( isset( $_POST['email'] ) ) $datos['email'] = $_POST['email'];
      if( isset( $_POST['clave'] ) ) $datos['clave'] = $_POST['clave'];
      if( isset( $_POST['grupo'] ) ) $datos['grupo'] = $_POST['grupo'];
      if( isset( $_POST['nombre'] ) ) $datos['nombre'] = $_POST['nombre'];
      if( isset( $_POST['descrip'] ) ) $datos['descrip'] = $_POST['descrip'];
      if( isset( $_POST['sitio'] ) ) $datos['sitio'] = $_POST['sitio'];
      //Mostramos datos en json con el resultado
      if( $usuario->crear($datos) ) echo json_encode(array('result' => 1, 'error' => 0));
      else echo json_encode(array('result' => 0, 'error' => $usuario->error));
      exit();
  }

  //Mostramos la interfaz de la seccion
  $plantilla->display($plantilla->getHTML('usuario-agregar'));
