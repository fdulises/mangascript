{include=tpl/html/header}
    <div class="header-st1">
        <div class="container">
            <h1>{pagina_titulo}</h1>
        </div>
    </div>
	{si_articulos}
    <div id="cont-entradas">
		<div class="container">
			<ul class="lettertagcloud">
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=A">A</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=B">B</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=C">C</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=D">D</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=E">E</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=F">F</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=G">G</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=H">H</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=I">I</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=J">J</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=K">K</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=L">L</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=M">M</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=N">N</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=O">O</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=P">P</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=Q">Q</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=R">R</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=S">S</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=T">T</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=U">U</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=V">V</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=W">W</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=X">X</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=Y">Y</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=Z">Z</a></li>
				<li><a href="{SITIO_URL}/busqueda?filtro=l&b=0-9&fn">0-9</a></li>
			</ul>
		</div>
        <div class="container">
			<div id="principal10" class="container gd-66 gd-m-100">
				{lista_articulos}
	            <article class="gd-33 gd-b-50 gd-m-100 card-entrada">
	                <a href="{articulo_enlace}">
	                <div class="card-cont">
	                    <img class="card-cover" data-original="{SITIO_URL}/miniatura?h=600&w=400&q=100&src={articulo_portada}"  alt="{articulo_titulo}" title="{articulo_titulo}" />
	                	<div class="card-info">
	                        <h3>{{articulo_titulo}|truncate|30}</h3>
	                        <p>{{articulo_descrip}|truncate|150}</p>
	                    </div>
	                    <div class="card-datos">
	                        <span class="card-date">
	                            <span class="icon-calendar"></span>
								{tiempoformato|d/m/Y|{articulo_fecha}}
	                        </span>
	                        <span class="card-coment">
	                            <span class="icon-bubble"></span> {articulo_comentarios}
	                        </span>
	                    </div>
	                </div>
	                </a>
	            </article>
				{/lista_articulos}
			</div>
			<div id="side20" class="gd-33 gd-m-100">
				{lista_20ent}
				<article class="card-entrada card-imgsimple">
					<a href="{articulo_enlace}">
					<div class="card-cont">
						<img class="card-cover" data-original="{SITIO_URL}/miniatura?h=130&w=400&q=100&src={articulo_portada}"  alt="{articulo_titulo}" title="{articulo_titulo}" />
						<div class="card-info">
							<h3>{{articulo_titulo}|truncate|46}</h3>
						</div>
					</div>
					</a>
				</article>
				{/lista_20ent}
			</div>
		</div>
		<div id="rel8" class="container">
			{lista_articulos_1}
            <article class="gd-25 gd-m-100 card-entrada card-imgsimple">
                <a href="{articulo_enlace}">
                <div class="card-cont">
                    <img class="card-cover" data-original="{SITIO_URL}/miniatura?h=200&w=400&q=100&src={articulo_portada}"  alt="{articulo_titulo}" title="{articulo_titulo}" />
                	<div class="card-info">
                        <h3>{{articulo_titulo}|truncate|46}</h3>
                    </div>
                </div>
                </a>
            </article>
			{/lista_articulos_1}
			{lista_articulos_2}
			<article class="gd-25 gd-m-100 card-entrada card-imgsimple">
				<a href="{articulo_enlace}">
					<div class="card-cont">
						<img class="card-cover" data-original="{SITIO_URL}/miniatura?h=200&w=400&q=100&src={articulo_portada}"  alt="{articulo_titulo}" title="{articulo_titulo}" />
						<div class="card-info">
							<h3>{{articulo_titulo}|truncate|46}</h3>
						</div>
					</div>
				</a>
			</article>
			{/lista_articulos_2}
		</div>
    </div>
	{/si_articulos}
	{si_paginacion}
    <div class="container tx-center paginacion-sta">
		{is_paginacion_a}
        <a href="{paginacion_enlace_a}"><span class="icon-circle-left"></span> Anterior</a>
		{/is_paginacion_a}
		{is_paginacion_s}
        <a href="{paginacion_enlace_s}">Siguiente <span class="icon-circle-right"></span></a>
		{/is_paginacion_s}
    </div>
	{/si_paginacion}
{include=tpl/html/footer}
