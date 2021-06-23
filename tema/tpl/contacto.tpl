{include=tpl/html/header}
    <div class="header-st1">
        <div class="container">
            <h1>Página de Contacto</h1>
        </div>
    </div>
	<div class="container cont-960">
		<form name="contacto_form" class="cont-white" method="post" action="?contactar">
			<div class="form-campo">
				<label for="cnombre">Nombre:</label>
				<input type="text" name="cnombre" id="cnombre" class="form-in" />
			</div>
			<div class="form-campo">
				<label for="cmail">Email:</label>
				<input type="text" name="cmail" id="cmail" class="form-in" />
			</div>
			<div class="form-campo">
				<label for="casunto">Asunto:</label>
				<input type="text" name="casunto" id="casunto" class="form-in" />
			</div>
			<div class="form-campo">
				<label for="cmensaje">Mensaje:</label>
				<textarea name="cmensaje" id="cmensaje" class="form-in" rows="6"></textarea>
			</div>
			<button type="submit" class="button-default">Contactar</button>
		</form>
	</div>
{include=tpl/html/footer}
