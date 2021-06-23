{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li><a href="manga">Mangas</a></li>
            <li class="active"><a href="manga?accion=agregar">Agregar</a></li>
            <li><a href="manga?accion=papelera">Papelera</a></li>
            <li><a href="manga?accion=pedidos">Pedidos</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form name="form_a_agregar" action="?accion=agregar&guardar" method="post" class="mteditor container cont-750">
        <h1>Agregar Nuevo Manga</h1>
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
        <div class="form-campos">
            <label for="tags">Generos:</label>
            <input type="text" name="tags" id="tags" class="form-in" />
        </div>
		<div class="form-campos">
            <label for="categoria">Colección:</label>
            <select name="categoria" id="categoria" class="form-in">
                <option value="0">Sin colección</option>
				{lista_categorias}
				<option value="{id}">{nombre}</option>
				{/lista_categorias}
            </select>
        </div>
        <div id="coverinput" class="form-campos">
            <label for="portada">Portada:</label>
            <input type="text" name="portada" id="portada" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="descrip">Descripción:</label>
            <textarea name="descrip" id="descrip" class="form-in"></textarea>
        </div>
		<div class="form-campos">
			<label for="estado">Estado:</label>
			<select name="estado" id="estado" class="form-in">
				{lista_estados}<option value="{id}">{nombre}</option>{/lista_estados}
			</select>
		</div>
		<div class="form-campos">
			<label for="importar">Importar Contenido:</label>
			<select name="importar" id="importar" class="form-in">
				<option value="">Seleccionar</option>
				<option value="1">Ninemanga</option>
				<option value="2">Tumangaonline</option>
			</select>
		</div>
		<div class="form-campos">
            <div class="gd-50">
				<label for="mangaid">Ingresar ID:</label>
				<input type="text" name="mangaid" id="mangaid" class="form-in" />
			</div>
            <div class="gd-50">
				<button id="submit_mimport" type="button" class="btn-default btn-block">Importar</button>
			</div>
        </div>
        <div class="form-campos">
            <button type="submit" id="" class="btn-default btn-azul btn-block">Publicar Artículo</button>
        </div>
        <div id="lista_errores"></div>
    </form>
</div>
<script>cover_mostrar();</script>
<!--<script>llamar_ckeditor();</script>-->
{include=html/footer}
