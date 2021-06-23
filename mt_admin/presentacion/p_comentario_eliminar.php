<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
/*
* Archivo de presentacion para la subseccion eliminar de la seccion comentario
*/
if( isset($_GET['id']) ){
	if( $entrada->existeComentario($_GET['id'] ) ){
		if( isset($_GET['permanente']) ){
			if( $entrada->eliminarComentarioPermanente($_GET['id']) )
				echo json_encode(array('result' => 1, 'error' => 0));
			else echo json_encode(array('result' => 0, 'error' => $entrada->error));
		}else{
			//Mostramos datos en json con el resultado
			if( $entrada->eliminarComentario($_GET['id']) ) echo json_encode(array('result' => 1, 'error' => 0));
			else echo json_encode(array('result' => 0, 'error' => $entrada->error));
			exit();
		}
	}else header('location: comentario?error');
	exit();
}else header('location: comentario');
