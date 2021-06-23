{include=tpl/html/header}
    <div class="header-st1">
        <div class="container">
            <h1>{articulo_titulo}</h1>
            <div class="entrada-info">
                <span class="info-usuario"><span class="icon-user"></span> {articulo_autor}</span> &#8226;
                <span class="info-fecha"><span class="icon-calendar"></span> {tiempoformato|d/m/Y|{articulo_fecha}}</span> &#8226;
                <span class="info-cat"><span class="icon-folder"></span> {articulo_coleccion_nombre}</span> &#8226;
                <span class="info-cat"><span class="icon-bubble"></span> {articulo_comentarios}</span>
            </div>
        </div>
    </div>
    <article class="container">
        <div class="gd-70 gd-b-100 entrada-container">
            <div class="cont-white clearfix">
				<img id="manga_cover" class="bx-left" src="{SITIO_URL}/miniatura?h=320&w=220&q=100&src={articulo_cover}" alt="Portada de entrada" title="{articulo_titulo}" />
				<p>{articulo_contenido}</p>
				<p>
					{lista_generos}
					<a class="manga_cat" href="{SITIO_URL}/busqueda?b={nombre}">{nombre}</a>
					{/lista_generos}
				</p>
			</div>
			<div class="cont-white clearfix">
				<div class="container art-row-cont">
			        <div class="art-row">
			            <div class="gd-100"><h3>Lista de capitulos</h3></div>
			        </div>
					{lista_capitulos}
			        <div class="art-row">
			            <div class="gd-100">
							<a data-cap="{mangacap_apiruta}" href="{enlace}"><span class="indicador-estado estado-1"></span> {mangacap_descrip} -  {mangacap_titulo}</a>
						</div>
			        </div>
					{/lista_capitulos}
			    </div>
			</div>
			<div class="container">
				<br>
				{si_comentarios}
				<h2>Comentarios</h2>
				<ol id="entrada-coment">
					{lista_comentarios}
					<li class="cont-white" id="coment_{comentario_id}">
						<img class="avatar" src="{comentario_avatar}" />
						<div class="datos">
							 <span class="autor">{comentario_enlace}</span> - <span class="fecha">
								 {tiempoformato|d/m/Y|{comentario_fecha}} a las {tiempoformato|H:i|{comentario_fecha}}
							 </span>
						</div>
						<div class="contenido">
							<p>{comentario_contenido}</p>
						</div>
					</li>
					{/lista_comentarios}
				</ol>
				{/si_comentarios}
				<form class="cont-white" id="comentform" method="post" action="?comentar">
					<h3>Publicar un comentario</h3>
					<div class="form-campo">
						<label for="autor">Nombre:</label>
						<input type="" name="autor" id="autor" class="form-in" />
					</div>
					<div class="form-campo">
						<label for="email">Email:</label>
						<input type="" name="email" id="email" class="form-in" />
					</div>
					<div class="form-campo" style="display:none">
						<label for="sitio">Sitio Web:</label>
						<input type="" name="sitio" id="sitio" class="form-in" />
					</div>
					<div class="form-campo">
						<label for="contenido">Comentario:</label>
						<textarea name="contenido" id="contenido" class="form-in" rows="6"></textarea>
					</div>
					<div class="form-campo">
						<div class="g-recaptcha" data-sitekey="{SITIO_RECAPTCHA}"></div>
					</div>
					<button type="submit" class="button-default">Comentar</button>
				</form>
			</div>
		</div>
        <aside class="entrada-aside gd-30 gd-b-100">
			{lista_relacionados}
            <div class="gd-100 gd-b-50 gd-s-100">
                <a href="{entrada_enlace}" title="{entrada_titulo}" class="card-related">
                    <img alt="{entrada_titulo}" title="{entrada_titulo}" src="{SITIO_URL}/miniatura?h=200&w=400&q=100&src={entrada_portada}" />
                    <h4>{entrada_titulo}</h4>
                </a>
            </div>
			{/lista_relacionados}
        </aside>
    </article>
{include=tpl/html/footer}
