<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	$mt->plantilla->setEtiqueta(array(
		'SITIO_TITULO' => $mt->getInfo('titulo'),
		'SITIO_DESCRIP' => $mt->getInfo('descrip'),
		'SITIO_URL' => $mt->getInfo('url'),
		'SITIO_EMAIL' => $mt->getInfo('email'),
		'pagina_titulo' => $mt->seccion['titulo'],
		'pagina_enlace' => $mt->seccion['enlace'],
		'pagina_descrip' => $mt->getInfo('descrip'),
		'TEMA_URL' => "{$mt->getInfo('url')}/{$mt->getInfo('tema_url')}",
		'SITIO_RECAPTCHA' => RECAPTCHA_SITE_KEY,
	));
