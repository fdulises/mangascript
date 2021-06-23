{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li><a href="categoria">Categorias</a></li>
            <li class="active"><a href="categoria?accion=agregar">Agregar</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form name="form_c_agregar" method="post" action="categoria?accion=agregar&guardar" class="container cont-750">
        <h1>Agregar Nueva Categoría</h1>
        <div class="form-campos">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="url">URL:</label>
            <input type="text" name="url" id="url" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="descrip">Descripción:</label>
            <textarea name="descrip" id="descrip" class="form-in"></textarea>
        </div>
        {*}<div class="form-campos">
            <label for="">Superior:</label>
            <select name="" id="" class="form-in">
                <option value="">Sin Superior</option>
            </select>
        </div>{/*}
        <div class="form-campos">
            <button type="submit" class="btn-default btn-azul btn-block">Añadir nueva Categoría</button>
        </div>
    </form>
</div>
{include=html/footer}
