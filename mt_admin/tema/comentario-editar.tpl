{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
        <li><a href="comentario">Comentarios</a></li>
        <li><a href="comentario?accion=spam">Spam</a></li>
        <li><a href="comentario?accion=papelera">Papelera</a></li>
			<li class="active"><a href="comentario?accion=editar&id={id}">Editar</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form name="form_coment_editar" action="?accion=editar&guardar&id={id}" method="post" class="mteditor container cont-750">
        <h1>Editar Comentario</h1>
        <div class="form-campos">
            <label for="autor">Autor:</label>
            <input  value="{autor}" type="text" name="autor" id="autor" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="contenido">Contenido:</label>
            <textarea name="contenido" id="contenido" class="form-in" rows="10">{contenido}</textarea>
        </div>
    		<div class="form-campos">
    			<label for="estado">Estado:</label>
    			<select name="estado" id="estado" class="form-in">
    				{lista_estados}<option value="{id}" {selected}>{nombre}</option>{/lista_estados}
    			</select>
    		</div>
        <div class="form-campos">
            <button type="submit" id="" class="btn-default btn-azul btn-block">Actualizar Comentario</button>
        </div>
        <div id="lista_errores"></div>
    </form>
</div>
{include=html/footer}
