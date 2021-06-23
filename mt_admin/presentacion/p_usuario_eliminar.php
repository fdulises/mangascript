<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
    /*
    * Archivo de presentacion para la subseccion eliminar de la seccion usuario
    */

    if( isset($_GET['id']) ){
      $id = (INT) $_GET['id'];
      if( $usuario->eliminar($id) ) echo json_encode(array('result' => 1, 'error' => 0));
      else echo json_encode(array('result' => 0, 'error' => $usuario->error));
      exit();
    }else{
      echo json_encode(array('result' => 0, 'error' => 'id_incorrecto'));
    }
