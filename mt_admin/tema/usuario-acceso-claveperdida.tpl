<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reestablecer Contraseña - XPanel</title>
    <link rel="icon" href="favicon.ico" />
    <link rel="stylesheet" href="{tema_dir}/estilos.css" />
    <script src="{tema_dir}/js/funciones_acceso.js"></script>
</head>
<body class="bg-gris">
    <div>
        <form method="post" action="acceso?accion=claveperdida&enviar" id="acceso-cont" class="container cont-500" name="form_acceso">
            <div id="acceso-logotipo">
                <img src="{tema_dir}/img/logo-XPanel.png" />
            </div>
            <div class="form-campos">
				<label for="usuario">Recibir ayuda para restablecer contraseña</label>
                <input type="text" name="usuario" id="usuario" class="form-in" placeholder="Ingresa tu Usuario o Correo Electrónico" />
            </div>
            <div class="form-campos">
                <button class="btn-default btn-azul btn-block" type="submit">Enviar E-mail</button>
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
