<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la subseccion ver de la seccion pagina
	*/

	if( isset($_GET['id']) ){
		$datos_pagina = $entrada->listarPagina($_GET['id']);
		$plantilla->setEtiqueta(array(
			'entrada_id' => $datos_pagina['id'],
			'entrada_titulo' => $datos_pagina['titulo'],
			'entrada_url' => $datos_pagina['url'],
			'entrada_fecha' => $datos_pagina['fecha'],
			'entrada_descrip' => $datos_pagina['descrip'],
			'entrada_contenido' => $datos_pagina['contenido'],
			'entrada_superior' => $datos_pagina['superior'],
			'entrada_portada' => $datos_pagina['portada'],
			'entrada_autor' => $datos_pagina['autor'],
			'entrada_estado' => $datos_pagina['estado'],
		));
		$plantilla->display($plantilla->getHTML('pagina-ver'));
	}else die("Error con la entrada solicitada");
