<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
  /*
  * Archivo de presentacion para la seccion listar estadisticas
  */

  $estadistica = $principal->listarEstadisticas();

  $plantilla->setEtiqueta(array(
    'total_u' => $estadistica['total_u'],
    'total_p' => $estadistica['total_p'],
    'total_a' => $estadistica['total_a'],
    'total_c' => $estadistica['total_c'],
    'total_e' => $estadistica['total_p'] + $estadistica['total_a'],
    'total_cat' => $estadistica['total_cat'],
    'total_t' => $estadistica['total_t'],
    'total_col' => $estadistica['total_t'] + $estadistica['total_cat'],
  ));

  $plantilla->display($plantilla->getHTML('estadistica-listar'));
