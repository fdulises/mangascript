{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
			<li><a id="mangacap_col" href="manga?accion=vercap&id={entrada_id}">Capitulos</a></li>
            <li class="active"><a href="manga?accion=adcap&id={entrada_id}">Agregar</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form data-mangaid="{entrada_id}" name="form_ma_agregar" action="?accion=adcap&guardar&id={entrada_id}" method="post" class="container cont-750">
        <h1>Agregar Capitulo de Manga</h1>
        <div class="form-campos">
            <label for="titulo">Titulo:</label>
            <input type="text" name="titulo" id="titulo" placeholder="Un titulo para el capitulo, ej. 'Capitulo 21'" class="form-in" />
        </div>
		<div class="form-campos">
            <label for="idcapitulo">Id Capitulo:</label>
            <input type="text" name="idcapitulo" id="idcapitulo" placeholder="Número de capitulo (Sirver para ordenar los capitulos), ej. '21'" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="pageimg">Páginas:</label>
			<input type="hidden" name="allimgpags" id="allimgpags" />
            <button id="adimgpag" type="button" class="bta icon-plus" title="Agregar campo para página"></button>
			<div id="imgpaginas"></div>
        </div>
        <div class="form-campos">
            <p><button type="submit" id="" class="btn-default btn-azul btn-block">Agregar Capitulo</button></p>
        </div>
		<h3>Importador de capitulos</h3>
		<div class="form-campos">
			<label for="importar">Importar Contenido:</label>
			<select name="importar" id="importar" class="form-in">
				<option value="">Seleccionar</option>
				<option value="1">Ninemanga</option>
				<option value="2">Tumangaonline</option>
			</select>
		</div>
		<div class="form-campos">
			<div class="gd-50">
				<label for="mangaid">Ingresar ID:</label>
				<input type="text" name="mangaid" id="mangaid" class="form-in" />
			</div>
			{*}
			<div class="gd-50">
				<label for="mangacapnum">Número de capitulo a importar:</label>
				<input type="text" placeholder="Vacio significa todos" name="mangacapnum" id="mangacapnum" class="form-in" />
			</div>
			{/*}
			<div class="gd-50">
				<button id="submit_mimport" type="button" class="btn-default btn-block">Importar</button>
			</div>
		</div>
        <div id="lista_errores"></div>
    </form>
</div>
{include=html/footer}
