<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
  /*
  * Archivo de presentacion para la seccion usuario
  */

  //Obtenemos la lista de usuarios
  $lista_usuarios = $usuario->listar();

  require 'inclusiones/inc_grupos.php';
  foreach ($lista_usuarios as $k => $v){
	  //Sustituimos los ids de grupo por su nombre
	  $lista_usuarios[$k]['grupo'] = $grupos[$v['grupo']]['nombre'];
	  //Generamos gravatar
	  $lista_usuarios[$k]['avatar'] = $usuario->urlGravatar($v['email'], 30);
  }
  //Definimos un bloque dinamico con la lista de usuarios
  $plantilla->setBloque('lista_usuarios', $lista_usuarios, array(
    'usuario_id', 'usuario_nickname', 'usuario_email', 'usuario_fregistro' , 'usuario_grupo',
	'usuario_nombre', 'usuario_total_e', 'usuario_gravatar',
  ));

  //Mostramos la interfaz de la seccion
  $plantilla->display($plantilla->getHTML('usuario-listar'));
