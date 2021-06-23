/*
* Metodo ajax para enviar datos por post
*/
function postAjax(url, data, success){
	var params = typeof data == 'string' ? data : Object.keys(data).map(
		function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
	).join('&');
	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject(
		"Microsoft.XMLHTTP"
	);
	xhr.open('POST', url);
	xhr.onreadystatechange = function() {
		if (xhr.readyState>3 && xhr.status==200) { success(xhr.responseText); }
	};
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.setRequestHeader('Content-length', params.length);
	xhr.send(params);
	return xhr;
}

function procesarFormAcceso(){
	if( document.form_acceso ){
		formAcceso = document.form_acceso || {};
		formAcceso.addEventListener("submit", function(e){
			if( this.recordars.checked ) this.recordars.value = 1;
			else  this.recordars.value = 0;
			postAjax(formAcceso.action, {
				usuario: formAcceso.usuario.value,
				clave: hex_sha512(formAcceso.clave.value),
				recordars: this.recordars.value
			}, function(data){
			var respuesta = JSON.parse(data);
			if(respuesta.result) window.location = "inicio";
			else if( respuesta.error[0] == "limite_intentos" ){
				var msg = "<div class=\"msg-error\">Has superado el limite de intentos permitidos. Vuelve a intentar más tarde</div>";
				document.getElementById("lista_errores").innerHTML = msg;
			}
			else{
				var msg = "<div class=\"msg-error\">Usuario o Contraseña incorrectos.</div>";
					document.getElementById("lista_errores").innerHTML = msg;
				}
			});
			e.preventDefault();
		});
	}
}

function procesaFormRestableceClave(){
	if( document.form_restablececlave ){
		var formulario = document.form_restablececlave;
		formulario.addEventListener("submit", function(e){
			postAjax(formulario.action, {
				id: this.id.value,
				clave: hex_sha512(this.clave.value)
			}, function(data){
			var respuesta = JSON.parse(data);
			if(respuesta.result) window.location = "acceso";
			else{
				var msg = "<div class=\"msg-error\">Ocurrio un error.</div>";
					document.getElementById("lista_errores").innerHTML = msg;
				}
			});
			e.preventDefault();
		});
	}
}

/*
* Procesar formulario de la seccion acceso
*/
document.addEventListener("DOMContentLoaded", function(){
	procesarFormAcceso();
	procesaFormRestableceClave();
});
