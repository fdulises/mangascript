{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li><a href="pagina">Paginas</a></li>
            <li><a href="pagina?accion=agregar">Agregar</a></li>
            <li class="active"><a href="pagina?accion=papelera">Papelera</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <div class="container art-row-cont">
        <h1>Papelera - Todas las paginas</h1>
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
				{pagina_titulo}
			</div>
            <div class="gd-20"><a href="">@{pagina_usuario}</a></div>
            <div class="gd-10">{pagina_fecha}</div>
            <div class="gd-20 tx-der">
				<a class="bta icon-eye" target="_blank" title="Ver Página" href="pagina?accion=ver&id={pagina_id}"></a>
				<a class="bta icon-pencil" title="Editar Página" href="pagina?accion=editar&id={pagina_id}"></a>
				<a class="bta icon-bin" title="Eliminar Página de Forma Permanente" href="pagina?accion=eliminar&permanente&id={pagina_id}"></a>
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
