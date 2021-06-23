<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Clase que provee metodos varios para trabajar con diferentes dados
	*/
	abstract class correos{

		static public $error = array();
		static public $SITIO_DIRECCION = SITIO_DIRECCION;
		static public $SITIO_EMAIL = SITIO_EMAIL;
		static public $plantilla;

		public function __construct(){
		}

		static public function setPlantilla(){
			self::$plantilla = new templates('tpl', 'tpl');
		}

		static public function restableceClave($datos){
			//Creamos enlace para reestablecer clave
			$urlclave = extras::urlactual();
			$urlclave .= "?accion=restablececlave";
			$urlclave .= "&id={$datos['huella']}";

			//Obtenemos y parseamos plantilla con el texto del email
			$html = self::$plantilla->getHTML('restableceClave');
			self::$plantilla->setEtiqueta(array(
				'urlsitio' => self::$SITIO_DIRECCION,
				'usuario' => $datos['usuario'],
				'urlclave' => $urlclave,
			));
			$html = self::$plantilla->parse($html);

			//Finalmente enviamos el email con los datos solicitados
			return self::mail(array(
				'destino' => $datos['destino'],
				'asunto' => 'Ayuda para restablecer contraseña',
				'mensaje' => $html,
				'from' => self::$SITIO_EMAIL,
			));
		}

		/*
		* Metodo para envio de correos
		* Recibe un array con el destino, asunto, mensaje, from, cc, bcc
		*/
		static public function mail($datos){
			$cabeceras  = 'MIME-Version: 1.0'."\r\n";
			$cabeceras .= 'Content-type: text/html; charset=utf-8'."\r\n";
			if( isset( $datos['from'] ) )
				$cabeceras .= 'From: '.$datos['from']."\r\n";
			if( isset( $datos['cc'] ) )
				$cabeceras .= 'CC: '.$datos['cc']."\r\n";
			if( isset( $datos['bcc'] ) )
				$cabeceras .= 'Bcc: '.$datos['bcc']."\r\n";

			$resultado = mail(
				$datos['destino'],
				$datos['asunto'],
				$datos['mensaje'],
				$cabeceras
			);
			return $resultado;
		}

	}
