<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{pagina_titulo}</title>
    <link rel="icon" href="{SITIO_URL}/favicon.ico" />
    <link rel="stylesheet" href="{tema_dir}/estilos.css" />
	<script>
		var SITIO_URL = '{SITIO_URL}';
	</script>
    <script src="{tema_dir}/js/mw.js"></script>
    <script src="{tema_dir}/js/funciones.js"></script>
    <script src="{tema_dir}/js/sha512.js"></script>
    <script src="{tema_dir}/js/holder.js"></script>
	<meta name="generator" content="mictlan cms" />
    <!--<script src="{SITIO_URL}/mt_extras/ckeditor/ckeditor.js"></script>-->
</head>
<body>
<header>
    <div class="fondo-b">
        <nav id="mnav">
            <div class="container">
                <div id="mlogotipo">
                    <a href="inicio">
                        <img src="{tema_dir}/img/logo-XPanel.png" />
                    </a>
                </div>
                <ul>
                    <li><a href="sitio">Sitio</a></li>
					<li><a href="manga">Mangas</a></li>
                    <li><a href="pagina">Páginas</a></li>
                    <li><a href="usuario">Usuarios</a></li>
                </ul>
                [si_sesion]
                <ul class="bx-der">
                    <li><a href="usuario?accion=editar&id={userid}" title="Editar mi cuenta"><img class="avatar_mini" src="{gravatar}" /> <span class="text-nickname">@{nickname}</span></a></li>
                    <li><a href="salir" title="Cerrar sesion  - {nickname}"><span class="icon-switch"></span></a></li>
                </ul>
                [/si_sesion]
            </div>
        </nav>
    </div>
</header>
