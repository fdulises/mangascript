<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
    /*
    * Archivo de seccion
    */

	$estado = 0;
	$dirbase = 'mt_media/manga';
	$dirdestino = '../'.$dirbase;
	$ruta = '';

	if( isset( $_FILES['imgtoup'], $_POST['dirimgtoup'] ) ){
		$_POST['dirimgtoup'] = (INT) $_POST['dirimgtoup'];
		$dirimgtoup = $entrada->dbListarEntradaBasic($_POST['dirimgtoup']);
		if( $dirimgtoup ){
			$dirdestino .= '/'.$dirimgtoup['url'];
			if( !extras::putDir($dirdestino) ) die(5);
		}else die(4);
		//datos del arhivo
		$nombre_archivo = $_FILES['imgtoup']['name'];
		$tipo_archivo = $_FILES['imgtoup']['type'];
		$tamano_archivo = $_FILES['imgtoup']['size'];
		//compruebo si las características del archivo son las que deseo
		if (!( (strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg") || strpos($tipo_archivo, "png") ) && ($tamano_archivo < 10000000))) {
		    $estado = 2;
		}else{
		    if (move_uploaded_file($_FILES['imgtoup']['tmp_name'], $dirdestino.'/'.$nombre_archivo)){
				$estado = 1;
				$ruta = "{$principal->sitioInfo()['url']}/{$dirbase}/{$dirimgtoup['url']}/{$nombre_archivo}";
		    }else $estado = 3;
		}
	}
	echo json_encode(array(
		'estado' => $estado,
		'ruta' => $ruta,
	));
