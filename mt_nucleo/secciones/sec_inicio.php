<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Facade para la seccion inicio
	*/

	$ruta = "{$mt->getInfo('tema_url')}/sec_inicio.php";

	if( file_exists( "{$mt->getInfo('tema_url')}/sec_inicio.php" ) )
		$ruta = "{$mt->getInfo('tema_url')}/sec_inicio.php";
	else if ( file_exists( "{$mt->getInfo('tema_url')}/sec_blog.php" ) )
		$ruta = "{$mt->getInfo('tema_url')}/sec_blog.php";

	require $ruta;
