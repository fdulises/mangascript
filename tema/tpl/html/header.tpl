<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{SITIO_TITULO} - {pagina_titulo}</title>
	<link rel="icon" href="{SITIO_URL}/favicon.ico" />
	<link rel="alternate" type="application/rss+xml" href="{SITIO_URL}/rss" />
	<link rel="alternate" type="application/xml" href="{SITIO_URL}/sitemap.xml" />
    <link rel="stylesheet" href="{TEMA_URL}/estilos.css" />
    <link rel="stylesheet" href="{TEMA_URL}/css/extras.css" />
	<link rel="canonical" href="{pagina_enlace}" />
	<link rel="shortlink" href="{pagina_enlace}" />
	<meta name="description" content="{pagina_descrip}" />
	<meta name="generator" content="mictlan cms" />
	<script>var SITIO_URL = '{SITIO_URL}';</script>
</head>
<body>
    <header id="cont-sup" class="nav-default">
        <div class="container">
            <a href="{SITIO_URL}" id="logotipo" class="brand">{SITIO_TITULO}</a>
            <form method="get" action="{SITIO_URL}/busqueda" data-estado="oculto" id="busqueda" class="search-st1">
                <input type="text" name="b" id="" placeholder="Buscar..." />
                <button type="submit"><span class="icon-search"></span></button>
            </form>
            <button class="sdw-btn bx-right" type="button" data-destino="#nav-first" id="switchnav" data-estado="cerrado">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </button>
            <button class="enlace bx-right" type="button" data-destino="#busqueda" id="btn-buscar" data-estado="cerrado">
                <span class="icon-search"></span>
            </button>
        </div>
    </header>
    <nav class="nav-barra barra-blue" id="nav-first" data-estado="oculto">
        <ul class="container nav-hor">
            <li><a href="{SITIO_URL}">Inicio</a></li>
            <li><a href="{SITIO_URL}/busqueda">Lista de Mangas</a></li>
            <li><a href="{SITIO_URL}/letra">Mangas por Letra</a></li>
			<li><a href="{SITIO_URL}/pedidos">Pedidos</a></li>
            <li><a href="{SITIO_URL}/contacto">Contacto</a></li>
        </ul>
    </nav>
