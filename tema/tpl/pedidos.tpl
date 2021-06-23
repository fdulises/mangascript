{include=tpl/html/header}
    <div class="header-st1">
        <div class="container">
            <h1>Página de Pedidos</h1>
        </div>
    </div>
	<div class="container cont-960">
		<form id="pedidos_form" name="pedidos_form" class="cont-white" method="post" action="?pedido">
			<div class="form-campo">
				<label for="pedido">Nombre del manga:</label>
				<input type="text" name="pedido" id="pedido" class="form-in" />
			</div>
			<div class="form-campo">
				<div class="g-recaptcha" data-sitekey="{SITIO_RECAPTCHA}"></div>
			</div>
			<button type="submit" name="envio" class="button-default">Pedir manga</button>
		</form>
		<script>
			document.querySelector("#pedidos_form").addEventListener("submit", function(e){
				e.preventDefault();
				this.envio.setAttribute("disabled", "disabled");
				var datos = {
					pedido: this.pedido.value,
					captchaResponse: document.querySelector("#g-recaptcha-response").value,
				};
				postAjax(this.action, datos, function(){
					alert("Pedio enviado correctamente");
					document.querySelector("#pedidos_form").reset();
				});
			});
		</script>
	</div>
	<div class="container cont-960">
		<div class="cont-white">
			<div class="container">
				<div class="art-row">
					<div class="gd-70"><h3>Ultimos mangas pedidos</h3></div>
					<div class="gd-30"><h3>Cumplido</h3></div>
				</div>
				{lista_pedidos}
				<div id="pedido_{pedido_id}" class="art-row" title="Pedido desde {pedido_fecha}">
					<div class="gd-70">
						{pedido_nombre}
					</div>
					<div class="gd-30">
						{pedido_estado}
					</div>
				</div>
				{/lista_pedidos}
			</div>
		</div>
	</div>
{include=tpl/html/footer}
