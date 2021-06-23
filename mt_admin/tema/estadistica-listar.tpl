{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li><a href="sitio">Sitio</a></li>
            <li><a href="configuracion">Configuración</a></li>
            <li class="active"><a href="estadisticas">Estadisticas</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <div class="container art-row-cont cont-750">
        <h1>Estadisticas generales del sitio</h1>
        <div class="art-row">
            <div class="gd-50"><h4>Tipo</h4></div>
            <div class="gd-50"><h4>Total</h4></div>
        </div>
        <div class="art-row">
            <div class="gd-50"><strong>Entradas</strong></div>
            <div class="gd-50">{total_e}</div>
        </div>
        <div class="art-row">
            <div class="gd-50">Articulos</div>
            <div class="gd-50">{total_a}</div>
        </div>
        <div class="art-row">
            <div class="gd-50">Paginas</div>
            <div class="gd-50">{total_p}</div>
        </div>
		<div class="art-row">
            <div class="gd-50"><strong>Colecciones</strong></div>
            <div class="gd-50">{total_col}</div>
        </div>
        <div class="art-row">
            <div class="gd-50">Categorias</div>
            <div class="gd-50">{total_cat}</div>
        </div>
		<div class="art-row">
            <div class="gd-50">Tags</div>
            <div class="gd-50">{total_t}</div>
        </div>
        <div class="art-row">
            <div class="gd-50"><strong>Usuarios</strong></div>
            <div class="gd-50">{total_u}</div>
        </div>
        <div class="art-row">
            <div class="gd-50">Comentarios</div>
            <div class="gd-50">{total_c}</div>
        </div>
    </div>
</div>
{include=html/footer}
