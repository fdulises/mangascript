<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Clase que provee metodos varios para trabajar con diferentes dados
	*/
	abstract class extras{

		static public $error = array();
		static public $SITIO_DIRECCION = SITIO_DIRECCION;
		static public $SITIO_EMAIL = SITIO_EMAIL;

		/*
		* Metodo para verificar campos vacios
		*/
		static public function verifCampoVacio($datos){
			foreach ($datos as $k => $v)
				if($v == "") self::$error[]=$k.'_vacio';
			return self::$error;
		}

		/*
		* Metodos para sanitizar campos
		*/
		static public function limpiarCadenas($datos){
			foreach ($datos as $k => $v)
				$datos[$k] = filter_var($v, FILTER_SANITIZE_STRING);
			return $datos;
		}

		/*
		* Metodos para escapar caracteres con barras
		*/
		static public function addslashes($datos){
			if( is_array($datos) ){
				foreach ($datos as $k => $v) $datos[$k] = addslashes($v);
				return $datos;
			}
			return addslashes($datos);
		}

		/*
		* Metodos para escapar codigo html
		*/
		static public function htmlentities($datos, $multi = false){
			if( is_array($datos) && !$multi ){
				foreach ($datos as $k => $v) $datos[$k] = htmlentities($v);
				return $datos;
			}elseif( is_array($datos) && $multi ){
				foreach ($datos as $k => $v){
					$datos[$k] = array();
					foreach ($v as $c => $b)
						$datos[$k][$c] = htmlentities($b);
				}
				return $datos;
			}
			return htmlentities($datos);
		}
		/*
		* Metodos para escapar datos y evitar ataques sql inyection
		*/
		static public function escaparDB($datos){
			return self::addslashes(dbConector::escape($datos));
		}

		/*
		* Metodos para dar formato dd/mm/aa a la fecha
		*/
		static public function fechaF1($fecha){
			return self::formatoDate($fecha, 'd/m/Y');
		}

		/*
		* Metodo para dar el formato deseado a la fecha y el tiempo
		*/
		static public function formatoDate($cadena, $formato){
			return date( $formato, strtotime($cadena) );
		}

		/*
		* Metodo para generar gravarar
		*/
		static public function urlGravatar($email, $size){
			$hash = md5( strtolower( trim( $email ) ) );
			$url = "http://www.gravatar.com/avatar/";
			return "{$url}{$hash}.jpg?s={$size}&d=mm";
		}

		/*
		* Metodo para buscar y eliminar el caracter solicitado al final
		* de una cadena
		*/
		static public function eliminaUltimoC($dato, $caracter){
			if( (strlen($dato)-1) == strripos($dato, $caracter) )
				return substr($dato, 0, -1);
			return $dato;
		}

		/*
		* Metodo para imprimir un arreglo
		*/
		static public function print_r($datos){
			print("<pre>");
			print_r($datos);
			print("</pre>");
		}

		/*
		* Metodo para eliminar espacios en blanco al inicio y al final
		* de cadenas
		*/
		static public function trim($datos){
			if( is_array($datos) ){
				foreach ($datos as $k => $v) $datos[$k] = trim($v);
				return $datos;
			}
			return trim($datos);
		}

		/*
		* Metodo para Verficar si la url es valida
		*/
		static public function validarUrl($url){
			$filtro = filter_var(
				self::$SITIO_DIRECCION.'/'.$url,
				FILTER_VALIDATE_URL,
				FILTER_FLAG_PATH_REQUIRED
			);
			return $filtro;
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

		static public function urlactual(){
			$link = "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
			$link = parse_url($link, PHP_URL_PATH);
			$linkpath = parse_url(self::$SITIO_DIRECCION, PHP_URL_SCHEME);
			return $linkpath.'://'.$link;
		}

		static public function putDir($path){
			$resultado = 1;
			if( !is_dir($path) ) $resultado = mkdir($path);
			return $resultado;
		}

	}
