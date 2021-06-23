<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	abstract class extras{

		public static $error = array();

		public static function print_r($datos){
			print "<pre>";
			print_r($datos);
			print "</pre>";
		}

		/*
		* Metodo para implementar el modo mantenimiento
		*/
		public static function modoMantenimiento(){
			include 'mt_nucleo/presentacion/tpl/mantenimiento.tpl';
			exit();
		}

		/*
		* Metodos para escapar codigo html
		*
		* Si $multi se establece en true procesa $datos como arreglo multidimencional
		*/
		public static function htmlentities($datos, $multi = false){
			if( is_array($datos) && !$multi ){
				foreach ($datos as $k => $v) $datos[$k] = htmlentities($v);
				return $datos;
			}elseif( is_array($datos) && $multi ){
				foreach ($datos as $k => $v){
					$datos[$k] = array();
					foreach ($v as $c => $b) $datos[$k][$c] = htmlentities($b);
				}
				return $datos;
			}
			return htmlentities($datos);
		}

		/*
		* Metodo para dar el formato deseado a la fecha y el tiempo
		*/
		public static function formatoDate($cadena, $formato){
			return date( $formato, strtotime($cadena) );
		}

		/*
		* Metodo para generar gravarar
		*/
		public static function urlGravatar($email, $size){
			$hash = md5( strtolower( trim( $email ) ) );
			return "http://www.gravatar.com/avatar/{$hash}.jpg?s={$size}&d=mm";
		}

		/*
		* Metodo que itera sobre un arreglo bidimencional para modificar y agregar celdas
		*/
		public static function setCeldaArregloBi($arreglo, $contenido, $celda = ''){
			foreach( $arreglo as $k => $v )	$arreglo[$k][$celda] = $contenido;
			return $arreglo;
		}

		/*
		* Metodo para verificar campos vacios
		*/
		public static function checkCampoVacio($datos){
			foreach ($datos as $k => $v) if( empty($v) ) self::$error[]=$k.'_vacio';
			return self::$error;
		}

		/*
		* Metodos para sanitizar campos
		*/
		public static function limpiarCadenas($datos){
			foreach ($datos as $k => $v) $datos[$k] = filter_var($v, FILTER_SANITIZE_STRING);
			return $datos;
		}

		/*
		* Metodo para validar recaptcha de google
		*/
		public static function validaReCaptcha($secret, $captchaResponse){
			$recaptcha = new \ReCaptcha\ReCaptcha($secret);
			$resp = $recaptcha->verify($captchaResponse, $_SERVER['REMOTE_ADDR']);
			if ($resp->isSuccess()) return 1;
			else return 0;
		}

	}
