{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
          <li><a href="usuario">Usuarios</a></li>
          <li><a href="usuario?accion=agregar">Agregar</a></li>
          <li><a href="grupo">Grupos</a></li>
          <li class="active"><a href="usuario?accion=editar">Editar</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form method="post" action="?accion=editar&guardar&id={usuario_id}" class="container cont-750" name="form_u_editar">
        <h1>Editar Usuario @{usuario_nickname}</h1>
        <div class="form-campos">
            <label for="nickname">Nombre de usuario:</label>
            <input type="text" value="{usuario_nickname}" name="nickname" id="nickname" class="form-in" disabled="disabled" />
        </div>
        <div class="form-campos">
            <label for="email">Correo Electrónico:</label>
            <input type="text" name="email" value="{usuario_email}" id="email" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="nombre">Nombre:</label>
            <input type="text" value="{usuario_nombre}" name="nombre" id="nombre" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="descrip">Descripción:</label>
            <textarea name="descrip" id="descrip" class="form-in">{usuario_descrip}</textarea>
        </div>
        <div class="form-campos">
            <label for="sitio">Sitio Web:</label>
            <input value="{usuario_sitio}" type="text" name="sitio" id="sitio" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="grupo">Grupo:</label>
            <select name="grupo" id="grupo" class="form-in">
				{lista_grupos}
				<option value="{id}" {selected}>{nombre}</option>
				{/lista_grupos}
            </select>
        </div>
        <div class="form-campos">
            <label for="clave">Cambiar Contraseña:</label>
            <input type="password" name="clave" id="clave" class="form-in" placeholder="Ingrese nueva contraseña" />
        </div>
        <div class="form-campos">
            <button class="btn-default btn-azul" type="submit">Guardar Cambios</buton>
        </div>
        <div id="lista_errores"></div>
    </form>
</div>
{include=html/footer}
