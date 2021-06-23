<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	//Funcion para mandar mensajes desde web
	function envEmail($datos){
		//Definimos los destinatarios
		$datos['cpara'] = $GLOBALS['mt']->getInfo('email');
		//Establecemos las cabeceras del mensaje
		$emailheaders  = 'MIME-Version: 1.0'."\r\n";
		$emailheaders .= 'Content-type: text/html; charset=utf-8'."\r\n";
		$emailheaders .= 'From: '.$datos['cmail']."\r\n";
		$emailheaders .= 'Reply-To: '.$datos['cpara']."\r\n";
		//Establecemos el contenido del mensaje
		$emailtext = "<h2>Detalles del formulario de contacto</h2>\n\n";
		$emailtext .= "<p><b>Nombre:</b> " . $datos['cnombre'] . "</p>\n";
		$emailtext .= "<p><b>E-mail:</b> " . $datos['cmail'] . "</p>\n";
		$emailtext .= "<p><b>Asunto:</b> " . $datos['casunto'] . "</p>\n";
		$emailtext .= "<p><b>Mensaje:</b></p><p> " . nl2br($datos['cmensaje']) . "</p>\n\n";
		//Enviamos el mensaje
		$resultado = mail($datos['cpara'], $datos['casunto'], $emailtext, $emailheaders);
		return $resultado;
	}
	if( isset($_GET['contactar']) ){
		//Estructura para procesar formulario de contacto
		//Verificamos que se envien todos los campos
		if( isset($_POST['cnombre'], $_POST['cmail'], $_POST['cmensaje'], $_POST['casunto']) ){
			if( ( $_POST['cnombre'] != '' ) && ( $_POST['cmail'] != '' ) && ( $_POST['cmensaje'] != '' ) && ( $_POST['casunto'] != '') ){
				//Establecemos los datos a enviar
				$datos = array(
					'casunto' => "{$_POST['casunto']} - Contacto desde Mictlan",
					'cnombre' => $_POST['cnombre'],
					'cmail' => $_POST['cmail'],
					'cmensaje' => $_POST['cmensaje'],
				);
				$enviar = envEmail($datos);
				if($enviar) echo 1;
				else echo 0;
			}else echo 2;
		}else echo 0;
		exit();
	}

	//Agregamos las paginas estaticas del sitio
	$mt::$hooks->add_action( 'determinarSec', 'agregarSecciones' );
	function agregarSecciones(){
		array_map(function($actual){
			$GLOBALS['mt']->setSec($actual);
		}, array(
			'contacto' => array(
				'id' => 'contacto',
				'titulo' => 'Página de contacto',
				'url' => 'contacto',
				'filesec' => 'sec_contacto',
			),
			'miniatura' => array(
				'id' => 'miniatura',
				'titulo' => '',
				'url' => 'miniatura',
				'filesec' => 'extras/TimThumb',
			),
			'lector' => array(
				'id' => 'lector',
				'titulo' => 'Lector de Manga',
				'url' => 'lector',
				'filesec' => 'extras/sec_lector',
			),
			'apimanga_sitio' => array(
				'id' => 'apimanga_sitio',
				'titulo' => 'Api para lector de manga',
				'url' => 'apimanga_sitio',
				'filesec' => 'extras/sec_apimanga_sitio',
			),
			'apimanga' => array(
				'id' => 'apimanga',
				'titulo' => 'Api para lector de manga',
				'url' => 'apimanga',
				'filesec' => 'extras/sec_apimanga',
			),
			'apimanga2' => array(
				'id' => 'apimanga2',
				'titulo' => 'Api para lector de manga',
				'url' => 'apimanga2',
				'filesec' => 'extras/sec_apimanga2',
			),
			'pedidos' => array(
				'id' => 'pedidos',
				'titulo' => 'Sección de pedidos',
				'url' => 'pedidos',
				'filesec' => 'extras/sec_pedidos',
			),
			'adultcont' => array(
				'id' => 'adultcont',
				'titulo' => 'Contenido bloqueado',
				'url' => 'adultcont',
				'filesec' => 'extras/sec_adultcont',
			),
			'letra' => array(
				'id' => 'letra',
				'titulo' => 'Lista de mangas por letra',
				'url' => 'letra',
				'filesec' => 'extras/sec_letra',
			),
		));
	}
