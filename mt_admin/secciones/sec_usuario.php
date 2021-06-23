<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

  /*
  * Arvhico de seccion - Usuarios
  */
  //Determinamos y mostramos la presentacion de la seccion o subseccion solicitada
  $accion = 'listar';
  if( isset( $_GET['accion'] ) ) $accion = $_GET['accion'];
  if( $accion == 'listar' ) require "presentacion/p_usuario.php";
  else if( $accion == 'agregar' ) require "presentacion/p_usuario_agregar.php";
  else if( $accion == 'editar' ) require "presentacion/p_usuario_editar.php";
  else if( $accion == 'eliminar' ) require "presentacion/p_usuario_eliminar.php";
  else require "presentacion/p_usuario.php";
