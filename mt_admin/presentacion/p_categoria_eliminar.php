<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la subseccion eliminar de la seccion categoria
	*/

	if( isset($_GET['id']) ){
		//Mostramos datos en json con el resultado
		if( $entrada->eliminarCategoria($_GET['id']) )
			echo json_encode(array('result' => 1, 'error' => 0));
		else
			echo json_encode(array('result' => 0, 'error' => $entrada->error));
		exit();
	}
