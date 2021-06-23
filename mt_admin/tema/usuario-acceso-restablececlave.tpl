<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reestablecer Contraseña - XPanel</title>
    <link rel="icon" href="favicon.ico" />
    <link rel="stylesheet" href="{tema_dir}/estilos.css" />
    <script src="{tema_dir}/js/funciones_acceso.js"></script>
	<script src="{tema_dir}/js/sha512.js"></script>
</head>
<body class="bg-gris">
    <div>
        <form method="post" action="acceso?accion=restablececlave&enviar" id="acceso-cont" class="container cont-500" name="form_restablececlave">
            <div id="acceso-logotipo">
                <img src="{tema_dir}/img/logo-XPanel.png" />
            </div>
            <div class="form-campos">
                <input type="password" name="clave" id="clave" class="form-in" placeholder="Ingresa Nueva Clave" />
                <input type="hidden" name="id" value="{id}" />
            </div>
            <div class="form-campos">
                <button class="btn-default btn-azul btn-block" type="submit">Reestablecer Contraseña</button>
				<a href="acceso" class="btn-default">Cancelar e Iniciar Sesión</a>
            </div>
            <div id="lista_errores"></div>
        </form>
        <footer id="acceso-copy">
            <div class="container">
                <h6>XPanel &copy; 2016 - Todos los derechos resrvados.</h6>
            </div>
        </footer>
    </div>
</body>
</html>
