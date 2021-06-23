{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
         <li><a href="sitio">Sitio</a></li>
         <li class="active"><a href="configuracion">Configuración</a></li>
         <li><a href="estadisticas">Estadisticas</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form method="post" action="?guardar" name="form_sc_editar" class="container cont-750">
        <h1>Configuración del sitio</h1>
        <h4>Configuración de Entradas</h4>
        <div class="form-campos">
            <label for="epp">Entradas por página:</label>
            <input type="text" name="epp" id="epp" class="form-in" value="{sitio_epp}" />
        </div>
        <div class="form-campos">
            <label for="comentarios">Publicación de Comentarios:</label>
            <select name="comentarios" id="comentarios" class="form-in">
				{lista_opciones_coment}
				<option value="{valor}" {selected}>{nombre}</option>
				{/lista_opciones_coment}
            </select>
        </div>
        <h4>Configuración de Usuarios</h4>
        <div class="form-campos">
            <label for="intentos">Numero de intentos de inicio de sesión fallidos:</label>
            <input type="text" name="intentos" id="intentos" class="form-in" value="{sitio_intentos}" />
        </div>
        <div class="form-campos">
            <label for="registro">Permitir Registro de Usuarios:</label>
			<input disabled="disabled" type="text" name="registro" id="registro" class="form-in" value="{sitio_registro}" />
        </div>
        <div class="form-campos">
            <label for="validaemail">Activar Usuarios por Email:</label>
			<input disabled="disabled" type="text" name="validaemail" id="validaemail" class="form-in" value="{sitio_validaemail}" />
        </div>
		<h4>Configuración del Tema</h4>
		<div class="form-campos">
            <label for="tema_nombre">Nombre del Tema:</label>
            <input type="text" name="tema_nombre" id="tema_nombre" class="form-in" value="{tema_nombre}" />
        </div>
		<div class="form-campos">
            <label for="tema_url">URL del Tema:</label>
            <input type="text" name="tema_url" id="tema_url" class="form-in" value="{tema_url}" />
        </div>
		<div class="form-campos">
            <label for="tema_ext">Extención de los archivos del tema:</label>
            <input type="text" name="tema_ext" id="tema_ext" class="form-in" value="{tema_ext}" />
        </div>
        <div class="form-campos">
            <input type="submit" class="btn-default btn-azul" value="Guardar Cambios" />
        </div>
    </form>
</div>
{include=html/footer}
