<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la seccion pagina
	*/

	$lista_paginas = extras::htmlentities($entrada->listarPaginas(), true);
	$plantilla->setBloque('lista_paginas', $lista_paginas, array(
		'pagina_id',
		'pagina_titulo',
		'pagina_url',
		'pagina_fecha',
		'pagina_usuario',
		'pagina_superior',
		'pagina_estado',
		'pagina_enlace',
	));

	$plantilla->display($plantilla->getHTML('pagina-listar'));
