{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
          <li><a href="comentario">Comentarios</a></li>
          <li><a href="comentario?accion=spam">Spam</a></li>
          <li class="active"><a href="comentario?accion=papelera">Papelera</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <div class="container art-row-cont">
        <h1>Todos los comentarios</h1>
        <div class="art-row">
            <div class="gd-20"><h4>Autor</h4></div>
            <div class="gd-30"><h4>Contenido</h4></div>
            <div class="gd-20"><h4>Entrada</h4></div>
            <div class="gd-10"><h4>Fecha</h4></div>
            <div class="gd-20 tx-der"><h4>Accion</h4></div>
        </div>
        {lista_comentarios}
        <div class="art-row">
            <div class="gd-20">
              <span class="indicador-estado estado-{estado}"></span>
              {autor}
            </div>
            <div class="gd-30">{contenido}</div>
            <div class="gd-20">{titulo}</div>
            <div class="gd-10">{fecha}</div>
            <div class="gd-20 tx-der">
      				<a class="bta icon-eye" target="_blank" title="Ver Comentario" href="{url}"></a>
      				<a class="bta icon-pencil" title="Editar comentario" href="comentario?accion=editar&id={id}"></a>
      				<a class="bta icon-bin" title="Eliminar comentario permanentemente" href="comentario?accion=eliminar&permanente&id={id}"></a>
            </div>
        </div>
		{/lista_comentarios}
    </div>
    {*}<div class="container">
        <div class="gd-100">
            <a class="btn-azul-claro bx-izq" href="#">«</a>
            <a class="btn-azul-claro bx-der" href="#">»</a>
        </div>
    </div>{/*}
</div>
{include=html/footer}
