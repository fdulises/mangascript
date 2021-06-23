{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li class="active"><a href="sitio">Sitio</a></li>
            <li><a href="configuracion">Configuración</a></li>
            <li><a href="estadisticas">Estadisticas</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form method="post" action="?guardar" name="form_s_editar" class="container cont-750">
        <h1>Configurar Información del sitio</h1>
        <div class="form-campos">
            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo" id="titulo" class="form-in" value="{sitio_titulo}" />
        </div>
        <div class="form-campos">
            <label for="lema">Lema:</label>
            <input type="text" name="lema" id="lema" class="form-in" value="{sitio_lema}" />
        </div>
        <div class="form-campos">
            <label for="descrip">Descripción:</label>
            <textarea name="descrip" id="descrip" class="form-in">{sitio_descrip}</textarea>
        </div>
        <div class="form-campos">
            <label for="url">URL del sitio:</label>
            <input type="text" name="url" id="url" class="form-in" value="{sitio_url}" />
        </div>
		<div class="form-campos">
            <label for="email">Email del sitio:</label>
            <input type="text" name="email" id="email" class="form-in" value="{sitio_email}" />
        </div>
        <div class="form-campos">
            <label for="cms_infv">Información del CMS:</label>
            <input type="text" id="cms_infv" class="form-in" value="{cms_info} {cms_v}" disabled="disabled" />
        </div>
		<div class="form-campos">
            <input type="submit" class="btn-default btn-azul" value="Guardar Cambios" />
        </div>
    </form>
</div>
{include=html/footer}
