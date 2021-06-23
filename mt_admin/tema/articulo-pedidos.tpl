{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li><a href="manga">Mangas</a></li>
            <li><a href="manga?accion=agregar">Agregar</a></li>
            <li><a href="manga?accion=papelera">Papelera</a></li>
			<li class="active"><a href="manga?accion=pedidos">Pedidos</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <div class="container cont-960 art-row-cont">
        <h1>Lista de Mangas Pedidos</h1>
        <div class="art-row">
			<div class="gd-10"><h4>Id</h4></div>
            <div class="gd-50"><h4>Titulo</h4></div>
            <div class="gd-20"><h4>Fecha</h4></div>
            <div class="gd-20 tx-der"><h4>Acciones</h4></div>
        </div>
        {lista_entradas}
        <div class="art-row">
			<div class="gd-10">{entrada_id}</div>
            <div class="gd-50">
				<span class="indicador-estado estado-{entrada_estado}"></span>
				{entrada_titulo}
			</div>
            <div class="gd-20">{entrada_fecha}</div>
            <div class="gd-20 tx-der">
				{entrada_switch}
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
<script>
	var switches = document.querySelectorAll('.pedidos_switch');
	var switlength = switches.length;
	for(i=0; i<switlength; i++){
		switches[i].addEventListener("change", function(){
			var rutaenvio = window.location;
			rutaenvio += '&id='+this.getAttribute("data-id")+'&estado='+this.value;
			getAjax(rutaenvio, function(){});
		});
	}
</script>
{include=html/footer}
