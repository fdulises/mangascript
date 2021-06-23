{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
			<li><a href="manga">Manga</a></li>
            <li><a href="manga?accion=agregar">Agregar</a></li>
            <li><a href="manga?accion=papelera">Papelera</a></li>
            <li class="active"><a href="manga?accion=editcap&id={entrada_id}">Editar</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form data-mangaid="{entrada_id}" name="form_ma_editar" action="?accion=editcap&id={entrada_id}&coleccion={entrada_coleccion}&guardar" method="post" class="container cont-750">
        <h1>Editar Capitulo de Manga</h1>
        <div class="form-campos">
            <label for="titulo">Titulo:</label>
            <input type="text" value="{entrada_titulo}" name="titulo" id="titulo" placeholder="Un titulo para el capitulo, ej. 'Capitulo 21'" class="form-in" />
        </div>
		<div class="form-campos">
            <label for="idcapitulo">Id Capitulo:</label>
            <input type="text" value="{entrada_descrip}" name="idcapitulo" id="idcapitulo" placeholder="Número de capitulo (Sirver para ordenar los capitulos), ej. '21'" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="pageimg">Páginas:</label>
			<input type="hidden" name="allimgpags" id="allimgpags" />
            <button id="adimgpag" type="button" class="bta icon-plus" title="Agregar campo para página"></button>
			<div id="imgpaginas">
				{lista_manga_paginas}
				<div>
					<div class="gd-10">
						<button class="bta icon-upload2" title="Subir imágen" type="button" id="btnupload_2436"></button>
					</div>
					<div class="gd-90">
						<input value="{imgurl}" class="form-in imgpagcampo" placeholder="Dirección de la imagen" id="inpupload_2436">
					</div>
				</div>
				{/lista_manga_paginas}
			</div>
        </div>

        <div class="form-campos">
            <p><button type="submit" id="" class="btn-default btn-azul btn-block">Actualizar Capitulo</button></p>
        </div>
        <div id="lista_errores"></div>
    </form>
</div>
{include=html/footer}
