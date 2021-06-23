<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Clase Abstracta MySQLi
	*	Provee de todos los metodos necesarios para hacer operaciones con la base de datos
	*/
	abstract class dbConector{

		public static $conexion;

		public static function conectar($host, $user, $password, $database){
			self::$conexion = new mysqli($host, $user, $password, $database);
			if(self::$conexion->connect_errno > 0){
				die('Imposible conectarse con la base de datos: [' . self::$conexion->connect_error . ']');
			}
			self::$conexion->set_charset("utf8");
		}

		public static function sendQuery($query){
			$resultado = self::$conexion->query($query) or die('Error '.self::errorNo().' - '.self::error());
			return $resultado;
		}
		private static function fetchAssoc($result){
			return $result->fetch_assoc();
		}
		public static function escape($datos){
			if( is_array($datos) ){
				$datos_f = array();
				foreach($datos as $k => $v) {
					$datos_f[$k] = self::$conexion->real_escape_string($v);
				}
				return $datos;
			}
			return self::$conexion->real_escape_string($datos);
		}
		public static function query($q){
			$result = self::sendQuery($q);
			if(is_object($result)){
				$arr = array();
				while($row = self::fetchAssoc($result)){
					$arr[] = $row;
				}
				return $arr;
			}
			return null;
		}

		public static function errorNo(){
			return self::$conexion->errno;
		}
		public static function error(){
			return self::$conexion->error;
		}
		public static function insertId(){
			return self::$conexion->insert_id;
		}
		public static function numRows($result){
			return self::$conexion->num_rows;
		}
		public static function affectedRows($result){
			return $result->affected_rows;
		}
		public static function free($result){
			return $result->free();
		}
		public static function close(){
			return self::$conexion->close();
		}
	}
