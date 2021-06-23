{include=html/header}
<div class="bg-gris">
    <div class="container cont-750">
        <ul class="nav-hor nav-sec">
            <li><a href="etiqueta-listar.html">Etiquetas</a></li>
            <li class="active"><a href="etiqueta-agregar.html">Agregar</a></li>
        </ul>
    </div>
</div>
<div class="cont-st1">
    <form class="container cont-750">
        <h1>Agregar Nueva Etiqueta</h1>
        <div class="form-campos">
            <label for="">Nombre:</label>
            <input type="text" name="" id="" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="">URL:</label>
            <input type="text" name="" id="" class="form-in" />
        </div>
        <div class="form-campos">
            <label for="">Descripción:</label>
            <textarea name="" id="" class="form-in"></textarea>
        </div>
        <div class="form-campos">
            <label for="">Superior:</label>
            <select name="" id="" class="form-in">
                <option value="">Sin Superior</option>
            </select>
        </div>
        <div class="form-campos">
            <input type="button" name="" id="" class="btn-default btn-azul btn-block" value="Añadir nueva Etiqueta" />
        </div>
    </form>
</div>
{include=html/footer}