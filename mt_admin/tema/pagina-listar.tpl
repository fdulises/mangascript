{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li class="active"><a href="pagina">Paginas</a></li>
            <li><a href="pagina?accion=agregar">Agregar</a></li>
            <li><a href="pagina?accion=papelera">Papelera</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <div class="container art-row-cont">
        <h1>Todas las paginas</h1>
        <div class="art-row">
            <div class="gd-50"><h4>Titulo</h4></div>
            <div class="gd-20"><h4>Autor</h4></div>
            <div class="gd-10"><h4>Fecha</h4></div>
            <div class="gd-20 tx-der"><h4>Acciones</h4></div>
        </div>
        {lista_paginas}
        <div class="art-row">
            <div class="gd-50">
				<span class="indicador-estado estado-{pagina_estado}"></span>
				<a target="_blank" href="{pagina_enlace}">{pagina_titulo}</a>
			</div>
            <div class="gd-20">@{pagina_usuario}</div>
            <div class="gd-10">{pagina_fecha}</div>
            <div class="gd-20 tx-der">
				<a class="bta icon-eye" target="_blank" title="Ver Página" href="pagina?accion=ver&id={pagina_id}"></a>
				<a class="bta icon-pencil" title="Editar Página" href="pagina?accion=editar&id={pagina_id}"></a>
				<a class="bta icon-cross" title="Eliminar Página" href="pagina?accion=eliminar&id={pagina_id}"></a>
			</div>
        </div>
        {/lista_paginas}
    </div>
    {*}<div class="container">
        <div class="gd-100">
            <a class="btn-azul-claro bx-izq" href="#">«</a>
            <a class="btn-azul-claro bx-der" href="#">»</a>
        </div>
    </div>{/*}
</div>
{include=html/footer}
