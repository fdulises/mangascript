<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Facade para la seccion sitemap
	*/

	header('Content-Type: text/xml');
	$mt->plantilla->setDir('mt_nucleo/presentacion');
	$subsec = ( isset($_GET['subsec']) ) ? $_GET['subsec'] : 'index';

	if( $subsec == 'paginas' ){
		$lista_entradas = $mt->getEntrada(array(
			'columnas' => array(
				'enlace as entrada_enlace',
				'e.fecha_u as entrada_fecha',
			),
			'tipo' => 1,
			'orden' => 'e.fecha_u',
			'disp' => 'DESC',
		));
		$mt->plantilla->setBloque('lista_entradas', $lista_entradas);
		$mt->plantilla->display('tpl/sitemap');
	}else if( $subsec == 'entradas' ){
		$lista_entradas = $mt->getEntrada(array(
			'columnas' => array(
				'enlace as entrada_enlace',
				'e.fecha_u as entrada_fecha',
			),
			'tipo' => 2,
			'orden' => 'e.fecha_u',
			'disp' => 'DESC',
		));
		$mt->plantilla->setBloque('lista_entradas', $lista_entradas);
		$mt->plantilla->display('tpl/sitemap');
	}else if( $subsec == 'colecciones' ){
		$lista_entradas = $mt->getColeccion(array(
			'columnas' => array(
				'fecha as entrada_fecha',
				'enlace as entrada_enlace',
			),
			'tipo' => 1,
			'orden' => 'fecha',
			'disp' => 'DESC',
		));
		$mt->plantilla->setBloque('lista_entradas', $lista_entradas);
		$mt->plantilla->display('tpl/sitemap');
	}else{
		$mt->plantilla->display('tpl/sitemapindex');
	}
