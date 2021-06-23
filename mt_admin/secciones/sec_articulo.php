<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
  /*
  * Arvhico de seccion - Articulo
  */
  //Determinamos y mostramos la presentacion de la seccion o subseccion solicitada
  $accion = 'listar';
  if( isset( $_GET['accion'] ) ) $accion = $_GET['accion'];
  if(      $accion == 'agregar' ) require "presentacion/p_articulo_agregar.php";
  else if( $accion == 'ver' ) require "presentacion/p_articulo_ver.php";
  else if( $accion == 'editar' ) require "presentacion/p_articulo_editar.php";
  else if( $accion == 'eliminar' ) require "presentacion/p_articulo_eliminar.php";
  else if( $accion == 'papelera' ) require "presentacion/p_articulo_papelera.php";
  else if( $accion == 'adcap' ) require "presentacion/p_manga_adcap.php";
  else if( $accion == 'vercap' ) require "presentacion/p_manga_vercap.php";
  else if( $accion == 'editcap' ) require "presentacion/p_manga_editcap.php";
  else if( $accion == 'delcap' ) require "presentacion/p_manga_delcap.php";
  else if( $accion == 'pedidos' ) require "presentacion/p_manga_pedidos.php";
  else require "presentacion/p_articulo.php";
