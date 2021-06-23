{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li><a href="pagina">Páginas</a></li>
            <li><a href="pagina?accion=agregar">Agregar</a></li>
            <li><a href="pagina?accion=papelera">Papelera</a></li>
            <li class="active"><a href="pagina?accion=editar&id={entrada_id}">Editar</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form name="form_e_editar" action="?accion=editar&guardar&id={entrada_id}" method="post" class="mteditor container cont-750">
        <h1>Editar Página</h1>
        <div class="form-campos">
            <label for="titulo">Titulo:</label>
            <input type="text" value="{entrada_titulo}" name="titulo" id="titulo" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="url">Enlace Permanente:</label>
            <input type="text" value="{entrada_url}" name="url" id="url" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="contenido">Contenido:</label>
            <textarea name="contenido"  id="contenido" class="form-in" rows="10">{entrada_contenido}</textarea>
        </div>
        {*}<div class="form-campos">
            <label for="">Superior:</label>
            <select name="" id="" class="form-in">
                <option value="">Sin Superior</option>
            </select>
        </div>{/*}
        <div id="coverinput" class="form-campos">
            <label for="portada">Portada:</label>
            <input type="text" value="{entrada_portada}" name="portada" id="portada" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="descrip">Descripción:</label>
            <textarea name="descrip" id="descrip" class="form-in">{entrada_descrip}</textarea>
        </div>
		<div class="form-campos">
			<label for="plantilla">Plantilla:</label>
			<input type="text" value="{entrada_plantilla}" name="plantilla" id="plantilla" class="form-in" />
		</div>
		<div class="form-campos">
			<label for="estado">Estado:</label>
			<select name="estado" id="estado" class="form-in">
				{lista_estados}
				<option value="{id}" {selected}>{nombre}</option>
				{/lista_estados}
			</select>
		</div>
        <div class="form-campos">
            <button type="submit" id="" class="btn-default btn-azul btn-block">Actualizar Página</button>
        </div>
        <div id="lista_errores"></div>
    </form>
</div>
<script>cover_mostrar();</script>
<!--<script>llamar_ckeditor();</script>-->
{include=html/footer}
