{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li class="active"><a href="manga">Mangas</a></li>
            <li><a href="manga?accion=agregar">Agregar</a></li>
            <li><a href="manga?accion=papelera">Papelera</a></li>
			<li><a href="manga?accion=pedidos">Pedidos</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
	<div class="container">
		<div class="gd-50">
			<h1>Todos los mangas</h1>
		</div>
		<form method="get" action="" class="gd-50">
			<input type="text" name="b" class="form-in" placeholder="Buscar..." />
			{*}<button class="gd-30" type="submit">Busqueda</button>{/*}
		</form>
	</div>
    <div class="container art-row-cont">
        <div class="art-row">
            <div class="gd-10"><h4>Id</h4></div>
            <div class="gd-20"><h4>Titulo</h4></div>
            <div class="gd-20"><h4>Comentarios</h4></div>
            <div class="gd-10"><h4>Fecha</h4></div>
            <div class="gd-10"><h4>Capitulos</h4></div>
            <div class="gd-30 tx-der"><h4>Acciones</h4></div>
        </div>
        {lista_articulos}
        <div class="art-row">
            <div class="gd-10">{articulo_id}</div>
            <div class="gd-20">
				<span class="indicador-estado estado-{articulo_estado}"></span>
				<a target="_blank" href="{articulo_enlace}">{articulo_titulo}</a>
			</div>
            <div class="gd-20">{articulo_total_c}</div>
            <div class="gd-10">{articulo_fecha}</div>
			<div class="gd-10">{articulo_capitulos} </div>
			<div class="gd-30 tx-der">
				<a class="bta icon-file-text2" title="Ver lista de Capitulos" href="manga?accion=vercap&id={articulo_id}"></a>
				<a class="bta icon-plus" title="Agregar Capitulo" href="manga?accion=adcap&id={articulo_id}"></a>
				<a class="bta icon-eye" target="_blank" title="Ver Página" href="manga?accion=ver&id={articulo_id}"></a>
				<a class="bta icon-pencil" title="Editar articulo" href="manga?accion=editar&id={articulo_id}"></a>
				<a class="bta icon-cross" title="Eliminar articulo" href="manga?accion=eliminar&id={articulo_id}"></a>
			</div>
        </div>
        {/lista_articulos}
    </div>
    <div class="container">
        <div class="gd-100">
			{bloque_enlace_a}
            <a class="btn-azul-claro bx-izq" href="{enlace_pag_a}">«</a>
			{/bloque_enlace_a}
			{bloque_enlace_s}
            <a class="btn-azul-claro bx-der" href="{enlace_pag_s}">»</a>
			{/bloque_enlace_s}
        </div>
    </div>
</div>
{include=html/footer}
