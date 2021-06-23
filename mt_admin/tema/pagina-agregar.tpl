{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li><a href="pagina">Páginas</a></li>
            <li class="active"><a href="pagina?accion=agregar">Agregar</a></li>
            <li><a href="pagina?accion=papelera">Papelera</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form name="form_e_agregar" action="?accion=agregar&guardar" method="post" class="mteditor container cont-750">
        <h1>Agregar Nueva Página</h1>
        <div class="form-campos">
            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo" id="titulo" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="url">Enlace Permanente:</label>
            <input type="text" name="url" id="url" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="contenido">Contenido:</label>
            <textarea name="contenido" id="contenido" class="form-in" rows="10"></textarea>
        </div>
        {*}<div class="form-campos">
            <label for="">Superior:</label>
            <select name="" id="" class="form-in">
                <option value="">Sin Superior</option>
            </select>
        </div>{/*}
        <div id="coverinput" class="form-campos">
            <label for="portada">Portada:</label>
            <input type="text" name="portada" id="portada" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="descrip">Descripción:</label>
            <textarea name="descrip" id="descrip" class="form-in"></textarea>
        </div>
		<div class="form-campos">
			<label for="plantilla">Plantilla:</label>
			<input type="text" placeholder="Plantilla por defecto 'pagina'" name="plantilla" id="plantilla" class="form-in" />
		</div>
		<div class="form-campos">
			<label for="estado">Estado:</label>
			<select name="estado" id="estado" class="form-in">
				{lista_estados}<option value="{id}">{nombre}</option>{/lista_estados}
			</select>
		</div>
        <div class="form-campos">
            <button type="submit" id="" class="btn-default btn-azul btn-block">Guardar Página</button>
        </div>
        <div id="lista_errores"></div>
    </form>
</div>
<script>cover_mostrar();</script>
<!--<script>llamar_ckeditor();</script>-->
{include=html/footer}
