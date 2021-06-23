<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/

	#Ocultar/Mostrar contenido para adultos
	if( isset($_GET['adultcont']) )
		setcookie('adultcont', 'true', time()+60*60*24*30, '/', '', false, true);

	$lista_articulos = $mt->getEntrada(array(
		'id' => $mt->seccion['id'],
		'columnas' => array(
			'e.id as articulo_id',
			'e.titulo as articulo_titulo',
			'e.descrip as articulo_descrip',
			'e.fecha_u as articulo_fecha',
			'e.total_coment as articulo_comentarios',
			'col.nombre as articulo_coleccion_nombre',
			'enlace as articulo_enlace',
			'e.contenido as articulo_contenido',
			'u.email as articulo_autor_email',
			'u.nickname as articulo_autor',
			'p.nombre as articulo_autor_nombre',
			'p.descrip as articulo_autor_descrip',
			'e.total_caps',
			'e.manga_api',
			'e.manga_api_id',
			'e.portada as articulo_cover',
			'e.tags as articulo_tags',
		),
	));
	$lista_articulos['articulo_autor_avatar'] = extras::urlGravatar(
		$lista_articulos['articulo_autor_email'], 100
	);
	$mt->plantilla->setEtiqueta($lista_articulos);

	//Bloque con lista de generos
	$lista_articulos['articulo_tags'] = explode(',', $lista_articulos['articulo_tags']);
	$aux1 = array();

	#Ocultar/Mostrar contenido para adultos
	$adultcont = false;

	foreach($lista_articulos['articulo_tags'] as $v ){

		#Ocultar/Mostrar contenido para adultos
		if( preg_match('/(ecchi|yuri|yaoi)/i', $v) ) $adultcont = true;

		$aux2 = array('nombre' => $v);
		$aux1[] = $aux2;
	}
	$lista_articulos['articulo_tags'] = $aux1;
	$mt->plantilla->setBloque('lista_generos', $lista_articulos['articulo_tags']);

	#Ocultar/Mostrar contenido para adultos
	if( $adultcont && !isset($_COOKIE['adultcont']) )
		header("location: {$mt->getInfo('url')}/adultcont?id={$mt->seccion['enlace']}");

	//BLoque con lista de articulos relacionados
	$mt->plantilla->setBloque('lista_relacionados', $mt->getEntrada(array(
		'columnas' => array(
			'e.id as entrada_id',
			'e.portada as entrada_portada',
			'e.titulo as entrada_titulo',
			'enlace as entrada_enlace',
		),
		'limit' => 6,
		'orden' => 'e.fecha_u',
		'disp' => 'DESC',
		'portada_default' => 'https://source.unsplash.com/random',
		'tipo' => 2,
	)));

	//Obtenemos y mostramos los comentarios para la entrada
	$lista_comentarios = $mt->getComentario(array(
		'destino' => $lista_articulos['articulo_id'],
		'columnas' => array(
			'id as comentario_id',
			'autor as comentario_autor',
			'email as comentario_email',
			'sitio as comentario_sitio',
			'contenido as comentario_contenido',
			'fecha as comentario_fecha'
		 ),
	));

	//Generamos el avatar para el comentario
	foreach ($lista_comentarios as $k => $v){
		$lista_comentarios[$k]['comentario_avatar'] = extras::urlGravatar($v['comentario_email'], 50);
		if( $lista_comentarios[$k]['comentario_sitio'] ){
			$lista_comentarios[$k]['comentario_enlace'] = "<a href=\"{$lista_comentarios[$k]['comentario_sitio']}\" rel=\"nofollow\" target=\"_blank\" class=\"comentario_enlace\" title=\"Visitar sitio web de {$lista_comentarios[$k]['comentario_autor']}\">{$lista_comentarios[$k]['comentario_autor']}</a>";
		}else{
			$lista_comentarios[$k]['comentario_enlace'] = $lista_comentarios[$k]['comentario_autor'];
		}
	}
	$mt->plantilla->setCondicion('si_comentarios', count($lista_comentarios));
	$mt->plantilla->setBloque('lista_comentarios', $lista_comentarios);

	$mt->plantilla->setEtiqueta('pagina_descrip', $lista_articulos['articulo_descrip']);

	$capitulos = $mt->getEntrada(array(
		'columnas' => array(
			'e.id as mangacap_id',
			'e.titulo as mangacap_titulo',
			'e.descrip as mangacap_descrip',
			'e.contenido as mangacap_contenido',
		),
		'disp' => 'DESC',
		'orden' => 'e.descrip',
		'tipo' => 3,
		'filtro' => "e.coleccion = {$mt->seccion['id']}",
	));
	$capitulosno = array();
	foreach ($capitulos as $k => $v) {
		//$v['mangacap_contenido'] = explode(',', $v['mangacap_contenido']);
		$clave = (INT) $v['mangacap_descrip'];
		$v['enlace'] = $mt->seccion['enlace'].'?cap='.$clave;
		$v['mangacap_apiruta'] = "{$mt->getInfo('url')}/apimanga_sitio?id={$v['mangacap_id']}";
		$capitulosno[$clave] = $v;
	}
	ksort($capitulosno);
	$capitulos = $capitulosno;

	if( (0 == $lista_articulos['total_caps']) && $lista_articulos['manga_api'] && $lista_articulos['manga_api_id'] ){

		if( $lista_articulos['manga_api'] == 1 ){
			$apiruta = "{$mt->getInfo('url')}/lector/{$lista_articulos['manga_api_id']}";
			die(header('location: '.$apiruta));
		}else if( $lista_articulos['manga_api'] == 2 ){
			$apiruta = "{$mt->getInfo('url')}/apimanga2?id={$lista_articulos['manga_api_id']}&all";
			@$getter = new getterdatos($apiruta);
			@$getter = json_decode($getter->html, true);
			if( $getter ) $getter = $getter['caps'];
			foreach ($getter as $k => $v) {
				$captual = array();
				$captual['mangacap_id'] = $k;
				$captual['mangacap_titulo'] = $v['title'];
				$captual['mangacap_descrip'] = $v['id'];
				$captual['mangacap_contenido'] = $v['pages'];
				$captualmangacap_id = (INT) $v['id'];
				$k1 = $k+1;
				$captual['enlace'] = $mt->seccion['enlace'].'?cap='.$k1;
				$captual['mangacap_apiruta'] = "{$apiruta}&cap={$k1}";
				$capitulos[] = $captual;
			}
		}
	}
	$mt->plantilla->setBloque('lista_capitulos', $capitulos);

	$mt->plantilla->display('tpl/articulo');
