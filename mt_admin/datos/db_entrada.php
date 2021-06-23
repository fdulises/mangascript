<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/**
	* Clase correspondiente a la capa de datos
	* Provee de metodos para realizar peticiones relacionadas con entradas
	*/
	abstract class db_entrada{
		protected $t_entrada = t_entrada;
		protected $t_coleccion = t_coleccion;
		protected $t_usuario = t_usuario;
		protected $t_sitio = t_sitio;
		static protected $t_sitio_s = t_sitio;
		protected $t_comentario = t_comentario;

		/* --------- CRUD de Entradas --------- */

		/*
		* Metodo para crear entrada
		*/
		protected function dbCrearEntrada($datos){
			$query = "INSERT INTO {$this->t_entrada}(
				titulo,
				url,
				fecha,
				fecha_u,
				descrip,
				contenido,
				coleccion,
				tags,
				portada,
				usuario,
				estado,
				tipo,
				plantilla,
				manga_api,
				manga_api_id
			) VALUES(
				'{$datos['titulo']}',
				'{$datos['url']}',
				'{$datos['fecha']}',
				'{$datos['fecha_u']}',
				'{$datos['descrip']}',
				'{$datos['contenido']}',
				'{$datos['coleccion']}',
				'{$datos['tags']}',
				'{$datos['portada']}',
				'{$datos['usuario']}',
				'{$datos['estado']}',
				'{$datos['tipo']}',
				'{$datos['plantilla']}',
				'{$datos['manga_api']}',
				'{$datos['manga_api_id']}'
			)";
			$result = dbConector::sendQuery($query);
			return $result;
		}

		/*
		* Metodo para mandar entradas a la papelera
		*/
		protected function dbEliminarEntrada($id){
			$result = dbConector::sendQuery(
				"UPDATE {$this->t_entrada} SET estado=4 WHERE id='{$id}'"
			);
			return $result;
		}

		/*
		* Metodo para eliminar entradas de forma permanente
		*/
		protected function dbEliminarEntradaPermanente($id){
			$result = dbConector::sendQuery(
				"UPDATE {$this->t_entrada} SET estado=0 WHERE id='{$id}'"
			);
			return $result;
		}

		/*
		* Metodo para Actulizar contadores del sitio
		*/
		static function dbActulizarContS($campo, $total){
			$query = "UPDATE ".self::$t_sitio_s."
				SET {$campo} = {$campo} + ({$total})";
			return dbConector::sendQuery($query);
		}

		/*
		* Metodo para actualizar contador de entradas por usuario
		*/
		protected function dbActulizarContEU($id, $total){
			$query = "UPDATE {$this->t_usuario}
				SET total_e =  total_e + ({$total})
				WHERE id = {$id}
			";
			return dbConector::sendQuery($query);
		}

		/* ---------- CRUD de Paginas --------- */

		/*
		* Metodo para obtener entrada tipo pagina
		*/
		protected function dbListarPagina($id){
			$query = "SELECT
				{$this->t_entrada}.id,
				titulo,
				url,
				fecha,
				descrip,
				contenido,
				superior,
				portada,
				nickname as autor,
				{$this->t_entrada}.estado,
				plantilla
				FROM {$this->t_entrada}
				LEFT JOIN {$this->t_usuario}
				ON {$this->t_entrada}.usuario = {$this->t_usuario}.id
				WHERE {$this->t_entrada}.id='{$id}' AND tipo=1
			";
			$result = dbConector::query($query);
			return $result;
		}

		/*
		* Metodo para obtener lista de paginas activas
		*/
		protected function dbListarPaginas(){
			$query = "SELECT
				{$this->t_entrada}.id,
				titulo, url, fecha, nickname as autor,
			 	superior, {$this->t_entrada}.estado
				FROM {$this->t_entrada}
				LEFT JOIN {$this->t_usuario}
				ON {$this->t_entrada}.usuario = {$this->t_usuario}.id
				WHERE ( ( {$this->t_entrada}.estado=1 )
				OR ( {$this->t_entrada}.estado=2 )
				OR ( {$this->t_entrada}.estado=3 ) )
				AND tipo=1
				ORDER BY titulo ASC
			";
			$result = dbConector::query($query);
			return $result;
		}

		/*
		* Metodo para obtener lista de paginas eliminadas
		*/
		protected function dbListarPaginasPapelera(){
			$query = "SELECT {$this->t_entrada}.id, titulo, url, fecha,
				nickname as autor,
			 	superior, {$this->t_entrada}.estado
				FROM {$this->t_entrada}
				LEFT JOIN {$this->t_usuario}
				ON {$this->t_entrada}.usuario = {$this->t_usuario}.id
				WHERE {$this->t_entrada}.estado=4
				AND tipo=1
			";
			$result = dbConector::query($query);
			return $result;
		}

		/*
		* Metodo para modificar entrada tipo pagina
		*/
		protected function dbEditarPagina($datos){
			$query = "UPDATE {$this->t_entrada} SET
				titulo = '{$datos['titulo']}',
				url = '{$datos['url']}',
				descrip = '{$datos['descrip']}',
				contenido = '{$datos['contenido']}',
				superior = '{$datos['superior']}',
				portada = '{$datos['portada']}',
				estado = '{$datos['estado']}',
				plantilla = '{$datos['plantilla']}'
				WHERE id = '{$datos['id']}'
			";
			$result = dbConector::sendQuery($query);
			return $result;
		}

		/* --------- CRUD de Entradas tipo Articulo --------- */

		/*
		* Metodo para obtener lista de articulos
		*/
		protected function dbListarArticulos( $opciones = array() ){
			$pnum = isset( $_GET['pagina'] ) ? (INT) $_GET['pagina'] : 1;
			if( $pnum <= 0 ) $pnum = 1;
			if( isset( $opciones['paginacion'], $opciones['limite'] ) ){
				$limite = (INT) $opciones['limite'];
				$limit = ($pnum-1)*$limite;
				$offset = $limite;
				if( isset( $opciones['busqueda'] ) ){
					$query = "SELECT
						SQL_CALC_FOUND_ROWS
						{$this->t_entrada}.id, titulo,
						{$this->t_entrada}.url, {$this->t_entrada}.fecha, nickname AS autor,
						{$this->t_coleccion}.nombre AS categoria,
						coleccion AS categoria_id,
						{$this->t_coleccion}.url AS categoria_url,
						{$this->t_entrada}.estado,
						{$this->t_entrada}.total_coment,
						{$this->t_entrada}.total_caps
						FROM {$this->t_entrada}
						LEFT JOIN {$this->t_usuario}
						ON {$this->t_entrada}.usuario = {$this->t_usuario}.id
						LEFT JOIN {$this->t_coleccion}
						ON {$this->t_entrada}.coleccion={$this->t_coleccion}.id
						WHERE ( ( {$this->t_entrada}.estado=1 )
						OR ( {$this->t_entrada}.estado=2 )
						OR ( {$this->t_entrada}.estado=3 ) )
						AND {$this->t_entrada}.tipo=2
						AND (
							titulo LIKE '%{$opciones['busqueda']}%' OR
							{$this->t_entrada}.tags LIKE '%{$opciones['busqueda']}%' OR
							{$this->t_entrada}.descrip LIKE '%{$opciones['busqueda']}%'
						)
						ORDER BY {$this->t_entrada}.id DESC
						LIMIT {$limit}, {$offset}
					";
				}else{
					$query = "SELECT
						SQL_CALC_FOUND_ROWS
						{$this->t_entrada}.id, titulo,
						{$this->t_entrada}.url, {$this->t_entrada}.fecha, nickname AS autor,
						{$this->t_coleccion}.nombre AS categoria,
						coleccion AS categoria_id,
						{$this->t_coleccion}.url AS categoria_url,
						{$this->t_entrada}.estado,
						{$this->t_entrada}.total_coment,
						{$this->t_entrada}.total_caps
						FROM {$this->t_entrada}
						LEFT JOIN {$this->t_usuario}
						ON {$this->t_entrada}.usuario = {$this->t_usuario}.id
						LEFT JOIN {$this->t_coleccion}
						ON {$this->t_entrada}.coleccion={$this->t_coleccion}.id
						WHERE ( ( {$this->t_entrada}.estado=1 )
						OR ( {$this->t_entrada}.estado=2 )
						OR ( {$this->t_entrada}.estado=3 ) )
						AND {$this->t_entrada}.tipo=2
						ORDER BY {$this->t_entrada}.id DESC
						LIMIT {$limit}, {$offset}
					";
				}
			}else{
				$query = "SELECT
					{$this->t_entrada}.id, titulo,
					{$this->t_entrada}.url, {$this->t_entrada}.fecha, nickname AS autor,
					{$this->t_coleccion}.nombre AS categoria,
					coleccion AS categoria_id,
					{$this->t_coleccion}.url AS categoria_url,
					{$this->t_entrada}.estado,
					{$this->t_entrada}.total_coment,
					{$this->t_entrada}.total_caps
					FROM {$this->t_entrada}
					LEFT JOIN {$this->t_usuario}
					ON {$this->t_entrada}.usuario = {$this->t_usuario}.id
					LEFT JOIN {$this->t_coleccion}
					ON {$this->t_entrada}.coleccion={$this->t_coleccion}.id
					WHERE ( ( {$this->t_entrada}.estado=1 )
					OR ( {$this->t_entrada}.estado=2 )
					OR ( {$this->t_entrada}.estado=3 ) )
					AND {$this->t_entrada}.tipo=2
					ORDER BY fecha DESC
				";
			}
			$result = dbConector::query($query);
			return $result;
		}

		public function dbFoundRows(){
			$resultado = dbConector::query('SELECT FOUND_ROWS() as rows');
			if( $resultado ) return $resultado[0]['rows'];
			return 0;
		}

		/*
		* Metodo para obtener entrada tipo pagina
		*/
		protected function dbListarArticulo($id){
			$query = "SELECT
				{$this->t_entrada}.id,
				{$this->t_entrada}.titulo,
				{$this->t_entrada}.url,
				{$this->t_entrada}.fecha,
				{$this->t_entrada}.descrip,
				{$this->t_entrada}.contenido,
				{$this->t_coleccion}.nombre AS categoria,
				{$this->t_coleccion}.url AS categoria_url,
				{$this->t_entrada}.coleccion AS categoria_id,
				{$this->t_entrada}.portada,
				{$this->t_usuario}.nickname as autor,
				{$this->t_entrada}.estado,
				{$this->t_entrada}.tags,
				{$this->t_entrada}.manga_api,
				{$this->t_entrada}.manga_api_id
				FROM {$this->t_entrada}
				LEFT JOIN {$this->t_usuario}
				ON {$this->t_entrada}.usuario = {$this->t_usuario}.id
				LEFT JOIN {$this->t_coleccion}
				ON {$this->t_entrada}.coleccion={$this->t_coleccion}.id
				WHERE {$this->t_entrada}.id='{$id}'
				AND {$this->t_entrada}.tipo=2
			";
			$result = dbConector::query($query);
			return $result;
		}

		/*
		* Metodo para obtener lista de articulos eliminadas
		*/
		protected function dbListarArticulosPapelera(){
			$query = "SELECT
				{$this->t_entrada}.id,
				{$this->t_entrada}.titulo,
				{$this->t_entrada}.url,
				{$this->t_entrada}.fecha,
				{$this->t_usuario}.nickname as autor,
				{$this->t_entrada}.estado,
				{$this->t_coleccion}.nombre AS categoria,
				{$this->t_coleccion}.url AS categoria_url,
				{$this->t_entrada}.coleccion AS categoria_id
				FROM {$this->t_entrada}
				LEFT JOIN {$this->t_usuario}
				ON {$this->t_entrada}.usuario = {$this->t_usuario}.id
				LEFT JOIN {$this->t_coleccion}
				ON {$this->t_entrada}.coleccion={$this->t_coleccion}.id
				WHERE {$this->t_entrada}.estado=4
				AND {$this->t_entrada}.tipo=2
			";
			$result = dbConector::query($query);
			return $result;
		}

		/*
		* Metodo para modificar entrada tipo articulo
		*/
		protected function dbEditarArticulo($datos){
			$query = "UPDATE {$this->t_entrada} SET
				titulo = '{$datos['titulo']}',
				url = '{$datos['url']}',
				fecha_u = '{$datos['fecha_u']}',
				descrip = '{$datos['descrip']}',
				contenido = '{$datos['contenido']}',
				portada = '{$datos['portada']}',
				estado = '{$datos['estado']}',
				coleccion = '{$datos['coleccion']}',
				tags = '{$datos['tags']}',
				manga_api = '{$datos['manga_api']}',
				manga_api_id = '{$datos['manga_api_id']}'
				WHERE id = '{$datos['id']}'
			";
			$result = dbConector::sendQuery($query);
			return $result;
		}

		/*
		* Metodo para obtener los datos basicos de una entrada
		*/
		public function dbListarEntradaBasic($id){
			$query = "SELECT
				id, usuario AS autor, coleccion, total_coment, tags, url
				FROM {$this->t_entrada}
				WHERE id = '{$id}'
			";
			$resultado = dbConector::query($query);
			if( $resultado ) return $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para obtener los datos basicos de una coleccion por url
		*/
		protected function dbListarColeccionBasicByURL($url){
			$query = "SELECT id, url, total_e FROM {$this->t_coleccion}
				WHERE url = '{$url}'
			";
			$resultado = dbConector::query($query);
			if( $resultado ) return $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para obtener los datos basico de una coleccion por url y id
		*/
		protected function dbListarColeccionBasicByURLID($url, $id){
			$query = "SELECT id FROM {$this->t_coleccion}
				WHERE url = '{$url}' AND id = '{$id}'
			";
			$resultado = dbConector::query($query);
			if( $resultado ) return $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para actualizar contador de entradas por coleccion
		*/
		protected function dbActulizarContECol($id, $total){
			$query = "UPDATE {$this->t_coleccion}
				SET total_e =  total_e + ({$total})
				WHERE id = {$id}
			";
			return dbConector::sendQuery($query);
		}

		/*
		* Metodo para actualizar contador de entradas por coleccion
		* basandose en la url
		*/
		protected function dbActulizarContEColByURL($url, $total){
			$query = "UPDATE {$this->t_coleccion}
				SET total_e =  total_e + ({$total})
				WHERE url = {$url}
			";
			return dbConector::sendQuery($query);
		}

		/* --------- CRUD de Colecciones --------- */

		/*
		* Metodo para crear coleccion
		*/
		protected function dbCrearColeccion($datos){
			$query = "INSERT INTO {$this->t_coleccion}(
				nombre,	url, descrip, tipo, superior, total_e
			) VALUES(
				'{$datos['nombre']}',
				'{$datos['url']}',
				'{$datos['descrip']}',
				'{$datos['tipo']}',
				'{$datos['superior']}',
				'{$datos['total_e']}'
			)";
			$result = dbConector::sendQuery($query);
			return $result;
		}

		/*
		* Metodo para listar colecciones
		*/
		protected function dbListarColecciones($tipo){
			$query = "SELECT id, nombre, url, descrip, total_e
				FROM {$this->t_coleccion}
				WHERE tipo='{$tipo}' AND estado=1
			";
			$result = dbConector::query($query);
			return $result;
		}

		/*
		* Metodo para listar colecciones
		*/
		protected function dbListarMenuColecciones($tipo){
			$query = "SELECT id, nombre FROM {$this->t_coleccion}
				WHERE tipo='{$tipo}' AND estado=1
			";
			$result = dbConector::query($query);
			return $result;
		}

		/*
		* Metodo para listar coleccion por su id
		*/
		protected function dbListarColeccionById($id, $tipo){
			$query = "SELECT id, nombre, url, descrip
				FROM {$this->t_coleccion}
				WHERE tipo='{$tipo}' AND estado=1 AND id='{$id}'
			";
			$result = dbConector::query($query);
			return $result;
		}

		/*
		* Metodo para listar coleccion por su url
		*/
		protected function dbListarColeccionByUrl($url, $tipo){
			$query = "SELECT id, nombre, url, descrip, total_e
				FROM {$this->t_coleccion}
				WHERE url='{$url}' AND tipo='{$tipo}' AND estado=1
			";
			$result = dbConector::query($query);
			if( $result ) return $result[0];
			return $result;
		}

		/*
		* Metodo para editar colecciones
		*/
		protected function dbEditarColeccion($datos){
			$query = "UPDATE {$this->t_coleccion}
				SET nombre='{$datos['nombre']}', url='{$datos['url']}',
				descrip='{$datos['descrip']}'
				WHERE id='{$datos['id']}'";
			$result = dbConector::sendQuery($query);
			return $result;
		}

		/*
		* Metodo para eliminar colecciones
		*/
		protected function dbEliminarColeccion($id){
			$query = "DELETE FROM {$this->t_coleccion} WHERE id='{$id}'";
			$result = dbConector::sendQuery($query);
			if( $result ) $result = dbConector::sendQuery(
				"UPDATE {$this->t_entrada} SET coleccion = '0'
				WHERE coleccion = '{$id}'"
			);
			return $result;
		}

		/*
		* Metodo para obtener los comentarios
		*/
		protected function dbListarComentarios(){
			$query = "SELECT
				a.id,
				a.autor,
				a.contenido,
				a.fecha,
				a.estado,
				b.titulo,
				b.url,
				b.coleccion as categoria_id,
				c.nombre as categoria,
				c.url as categoria_url
				FROM {$this->t_comentario} a
				LEFT JOIN {$this->t_entrada} b ON b.id = a.destino
				LEFT JOIN {$this->t_coleccion} c ON b.coleccion = c.id
				WHERE  ( a.estado = 1 OR a.estado = 2 ) AND b.estado != 0
				AND ( a.tipo = 1 OR a.tipo = 2 )";
			return dbConector::query($query);
		}

		/*
		* Metodo para obtener los comentarios spam
		*/
		protected function dbListarComentariosSpam(){
			$query = "SELECT
				a.id,
				a.autor,
				a.contenido,
				a.fecha,
				a.estado,
				b.titulo,
				b.url,
				b.coleccion as categoria_id,
				c.nombre as categoria,
				c.url as categoria_url
				FROM {$this->t_comentario} a
				LEFT JOIN {$this->t_entrada} b ON b.id = a.destino
				LEFT JOIN {$this->t_coleccion} c ON b.coleccion = c.id
				WHERE  a.estado = 3 AND b.estado != 0
				AND ( a.tipo = 1 OR a.tipo = 2 )";
			return dbConector::query($query);
		}

		/*
		* Metodo para obtener los comentarios de la papelera
		*/
		protected function dbListarComentariosPapelera(){
			$query = "SELECT
				a.id,
				a.autor,
				a.contenido,
				a.fecha,
				a.estado,
				b.titulo,
				b.url,
				b.coleccion as categoria_id,
				c.nombre as categoria,
				c.url as categoria_url
				FROM {$this->t_comentario} a
				LEFT JOIN {$this->t_entrada} b ON b.id = a.destino
				LEFT JOIN {$this->t_coleccion} c ON b.coleccion = c.id
				WHERE a.estado = 4 AND b.estado != 0
				AND ( a.tipo = 1 OR a.tipo = 2 )";
			return dbConector::query($query);
		}
		/*
		* Metodo para actulisar los comentarios
		*/
		protected function dbEditarComentario($datos){
			$query = "UPDATE {$this->t_comentario}
				SET contenido = '{$datos['contenido']}',
				estado = '{$datos['estado']}',
				autor = '{$datos['autor']}'
				WHERE id = '{$datos['id']}'
			";
			return dbConector::sendQuery($query);
		}

		/*
		*	Metodo para eliminar los comentarios
		*/
		protected function dbEliminarComentario($id){
			$query = "UPDATE {$this->t_comentario} SET estado = 4
				WHERE id = '{$id}'";
			return dbConector::sendQuery($query);
		}

		/*
		*	Metodo para eliminar los comentarios permanente
		*/
		protected function dbEliminarComentarioPermanente($id){
			$query = "UPDATE {$this->t_comentario} SET estado = 0
			WHERE id = '{$id}'";
			return dbConector::sendQuery($query);
		}

		/*
		* Metodo para obtener comentarios por ID
		*/
		protected function dbListarComentarioById($id){
			$query = "SELECT id, autor, contenido, estado
				FROM {$this->t_comentario}
				WHERE  estado != 0 AND id = '{$id}' AND
				( tipo = 1 OR tipo = 2 )";
			return dbConector::query($query);
		}

		/*
		* Metodo para ver si existe el comentario
		*/
		protected function dbExisteComentario($id){
			return dbConector::query(
				"SELECT id FROM {$this->t_comentario} WHERE id = '{$id}'"
			);
		}

		/*
		* Metodo para Actulizar contador de comentarios por entrada
		*/
		protected function dbActulizarContComentE($id, $total){
			$query = "UPDATE {$this->t_comentario}
				LEFT JOIN {$this->t_entrada}
				ON destino = {$this->t_entrada}.id
				SET total_coment = total_coment + ({$total})
				WHERE {$this->t_comentario}.id = {$id}
			";
			return dbConector::sendQuery($query);
		}

		/*
		* Metodo para extraer entrada por url
		*/
		protected function dbListarEntradaByUrl($url){
			$query = "SELECT id FROM {$this->t_entrada}
				WHERE url = '{$url}' AND estado != 0 ";
			$resultado = dbConector::query($query);
			if( $resultado ) return 1;
			return 0;
		}

		/*
		* Metodo para extra entrada por url y id
		*/
		protected function dbListarEntradaByUrlId($url, $id ){
			$query = "SELECT id FROM {$this->t_entrada}
				WHERE url = '{$url}'
				AND id = '{$id}' AND estado != 0";
			$resultado = dbConector::query($query);
			if( $resultado ) return 1;
			return 0;
		}

		protected function dbListarMangaCaps(){
			$query = "SELECT
				{$this->t_entrada}.id,
				{$this->t_entrada}.titulo,
				{$this->t_entrada}.descrip,
				{$this->t_entrada}.fecha,
				{$this->t_entrada}.coleccion
				FROM {$this->t_entrada}
				WHERE ( ( {$this->t_entrada}.estado=1 )
				OR ( {$this->t_entrada}.estado=2 )
				OR ( {$this->t_entrada}.estado=3 ) )
				AND {$this->t_entrada}.tipo=3
				ORDER BY descrip DESC
			";
			$result = dbConector::query($query);
			return $result;
		}

		protected function dbListarMangaCapsId($id){
			$query = "SELECT
				{$this->t_entrada}.id,
				{$this->t_entrada}.titulo,
				{$this->t_entrada}.descrip,
				{$this->t_entrada}.fecha,
				{$this->t_entrada}.coleccion
				FROM {$this->t_entrada}
				WHERE ( ( {$this->t_entrada}.estado=1 )
				OR ( {$this->t_entrada}.estado=2 )
				OR ( {$this->t_entrada}.estado=3 ) )
				AND {$this->t_entrada}.tipo=3
				AND {$this->t_entrada}.coleccion = {$id}
				ORDER BY descrip DESC
			";
			$result = dbConector::query($query);
			return $result;
		}

		/*
		* Metodo para actualizar contador de entradas por coleccion
		*/
		protected function dbActulizarMangaCaps($id, $total){
			return dbConector::sendQuery("UPDATE {$this->t_entrada}
				SET total_caps = (total_caps + {$total})
				WHERE id = {$id}
			");
		}

		/*
		* Metodo para obtener entrada tipo pagina
		*/
		protected function dbListarManga($id){
			$query = "SELECT
				{$this->t_entrada}.id,
				{$this->t_entrada}.titulo,
				{$this->t_entrada}.url,
				{$this->t_entrada}.descrip,
				{$this->t_entrada}.contenido,
				{$this->t_entrada}.coleccion
				FROM {$this->t_entrada}
				WHERE {$this->t_entrada}.id='{$id}'
				AND {$this->t_entrada}.tipo=3
			";
			$result = dbConector::query($query);
			return $result;
		}

	}
