{include=tpl/html/header}
    <div class="header-st1">
        <div class="container">
            <h1>{pagina_titulo}</h1>
        </div>
    </div>
	<div class="container cont-960">
		<div class="cont-white clearfix">
			<img id="manga_cover" class="bx-left" src="{manga_cover}" />
			<p>{manga_descrip}</p>
			<p>{manga_generos}</p>
			<p><a href="{pagina_enlace_manga}" class="button-default">Lista de capitulos</a></p>
		</div>
	</div>
	<div class="container cont-960 art-row-cont">
		<div class="cont-white clearfix">
			<div class="container art-row-cont">
		        <div class="art-row">
		            <div class="gd-100"><h3>Lista de capitulos</h3></div>
		        </div>
				{lista_capitulos}
		        <div class="art-row">
		            <div class="gd-100">
						<a href="{enlace}"><span class="indicador-estado estado-1"></span> {title}</a>
					</div>
		        </div>
				{/lista_capitulos}
		    </div>
		</div>
	</div>
{include=tpl/html/footer}
