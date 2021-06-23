{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li><a href="manga">Mangas</a></li>
            <li><a href="manga?accion=agregar">Agregar</a></li>
            <li class="active"><a href="manga?accion=papelera">Papelera</a></li>
			<li><a href="manga?accion=pedidos">Pedidos</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <div class="container art-row-cont">
        <h1>Papelera - Todos los mangas</h1>
        <div class="art-row">
            <div class="gd-50"><h4>Titulo</h4></div>
            <div class="gd-20"><h4>Autor</h4></div>
            <div class="gd-10"><h4>Fecha</h4></div>
            <div class="gd-20 tx-der"><h4>Acciones</h4></div>
        </div>
        {lista_entradas}
        <div class="art-row">
            <div class="gd-50">
				<span class="indicador-estado estado-{entrada_estado}"></span>
				<a target="_blank" title="Ver Página" href="manga?accion=ver&id={entrada_id}">{entrada_titulo}</a>
			</div>
            <div class="gd-20">@{entrada_usuario}</div>
            <div class="gd-10">{entrada_fecha}</div>
            <div class="gd-20 tx-der">
				<a target="_blank" class="bta icon-eye" title="Ver Entrada" href="manga?accion=ver&id={entrada_id}"></a>
				<a class="bta icon-pencil" title="Editar Entrada" href="manga?accion=editar&id={entrada_id}"></a>
				<a class="bta icon-bin" title="Eliminar Entrada de Forma Permanente" href="manga?accion=eliminar&permanente&id={entrada_id}"></a>
			</div>
        </div>
        {/lista_entradas}
    </div>
    {*}<div class="container">
        <div class="gd-100">
            <a class="btn-azul-claro bx-izq" href="#">«</a>
            <a class="btn-azul-claro bx-der" href="#">»</a>
        </div>
    </div>{/*}
</div>
{include=html/footer}
