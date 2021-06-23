<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Clase encargada del sistema de entradas
	* Provee todos los metodos requeridos para entradas y colecciones
	*/
	require 'datos/db_entrada.php';
	class entrada extends db_entrada{

		public $error = array();
		public $SITIO_DIRECCION = SITIO_DIRECCION;
		public function __construct(){}

		/* --------- Metodos relacionados con las entradas --------- */

		/*
		* Metodo para crear nueva entrada
		*/
		private function crearEntrada($datos){
			$datos_f = array(
				'titulo' => $datos['titulo'],
				'url' => $datos['url'],
				'fecha' => date('Y-m-d'),
				'fecha_u' => date('Y-m-d H:i:s'),
				'descrip' => $datos['descrip'],
				'contenido' => $datos['contenido'],
				'coleccion' =>  $datos['coleccion'],
				'tags' => $datos['tags'],
				'portada' => $datos['portada'],
				'usuario' => $_SESSION[S_USERID],
				'estado' => $datos['estado'],
				'tipo' => $datos['tipo'],
				'plantilla' => $datos['plantilla'],
				'manga_api' => '',
				'manga_api_id' => '',
			);
			if( isset($datos['manga_api']) ) $datos_f['manga_api'] = $datos['manga_api'];
			if( isset($datos['manga_api_id']) ) $datos_f['manga_api_id'] = $datos['manga_api_id'];
			return $this->dbCrearEntrada($datos_f);
		}

		/* --------- CRUD de Entradas tipo Pagina --------- */

		/*
		* Metodo para agregar nueva pagina
		*/
		public function agregarPagina($datos){
			$err = extras::verifCampoVacio(array(
				'titulo' => $datos['titulo'],
				'url' => $datos['url'],
				'estado' => $datos['estado'],
			));
			if(count($err)) $this->error = $err;
			else{
				$datos_f = array(
					'titulo' => $datos['titulo'],
					'url' => $datos['url'],
					'descrip' => $datos['descrip'],
					'contenido' => $datos['contenido'],
					'portada' => $datos['portada'],
					'coleccion' =>  0,
					'tags' => '',
					'estado' => $datos['estado'],
					'tipo' => 1,
					'plantilla' => $datos['plantilla'],
				);
				$resultado = $this->crearEntrada(dbConector::escape(
					extras::addslashes($datos_f)
				));
				if( $resultado ){
					$this->dbActulizarContS('total_p', 1);
					$this->dbActulizarContEU($_SESSION[S_USERID], 1);
				}
				return $resultado;
			}
			return 0;
		}

		/*
		* Metodo para obtener entrada tipo pagina
		*/
		public function listarPagina($id){
			$id = (INT) $id;
			$resultado = $this->dbListarPagina($id);
			if($resultado) return $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para obtener entradas tipo pagina
		*/
		public function listarPaginas(){
			$resultado = $this->dbListarPaginas();
			foreach ($resultado as $k => $v) {
				$resultado[$k]['enlace'] = "{$this->SITIO_DIRECCION}/{$v['url']}";
				$resultado[$k]['fecha'] = extras::fechaF1($v['fecha']);
			}
			return $resultado;
		}

		/*
		* Metodo para obtener paginas en la papelera
		*/
		public function listarPaginasPapelera(){
			$resultado = $this->dbListarPaginasPapelera();
			foreach ($resultado as $k => $v) {
				$resultado[$k]['fecha'] = extras::fechaF1($v['fecha']);
			}
			return $resultado;
		}

		/*
		* Metodo para modificar entrada tipo pagina
		*/
		public function editarPagina($datos){
			$err = extras::verifCampoVacio(array(
				'titulo' => $datos['titulo'],
				'url' => $datos['url'],
				'estado' => $datos['estado'],
			));
			if(count($err)) $this->error = $err;
			else{
				$datos_f = array(
					'id' => (INT) $datos['id'],
					'titulo' => $datos['titulo'],
					'url' => $datos['url'],
					'descrip' => $datos['descrip'],
					'contenido' => $datos['contenido'],
					'superior' => 0,
					'portada' => $datos['portada'],
					'estado' => $datos['estado'],
					'plantilla' => $datos['plantilla'],
				);
				$result = $this->dbEditarPagina(
					extras::addslashes(dbConector::escape($datos_f))
				);
				return $result;
			}
			return 0;
		}

		/*
		* Metodo para eliminar entradas y mandarlas a la papelera
		*/
		public function eliminarPagina($id){
			return $this->dbEliminarEntrada($id);
		}

		/*
		* Metodo para eliminar entradeas der forma permanente
		*/
		public function eliminarPaginaPermanente($id){
			$resultado = $this->dbEliminarEntradaPermanente($id);
			if( $resultado ){
				$datos = $this->dbListarEntradaBasic($id);
				$this->dbActulizarContS('total_p', -1);
				$this->dbActulizarContS('total_c', -($datos['total_coment']));
				$this->dbActulizarContEU($datos['autor'], -1);
			}
			return $resultado;
		}

		/* --------- CRUD de Entradas tipo Articulo --------- */

		/*
		* Metodo para agregar nuevo articulo
		*/
		public function agregarArticulo($datos){
			$err = extras::verifCampoVacio(array(
				'titulo' => $datos['titulo'],
				'url' => $datos['url'],
				'estado' => $datos['estado'],
				'categoria' => $datos['categoria'],
			));
			if(count($err)) $this->error = $err;
			else{
				$datos_f = array(
					'titulo' => $datos['titulo'],
					'url' => $datos['url'],
					'descrip' => $datos['descrip'],
					'contenido' => $datos['contenido'],
					'portada' => $datos['portada'],
					'coleccion' =>  $datos['categoria'],
					'tags' => $datos['tags'],
					'estado' => $datos['estado'],
					'tipo' => 2,
					'plantilla' => '',
					'manga_api' => (INT) $datos['manga_api'],
					'manga_api_id' => $datos['manga_api_id'],
				);
				//Limpiamos los datos para evitar sql inyection
				$datos_f = dbConector::escape( extras::addslashes($datos_f) );
				//validamos la url
				$validar_url = $this->validarUrlEntrada( $datos_f['url'] );
				if ( $validar_url ){
					$resultado = $this->crearEntrada( $datos_f );
					if( $resultado ){
						$this->dbActulizarContS('total_a', 1);
						$this->dbActulizarContEU($_SESSION[S_USERID], 1);
						$this->dbActulizarContECol($datos['categoria'], 1);
						//Agregamos las tags del articulo
						if( strlen(trim($datos['tags'])) )
						$this->agregaTags( $datos['tags'] );
					}
					return $resultado;
				}
			}
			return 0;
		}

		/*
		* Metodo para obtener entradas tipo articulo
		*/
		public function listarArticulos($opciones = array()){
			$resultado = $this->dbListarArticulos($opciones);
			foreach ($resultado as $k => $v) {
				if ($v['categoria'] )
					$resultado[$k]['enlace'] = "{$this->SITIO_DIRECCION}/{$v['categoria_url']}/{$v['url']}";
				else
					$resultado[$k]['enlace'] = "{$this->SITIO_DIRECCION}/{$v['url']}";

				$resultado[$k]['fecha'] = extras::fechaF1($v['fecha']);
			}
			return $resultado;
		}

		public function foundRows(){
			return $this->dbFoundRows();
		}

		/*
		* Metodo para obtener entrada tipo articulo
		*/
		public function listarArticulo($id){
			$id = (INT) $id;
			$resultado = $this->dbListarArticulo($id);
			if($resultado) return $resultado[0];
			return $resultado;
		}

		/*
		* Metodo para obtener articulos en la papelera
		*/
		public function listarArticulosPapelera(){
			$resultado = $this->dbListarArticulosPapelera();
			foreach ($resultado as $k => $v) {
				$resultado[$k]['fecha'] = extras::fechaF1($v['fecha']);
			}
			return $resultado;
		}

		/*
		* Metodo para modificar entrada tipo pagina
		*/
		public function editarArticulo($datos){
			$err = extras::verifCampoVacio(array(
				'titulo' => $datos['titulo'],
				'url' => $datos['url'],
				'estado' => $datos['estado'],
				'categoria' => $datos['categoria'],
			));
			if(count($err)) $this->error = $err;
			else{
				$datos_f = array(
					'id' => (INT) $datos['id'],
					'titulo' => $datos['titulo'],
					'url' => $datos['url'],
					'fecha_u' => date('Y-m-d H:i:s'),
					'descrip' => $datos['descrip'],
					'contenido' => $datos['contenido'],
					'coleccion' => $datos['categoria'],
					'portada' => $datos['portada'],
					'estado' => $datos['estado'],
					'tags' => $datos['tags'],
					'manga_api' => (INT) $datos['manga_api'],
					'manga_api_id' => $datos['manga_api_id'],
				);
				$datos_f = extras::addslashes(dbConector::escape($datos_f));
				//validmos url
				$validar_url = $this->validarUrlEntrada( $datos_f['url'], $datos_f['id'] );
				if( $validar_url ){
					$last_datos = $this->dbListarEntradaBasic( $datos_f['id'] );
					$resultado = $this->dbEditarArticulo( $datos_f );
					//Agregamos las categorias del articulo
					if( $resultado && $last_datos ){
						// Actualizamos los datos de las tags
						$this->actualizaDatosTagsEditarA($last_datos['tags'], $datos_f['tags']);
						//Actualizamos contador de categorias si se cambia la categoria
						if( $datos_f['coleccion'] != $last_datos['coleccion'] ){
							$this->dbActulizarContECol($datos_f['coleccion'], 1);
							$this->dbActulizarContECol($last_datos['coleccion'], -1);
						}
					}
					return $resultado;
				}
			}
			return 0;
		}

		/*
		* Metodo para eliminar entradas y mandarlas a la papelera
		*/
		public function eliminarArticulo($id){
			return $this->dbEliminarEntrada($id);
		}

		/*
		* Metodo para eliminar entradeas de forma permanente
		*/
		public function eliminarArticuloPermanente($id){
			$resultado = $this->dbEliminarEntradaPermanente($id);
			if( $resultado ){
				$datos = $this->dbListarEntradaBasic($id);
				$this->dbActulizarContS('total_a', -1);
				$this->dbActulizarContS('total_c', -($datos['total_coment']));
				$this->dbActulizarContEU($datos['autor'], -1);
				$this->dbActulizarContECol($datos['coleccion'], -1);
				if( strlen( trim($datos['tags']) ) )
					$this->contadorTagsDecremento( $datos['tags'] );
			}
			return $resultado;
		}

		/*
		* Metodo para validar url de la entrada
		*/
		public function validarUrlEntrada( $url, $id = false ){
			if( extras::validarUrl( $url ) ){
				if($id){
					if( $this->dbListarEntradaByUrlId( $url , $id ) )
						return 1;
					if( $this->dbListarEntradaByUrl( $url ) )
						return 0;
					return 1;
				}else{
					if( $this->dbListarEntradaByUrl( $url ) )
						return 0;
					return 1;
				}
			}
			return 0;
		}

		/* --------- CRUD de Categorias --------- */

		/*
		* Metodo para crear colecciones tipo catagoria
		*/
		public function creaCategoria($datos){
			$err = extras::verifCampoVacio(array(
				'nombre' => $datos['nombre'],
				'url' => $datos['url'],
			));
			if(count($err)) $this->error = $err;
			else{
				$datos_f = array(
					'nombre' => $datos['nombre'],
					'url' => $datos['url'],
					'descrip' => $datos['descrip'],
					'tipo' => 1,
					'superior' => 0,
					'total_e' => 0,
				);
				$datos_f = dbConector::escape( extras::addslashes( $datos_f ) );
				//verificamos si la categori es valida
				$validar_url = $this->validarUrlCat( $datos_f['url'] );
				if($validar_url){
					$resultado = $this->dbCrearColeccion($datos_f);
					if( $resultado ) $this->dbActulizarContS('total_cat', 1);
					return $resultado;
				}
			}
			return 0;
		}

		/*
		* Metodo para obtener lista de colecciones tipo categoria
		*/
		public function listarCategorias(){
			return $this->dbListarColecciones(1);
		}

		/*
		* Metodo para obtener datos basicos de categorias para menus
		*/
		public function listarMenuCategorias(){
			return $this->dbListarMenuColecciones(1);
		}

		/*
		* Metodo para obtener categoria
		*/
		public function listarCategoria($id){
			$id = (INT) $id;
			$resultado = $this->dbListarColeccionById($id, 1);
			if( $resultado ) return $resultado[0];
			return array();
		}

		/*
		* Metodo para editar colecciones tipo categoria
		*/
		public function editarCategoria($datos){
			$err = extras::verifCampoVacio(array(
				'nombre' => $datos['nombre'],
				'url' => $datos['url'],
			));
			if(count($err)) $this->error = $err;
			else{
				$datos_f = array(
					'id' => (INT) $datos['id'],
					'nombre' => $datos['nombre'],
					'url' => $datos['url'],
					'descrip' => $datos['descrip'],
				);
				$datos_f = extras::addslashes(dbConector::escape($datos_f));
				$validar_url = $this->validarUrlCat($datos_f['url'] , $datos_f['id']);
				if($validar_url){
					$result = $this->dbEditarColeccion($datos_f);
					return $result;
				}
			}
			return 0;
		}

		/*
		* Metodo para eliminar colecciones tipo categoria
		*/
		public function eliminarCategoria($id){
			$id = (INT) $id;
			$this->dbActulizarContS('total_cat', -1);
			return $this->dbEliminarColeccion($id);
		}

		/*
		* Metodo para validar url de la catgoria
		*/
		public function validarUrlCat($url , $id = false){
			if( extras::validarUrl( $url ) ){
				if($id){
					if($this->dbListarColeccionBasicByURLID($url,$id))
						return 1;
					if($this->dbListarColeccionBasicByURL($url))
						return 0;
					return 1;
				}else {
					if($this->dbListarColeccionBasicByURL($url))
						return 0;
					return 1;
				}
			}
			return 0;
		}

		/* --------- CRUD de Tags --------- */

		/*
		* Metodo para crear tags
		* Si la tag existe solo se actualiza su contador de articulos,
		* si no esta es creada y se actualiza el contador de tags del sitio
		*/
		private function agregaTags($datos){
			if( $datos ) $tags = extras::trim(explode(',', $datos));
			else $tags = array();
			foreach ($tags as $v){
				$resultado = $this->dbListarColeccionByUrl($v, 2);
				if( !$resultado ){
					if($this->dbCrearColeccion(array(
						'nombre' => $v,
						'url' => $v,
						'descrip' => '',
						'tipo' => 2,
						'superior' => 0,
						'total_e' => 1,
					))) $this->dbActulizarContS('total_t', 1);
				}else{
					$this->dbActulizarContECol($resultado['id'], 1);
					if( ( $resultado['total_e']+1 ) == 1 )
						$this->dbActulizarContS('total_t', 1);
				}
			}
		}

		/*
		* Metodo para actualizar datos de tags al editar un articulo
		* Actualiza los contadores de tags por articulo y agrega las nuevas tags
		*/
		public function actualizaDatosTagsEditarA($tags_before, $tags_after){
			$tags_last = extras::trim(explode(',', $tags_before));
			$tags_actual = extras::trim(explode(',', $tags_after));
			$tags_eliminadas = array();
			$tags_agregadas = array();
			foreach ($tags_last as $v) {
				if( !in_array( $v, $tags_actual ) ) $tags_eliminadas[] = $v;
			}
			foreach ($tags_actual as $v) {
				if( !in_array( $v, $tags_last ) ) $tags_agregadas[] = $v;
			}
			if( count( $tags_eliminadas ) )
				$this->contadorTagsDecremento( implode(',', $tags_eliminadas) );
			$this->agregaTags( implode(',', $tags_agregadas) );
		}

		/*
		* Metodo para decrementar contador de articulos por tag
		*/
		private function contadorTagsDecremento($tags){
			$tags = extras::trim(explode(',', $tags));
			if( !count($tags) ) $tags = null;
			$total_tags = 0;
			foreach ($tags as $v){
				$datos_tags = $this->dbListarColeccionBasicByURL($v);
				if( isset($datos_tags['total_e']) ){
					if( ($datos_tags['total_e']-1) == 0 ) $total_tags++;
					if( ($datos_tags['total_e']-1) >= 0 )
						$this->dbActulizarContECol($datos_tags['id'], -1);
				}
			}
			if( $total_tags > 0 ) $this->dbActulizarContS('total_t', -$total_tags);
		}

		/* --------- CRUD de Comentarios --------- */

		/*
		* Metodo para obtener lista de comentarios
		*/
		public function listarComentarios(){
			$resultado = $this->dbListarComentarios();
			foreach ($resultado as $k => $v) {
				$resultado[$k]['fecha'] = extras::fechaF1($v['fecha']);
				if( $v['categoria'] )
					$resultado[$k]['url'] = SITIO_DIRECCION.'/'.$v['categoria_url'].'/'.$v['url'];
				else $resultado[$k]['url'] = SITIO_DIRECCION.'/'.$v['url'];
			}
			return $resultado;
		}

		/*
		* Metodo para obtener lista de papelera de comentarios
		*/
		public function listarComentariosPapelera(){
			$resultado = $this->dbListarComentariosPapelera();
			foreach ($resultado as $k => $v) {
				$resultado[$k]['fecha'] = extras::fechaF1($v['fecha']);
				if( $v['categoria'] )
					$resultado[$k]['url'] = SITIO_DIRECCION.'/'.$v['categoria_url'].'/'.$v['url'];
				else $resultado[$k]['url'] = SITIO_DIRECCION.'/'.$v['url'];
			}
			return $resultado;
		}

		/*
		* Metodo para obtener lista de comentarios de bandeja de spam
		*/
		public function listarComentariosSpam(){
			$resultado = $this->dbListarComentariosSpam();
			foreach ($resultado as $k => $v) {
				$resultado[$k]['fecha'] = extras::fechaF1($v['fecha']);
				if( $v['categoria'] )
					$resultado[$k]['url'] = SITIO_DIRECCION.'/'.$v['categoria_url'].'/'.$v['url'];
				else $resultado[$k]['url'] = SITIO_DIRECCION.'/'.$v['url'];
			}
			return $resultado;
		}

		/*
		* Metodo para actulizar comentario
		*/
		public function editarComentario($datos){
			return $this->dbEditarComentario(
				extras::addslashes(dbConector::escape($datos))
			);
		}

		/*
		*	Metodo para eliminar comentario por su id
		*/
		public function eliminarComentario($id){
			$id = (INT) $id;
			return $this->dbEliminarComentario($id);
		}

		/*
		*	Metodo para eliminar los comentarios permanentemente
		*/
		public function eliminarComentarioPermanente($id){
			$id = (INT) $id;
			$resultado = $this->dbEliminarComentarioPermanente($id);
			if( $resultado ){
				$this->dbActulizarContComentE($id, -1);
				$this->dbActulizarContS('total_c', -1);
			}
			return $resultado;
		}

		/*
		* Metodo para obtener comentarios por ID
		*/
		public function listarComentarioById($id){
			$id = (INT) $id;
			return $this->dblistarComentarioById($id)[0];
		}

		/*
		* Metodo para ver si existe el comentario
		*/
		public function existeComentario($id){
			$id = (INT) $id;
			return $this->dbExisteComentario($id);
		}


		/*
		* Metodo para agregar nuevo capitulo de manga
		*/
		public function agregarMangaCap($datos){
			$err = extras::verifCampoVacio(array(
				'titulo' => $datos['titulo'],
				'idcapitulo' => $datos['idcapitulo'],
				'paginas' => $datos['paginas'],
				'mangaid' => $datos['mangaid'],
			));
			if(count($err)) $this->error = $err;
			else{
				$datos_f = array(
					'titulo' => $datos['titulo'],
					'descrip' => $datos['idcapitulo'],
					'contenido' => $datos['paginas'],
					'url' => '',
					'coleccion' => $datos['mangaid'],
					'tags' => '',
					'portada' => '',
					'usuario' => $_SESSION[S_USERID],
					'estado' => 1,
					'tipo' => 3,
					'plantilla' => '',
				);
				//Limpiamos los datos para evitar sql inyection
				$datos_f = dbConector::escape( extras::addslashes($datos_f) );
				$resultado = $this->crearEntrada( $datos_f );
				if( $resultado ) $this->dbActulizarMangaCaps($datos['mangaid'], 1);
				return $resultado;
			}
			return 0;
		}

		/*
		* Metodo para obtener entradas tipo capitulo
		*/
		public function listarMangaCaps(){
			$resultado = $this->dbListarMangaCaps();
			return $resultado;
		}
		public function listarMangaCapsId($id){
			$resultado = $this->dbListarMangaCapsId($id);
			foreach ($resultado as $k => $v) {
				$resultado[$k]['enlace'] = "";
				$resultado[$k]['fecha'] = extras::fechaF1($v['fecha']);
			}
			return $resultado;
		}
		/*
		* Metodo para eliminar entradeas de forma permanente
		*/
		public function eliminarMangaCap($id){
			$resultado = $this->dbEliminarEntradaPermanente($id);
			if( $resultado ){
				$datos = $this->dbListarEntradaBasic($id);
				$this->dbActulizarMangaCaps($datos['coleccion'], -1);
			}
			return $resultado;
		}

		/*
		* Metodo para obtener entrada tipo articulo
		*/
		public function listarManga($id){
			$id = (INT) $id;
			$resultado = $this->dbListarManga($id);
			if($resultado) return $resultado[0];
			return $resultado;
		}

	}
