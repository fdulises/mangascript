<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
/*
* Archivo de presentacion para la seccion Comentarios
*/

//Obtenemos lista de Comentarios
$lista_comentarios = extras::htmlentities($entrada->listarComentariosSpam(), true);
//Creamos bloque dinamico con la lista de Comentarios
$plantilla->setBloque('lista_comentarios', $lista_comentarios, array(
   'id',
   'autor',
   'contenido',
   'fecha',
   'estado',
   'titulo',
   'url'
));
  $plantilla->display($plantilla->getHTML('comentario-spam'));
