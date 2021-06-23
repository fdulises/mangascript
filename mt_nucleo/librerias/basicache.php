<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Basicache - Sistema de cache básico basado en archivos
	* V 16.08.01
	*/
	abstract class basicache{
		/*
		* Metodo para eliminar archivos de cache
		*/
		public static function delete($ruta, $id, $caducidad = false){
			if( $caducidad ) unlink("{$ruta}/{$id}_{$caducidad}");
			else{
				$archivo = glob("{$ruta}/{$id}_*");
				if( $archivo ) foreach($archivo as $v) unlink($v);
			}
		}
		/*
		* Metodo para obtener el contenido guardado en cache
		*/
		public static function get($ruta, $id){
			$archivo = glob("{$ruta}/{$id}_*");
			if( $archivo ){
				$archivo = explode('/', $archivo[0]);
				$archivo = $archivo[count($archivo)-1];
				$caducidad = explode('_', $archivo)[1];
				if( $caducidad > date('U') )
					return file_get_contents("{$ruta}/{$id}_{$caducidad}");
				else self::delete($ruta, $id, $caducidad);
			}
			return 0;
		}
		/*
		* Metodo para generar archivos de cache
		*/
		public static function post($ruta, $id, $contenido, $caducidad){
			$caducidad = date('U')+$caducidad;
			file_put_contents("{$ruta}/{$id}_{$caducidad}", $contenido);
		}
		/*
		* Metodo para generar archivos de cache actualizando el existente
		*/
		public static function put($ruta, $id, $contenido, $caducidad){
			self::delete($ruta, $id);
			self::post($ruta, $id, $contenido, $caducidad);
		}
	}
