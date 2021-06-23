{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li class="active"><a href="usuario">Usuarios</a></li>
            <li><a href="usuario?accion=agregar">Agregar</a></li>
            <li><a href="grupo">Grupos</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <div class="container art-row-cont">
        <h1>Todos los usuarios</h1>
        <div class="art-row">
            <div class="gd-20"><h4>Nombre de Usuario</h4></div>
            <div class="gd-20"><h4>Nombre</h4></div>
            <div class="gd-20"><h4>Correo Electrónico</h4></div>
            <div class="gd-10"><h4>Grupo</h4></div>
            <div class="gd-10"><h4>Entradas</h4></div>
            <div class="gd-10"><h4>Registro</h4></div>
            <div class="gd-10"><h4>Acciones</h4></div>
        </div>
        {lista_usuarios}
        <div class="art-row">
            <div class="gd-20"><a href=""><img class="img-avatar-min" src="{usuario_gravatar}" /> @{usuario_nickname}</a></div>
            <div class="gd-20">{usuario_nombre}</div>
            <div class="gd-20">{usuario_email}</div>
            <div class="gd-10">{usuario_grupo}</div>
            <div class="gd-10">{usuario_total_e}</div>
            <div class="gd-10">{usuario_fregistro}</div>
            <div class="gd-10">
              <a data-eliminar="{usuario_id}" href="usuario?accion=eliminar&id={usuario_id}" title="Eliminar Usuario" class="bta icon-user-minus"></a>
              <a href="usuario?accion=editar&id={usuario_id}" title="Editar Usuario" class="bta icon-user-check"></a>
            </div>
        </div>
        {/lista_usuarios}
    </div>
    {*}<div class="container">
        <div class="gd-100">
            <a class="btn-azul-claro bx-izq" href="#">«</a>
            <a class="btn-azul-claro bx-der" href="#">»</a>
        </div>
    </div>{/*}
</div>
{include=html/footer}
