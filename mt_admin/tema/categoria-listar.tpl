{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li class="active"><a href="categoria">Categorías</a></li>
            <li><a href="categoria?accion=agregar">Agregar</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <div class="container cont-750 art-row-cont">
        <h1>Todas las Categorías</h1>
        <div class="art-row">
            <div class="gd-30"><h4>Nombre</h4></div>
            <div class="gd-40"><h4>Descripción</h4></div>
            <div class="gd-10"><h4>Articulos</h4></div>
            <div class="gd-20 tx-der"><h4>Acciones</h4></div>
        </div>
		{lista_categorias}
        <div class="art-row">
            <div class="gd-30"><a href="{categoria_url}">{categoria_nombre}</a></div>
            <div class="gd-40">{categoria_descrip}</div>
            <div class="gd-10">{categoria_total_e}</div>
            <div class="gd-20 tx-der">
				<a href="categoria?accion=editar&id={categoria_id}" title="Editar Categoria" class="bta icon-pencil"></a>
				<a href="categoria?accion=eliminar&id={categoria_id}" title="Eliminar Categoría" class="bta icon-cross"></a>
			</div>
        </div>
		{/lista_categorias}
    </div>
    {*}<div class="container cont-750">
        <div class="gd-100">
            <a class="btn-azul-claro bx-izq" href="#">«</a>
            <a class="btn-azul-claro bx-der" href="#">»</a>
        </div>
    </div>{/*}
</div>
{include=html/footer}
