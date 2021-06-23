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
	<div class="container cont-960">
		<div class="cont-white clearfix">
			<div class="tx-center">
				<h3>{manga_pagina_title}</h3>
				<img src="{manga_pagina}" />
			</div>
			{si_paginacion}
		    <div class="container tx-center paginacion-sta">
				{is_paginacion_a}
		        <a href="{manga_pagina_anterior}"><span class="icon-circle-left"></span> Anterior</a>
				{/is_paginacion_a}
				{is_paginacion_s}
		        <a href="{manga_pagina_siguiente}">Siguiente <span class="icon-circle-right"></span></a>
				{/is_paginacion_s}
		    </div>
			{/si_paginacion}
		</div>
	</div>
{include=tpl/html/footer}
