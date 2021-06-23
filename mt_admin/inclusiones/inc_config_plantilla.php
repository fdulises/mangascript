<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	$plantilla->setEtiqueta(array(
		'sitio_titulo' => SITIO_TITULO,
		'SITIO_URL' => $principal->listarSitioConfig(array('url'))['url'],
		'pagina_titulo' => "{$principal->seccion['titulo']} - ".SITIO_TITULO,
		'tema_dir' => TEMA_DIR,
		'fecha_y' => date('Y'),
	));
	if( $usuario->logingCheck() ){
		$plantilla->setPatron('/\[si_sesion\](.*?)\[\/si_sesion\]/is', '$1');
		$plantilla->setPatron('/\[no_sesion\](.*?)\[\/no_sesion\]/is', '');
		$plantilla->setEtiqueta('nickname', $_SESSION[S_USERNAME]);
		$plantilla->setEtiqueta('userid', $_SESSION[S_USERID]);
		$plantilla->setEtiqueta('gravatar', $usuario->urlGravatar($_SESSION[S_USERMAIL], '25px'));
	}else{
		$plantilla->setPatron('/\[si_sesion\](.*?)\[\/si_sesion\]/is', '');
		$plantilla->setPatron('/\[no_sesion\](.*?)\[\/no_sesion\]/is', '$1');
		$plantilla->setEtiqueta('nickname', 'Visitante');
		$plantilla->setEtiqueta('userid', '0');
	}
