{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
          <li><a href="usuario">Usuarios</a></li>
          <li class="active"><a href="usuario?accion=agregar">Agregar</a></li>
          <li><a href="grupo">Grupos</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form method="post" action="?accion=agregar&guardar" class="container cont-750" name="form_u_agregar">
        <h1>Agregar Nuevo Usuario</h1>
        <div class="form-campos">
            <label for="nickname">Nombre de usuario:</label>
            <input type="text" name="nickname" id="nickname" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="email">Correo Electrónico:</label>
            <input type="text" name="email" id="email" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="descrip">Descripción:</label>
            <textarea name="descrip" id="descrip" class="form-in"></textarea>
        </div>
        <div class="form-campos">
            <label for="sitio">Sitio Web:</label>
            <input type="text" name="sitio" id="sitio" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="grupo">Grupo:</label>
            <select name="grupo" id="grupo" class="form-in">
                <option value="4">Miembro</option>
                <option value="3">Redactor</option>
                <option value="2">Colaborador</option>
                <option value="1">Administrador</option>
            </select>
        </div>
        <div class="form-campos">
            <button class="btn-default btn-azul" type="submit">Añadir nuevo usuario</buton>
        </div>
        <div id="lista_errores"></div>
    </form>
</div>
{include=html/footer}
