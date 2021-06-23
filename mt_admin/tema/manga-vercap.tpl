{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li class="active"><a href="manga?accion=vercap&id={id_cap}">Capitulos</a></li>
            <li><a href="manga?accion=adcap&id={id_cap}">Agregar</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <div class="container art-row-cont">
        <h1>Todos los capitulos</h1>
        <div class="art-row">
            <div class="gd-20"><h4>Id</h4></div>
            <div class="gd-30"><h4>Titulo</h4></div>
            <div class="gd-20"><h4>Fecha</h4></div>
            <div class="gd-30 tx-der"><h4>Acciones</h4></div>
        </div>
        {lista_articulos}
        <div class="art-row">
            <div class="gd-20">{articulo_descrip}</div>
            <div class="gd-30">{articulo_titulo}</div>
            <div class="gd-20">{articulo_fecha}</div>
			<div class="gd-30 tx-der">
				<a class="bta icon-pencil" title="Editar capitulo" href="manga?accion=editcap&id={articulo_id}"></a>
				<a class="bta icon-cross" title="Eliminar capitulo" href="manga?accion=delcap&id={articulo_id}"></a>
			</div>
        </div>
        {/lista_articulos}
    </div>
    {*}<div class="container">
        <div class="gd-100">
            <a class="btn-azul-claro bx-izq" href="#">«</a>
            <a class="btn-azul-claro bx-der" href="#">»</a>
        </div>
    </div>{/*}
</div>
{include=html/footer}