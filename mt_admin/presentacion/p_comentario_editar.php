<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
/*
* Archivo de presentacion para la subseccion editar de la seccion comentario
*/

if( isset($_GET['id']) ){
  if( $entrada->existeComentario($_GET['id']) ){
    if( isset($_GET['guardar']) ){
      $datos = array(
        'id' => $_GET['id'],
        'contenido' => '',
        'estado' => '',
        'autor' => '',
      );
      if( isset( $_POST['contenido'] ) ) $datos['contenido'] = $_POST['contenido'];
      if( isset( $_POST['estado'] ) ) $datos['estado'] = $_POST['estado'];
      if( isset( $_POST['autor'] ) ) $datos['autor'] = $_POST['autor'];

	  //Mostramos datos en json con el resultado
	  if( $entrada->editarComentario($datos) ) echo json_encode(array('result' => 1, 'error' => 0));
	  else echo json_encode(array('result' => 0, 'error' => $entrada->error));
	  exit();
    }
    $datos_comentario = $entrada->listarComentarioById($_GET['id']);
    $plantilla->setEtiqueta(array(
  		'id' => $datos_comentario['id'],
      	'autor' => $datos_comentario['autor'],
      	'contenido' => $datos_comentario['contenido'],
      	'estado' => $datos_comentario['estado']
  	));
    //Creamos bloque dinamico con la lista de estados
  	require "inclusiones/inc_estados.php";

    foreach ($estados_comentario as $key => $value) {
  		if( $datos_comentario['estado'] == $value['id'] ) $estados_comentario[$key]['active'] = 'selected';
  		else $estados_comentario[$key]['active'] = '';
  	}

  	$plantilla->setBloque('lista_estados', $estados_comentario, array('id', 'nombre', 'selected'));
    $plantilla->display($plantilla->getHTML('comentario-editar'));
  }else header('location: comentario?error');
}else header('location: comentario?error');
