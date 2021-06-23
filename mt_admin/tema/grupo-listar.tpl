{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
          <li><a href="usuario">Usuarios</a></li>
          <li><a href="usuario?accion=agregar">Agregar</a></li>
          <li class="active"><a href="grupo">Grupos</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <div class="container art-row-cont cont-750">
        <h1>Todos los Grupos de Usuarios</h1>
        <div class="art-row">
            <div class="gd-10"><h4>Id</h4></div>
            <div class="gd-20"><h4>Nombre</h4></div>
            <div class="gd-50"><h4>Descripción</h4></div>
            <div class="gd-20"><h4>Usuarios</h4></div>
        </div>
        <div class="art-row">
            <div class="gd-10">1</div>
            <div class="gd-20">Administrador</div>
            <div class="gd-50">Los Administradores tienen acceso a todas las funciones de administración.</div>
            <div class="gd-20">--</div>
        </div>
        <div class="art-row">
            <div class="gd-10">2</div>
            <div class="gd-20">Colaborador</div>
            <div class="gd-50">Los colaboradores tienen acceso a todas la funciones de entradas.</div>
            <div class="gd-20">--</div>
        </div>
        <div class="art-row">
            <div class="gd-10">3</div>
            <div class="gd-20">Redactor</div>
            <div class="gd-50">Los redactores tienen permisos básicos sobre entradas.</div>
            <div class="gd-20">--</div>
        </div>
        <div class="art-row">
            <div class="gd-10">4</div>
            <div class="gd-20">Miembro</div>
            <div class="gd-50">Los miembros tienen permisos básicos</div>
            <div class="gd-20">--</div>
        </div>
    </div>
</div>
{include=html/footer}
