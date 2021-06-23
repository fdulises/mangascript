<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	class apilector1{
		public $htmlactual;
		public $datos = array();
		public $caps = array();
		public function __construct(){
			$cachedir = 'mt_cache/cache_manga';
			$contenido = basicache::get($cachedir, $_GET['id']);
			if( $contenido ) $this->datos = unserialize($contenido);
			else{
				$this->urlmanga = 'http://www.tumangaonline.com/api/v1/mangas/'.$_GET['id'];
				$this->urlmangacaps = "{$this->urlmanga}/capitulos?page=";
				$this->urlmimg = 'http://img1.tumangaonline.com/';
				$this->htmlactual = $this->test($this->urlmanga);
				if(!$this->htmlactual) $this->datos['estado'] = 0;
				else $this->datos['estado'] = 1;
				$this->setDatos();
				$this->setDatosCaps();
				$this->datos['caps'] = $this->setCapsAll();
				basicache::put($cachedir, $_GET['id'], serialize($this->datos), (7*24*60*60));
			}
		}
		public function getContent($url){
			$this->getter = new getterdatos($url) or die("0");
		}
		public function test($url){
			@$test = new getterdatos($url) or die("0");
			return json_decode($test->html, true);
		}

		public function setDatos(){
			@$this->datos['cover'] = 'http://img1.tumangaonline.com/'.$this->htmlactual['imageUrl'];
			@$this->datos['titulo'] = $this->htmlactual['nombre'];
			@$this->datos['descrip'] = $this->htmlactual['info']['sinopsis'];
			@$this->datos['autor'] = $this->htmlactual['artistas'][0]['artista'];
			@$this->datos['generos'] = $this->setGeneros();
			@$this->datos['idtomo'] = $this->htmlactual['id'];
		}

		public function setDatosCaps(){
			$this->htmlactual = $this->test($this->urlmangacaps.'1');
			$this->datos['total'] = $this->htmlactual['total'];
			$this->datos['totalpages'] = $this->htmlactual['last_page'];
		}

		public function setGeneros(){
			if( $this->htmlactual ) $generos = $this->htmlactual['generos'];
			else $generos = array();
			$listag = array();
			foreach($generos as $v){
				$listag[] = $v['genero'];
			}
			return $listag;
		}

		public function setCapsAll(){
			$caps = array();
			$htmlactual = '';
			for( $i=1; $i<=$this->datos['totalpages']; $i++ ){
				$htmlactual = $this->test($this->urlmangacaps.$i);
				foreach( $htmlactual['data'] as $v ){
					$actualcap = array();
					$actualcap['id'] = $v['numCapitulo'];
					$actualcap['title'] = $v['nombre'];
					$actualcap['scanid'] = $v['subidas'][0]['scanlation']['id'];
					$actualcap['pages'] = $v['subidas'][0]['imagenes'];
					$caps[] = $actualcap;
				}
			}
			$caps = array_reverse($caps);
			return $caps;
		}

		public function getCap($cap, $pagina){
			$cap = $this->datos['caps'][$cap];
			$cap['pages'] = json_decode($cap['pages'], true);
			$lista_caps = array();
			$lista_caps['pagid'] = $cap['id'];
			$totalpages = count($cap['pages']);
			if( $pagina+1 > $totalpages ) $pagina = $totalpages-1;
			$lista_caps['pagtotal'] = $totalpages;
			$lista_caps['pagactual'] = ( isset( $cap['pages'][$pagina] ) ? $pagina : 1 );
			$lista_caps['paganterior'] = ( ($pagina-1) > -1 ) ? $pagina-1 : 0;
			$lista_caps['pagsiguiente'] = ( $pagina+1 < $totalpages ) ? $pagina+1 : $totalpages-1;
			$urlmimg  = 'http://img1.tumangaonline.com/';
			$lista_caps['pagimg'] = "{$urlmimg}subidas/{$this->datos['idtomo']}/{$cap['id']}/{$cap['scanid']}/{$cap['pages'][$pagina]}";
			$lista_caps['pagtitle'] = $this->datos['titulo'].' - '.$lista_caps['pagid'];
			return $lista_caps;
		}

		public function getCapFull($cap){
			$cap = $this->datos['caps'][$cap];
			$cap['pages'] = json_decode($cap['pages'], true);
			$lista_caps = array();
			$lista_caps['pagid'] = $cap['id'];
			$lista_caps['pagtitle'] = $this->datos['titulo'].' - '.$lista_caps['pagid'];
			$lista_caps['pagtotal'] = count($cap['pages']);

			$fullpags = array();
			foreach ($cap['pages'] as $k => $v) {
				$urlmimg  = 'http://img1.tumangaonline.com/';
				$fullpags[] = "{$urlmimg}subidas/{$this->datos['idtomo']}/{$cap['id']}/{$cap['scanid']}/{$cap['pages'][$k]}";
			}

			$lista_caps['pages'] = $fullpags;

			return $lista_caps;
		}
	}
