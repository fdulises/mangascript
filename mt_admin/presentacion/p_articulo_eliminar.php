<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
  /*
  * Archivo de presentacion para la subseccion eliminar de la seccion pagina
  */

  if( isset($_GET['id']) ){
      $id = (INT) $_GET['id'];
      //Mostramos datos en json con el resultado
	  if( isset($_GET['permanente']) )
      $resultado = $entrada->eliminarArticuloPermanente($id);
    else
      $resultado = $entrada->eliminarArticulo($id);

    if( $resultado ) echo json_encode(array('result' => 1, 'error' => 0));
    else echo json_encode(array('result' => 0, 'error' => $entrada->error));
    exit();
  }else header('location: articulo');
