<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página de Acceso - XPanel</title>
    <link rel="icon" href="favicon.ico" />
    <link rel="stylesheet" href="{tema_dir}/estilos.css" />
    <script src="{tema_dir}/js/sha512.js"></script>
    <script src="{tema_dir}/js/funciones_acceso.js"></script>
</head>
<body id="acceso-cont-img">
    <div>
        <form method="post" action="?iniciar" id="acceso-cont" class="container cont-500" name="form_acceso">
            <div id="acceso-logotipo">
                <img src="{tema_dir}/img/logo-XPanel.png" />
            </div>
            <div class="form-campos">
                <input type="text" name="usuario" id="usuario" class="form-in" placeholder="Usuario o Correo Electrónico" />
            </div>
            <div class="form-campos">
                <input type="password" name="clave" id="clave" class="form-in" placeholder="Contraseña" />
            </div>
			<div class="form-campos form-checkbox">
				<input type="checkbox" name="recordars" id="recordars" />
				<label for="recordars">Mantener sesión iniciada.</label>
            </div>
            <div class="form-campos">
                <button class="btn-default btn-azul btn-block" type="submit">Inicia Sesión</button>
				<a href="acceso?accion=claveperdida" class="btn-default">Recuperar Contraseña</a>
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
