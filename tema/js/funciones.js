function scrollToTop(scrollDuration){
    var scrollStep = -window.scrollY / (scrollDuration / 15);
    var scrollInterval = setInterval(function(){
        if ( window.scrollY != 0 ) window.scrollBy( 0, scrollStep );
        else clearInterval(scrollInterval);
    },15);
}

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

function getAjax(url, success) {
	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	xhr.open('GET', url);
	xhr.onreadystatechange = function() {
		if (xhr.readyState>3 && xhr.status==200) success(xhr.responseText);
	};
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.send();
	return xhr;
}

function crearMensaje(tipo, texto){
	var mensaje_alerta = document.createElement("div");
	mensaje_alerta.setAttribute("class", "msg-default msg-"+tipo);
	mensaje_alerta.innerHTML = "<span class=\"icon-notification\"></span> "+texto;
	var boton_cerrar = document.createElement("span");
	boton_cerrar.setAttribute("class", "msg-cerrar");
	boton_cerrar.innerHTML = "X";
	boton_cerrar.addEventListener("click", function(){
		fadeOut(this.parentNode, 500);
	});
	document.addEventListener("DOMNodeInserted", function(){
		var msgactual = document.querySelector(".msg-default");
		setTimeout(function(){
			fadeOut(msgactual, 500);
		}, 5000);
	});
	mensaje_alerta.appendChild(boton_cerrar);
	return mensaje_alerta;
}

function fadeOut(elemento, tiempo){
	elemento.style.opacity = 0;
	setTimeout(function(){
		elemento.style.display = "none";
	}, tiempo);
}

function fadeIn(elemento, tiempo){
	elemento.style.display = "block";
	setTimeout(function(){
		elemento.style.opacity = 1;
	}, tiempo);
}

document.addEventListener("DOMContentLoaded", function(e){
    //Boton Ir Arriba
    document.querySelector("#irArriba").addEventListener("click", function(e){
        scrollToTop(500);
        e.preventDefault();
    });

	//Menu de Navegacion con Animacion Desplegable
    document.querySelector("#switchnav").addEventListener("click", function(){
        var destino = document.querySelector(this.getAttribute("data-destino"));
        var estado = destino.getAttribute("data-estado");
        if( estado == "visible" ){
            destino.setAttribute("data-estado", "oculto");
            this.setAttribute("data-estado", "cerrado");
        }else{
            destino.setAttribute("data-estado", "visible");
            this.setAttribute("data-estado", "abierto");
        }
    });

    //Boton Mostrar busqueda
    document.querySelector("#btn-buscar").addEventListener("click", function(){
        var destino = document.querySelector(this.getAttribute("data-destino"));
        var estado = destino.getAttribute("data-estado");
        if( estado == "visible" ){
            destino.setAttribute("data-estado", "oculto");
            this.setAttribute("data-estado", "cerrado");
        }else{
            destino.setAttribute("data-estado", "visible");
            this.setAttribute("data-estado", "abierto");
        }
    });

	var comentForm = document.querySelector("#comentform") || false;
	if( comentForm ){
		comentForm.addEventListener("submit", function(e){
			postAjax(this.action, {
				autor: this.autor.value,
				email: this.email.value,
				sitio: this.sitio.value,
				contenido: this.contenido.value,
				captchaResponse: document.querySelector("#g-recaptcha-response").value,
			}, function(data){
				var respuesta = JSON.parse(data);
				if(respuesta.result == 1){
					var mensaje_alerta = crearMensaje("success",
						"Tu comentario ha sido enviado correctamente."
					);
					var nodos = comentForm.getElementsByTagName("div");
					comentForm.insertBefore(mensaje_alerta, nodos[0]);
				}else{
					if( respuesta.error.length ){
						if( respuesta.error[0] == "demasiados_comentarios" ){
							var mensaje_alerta = crearMensaje("error",
								"Error: No puedes mandar tantos comentarios tan seguido."
							);
						}else{
							var mensaje_alerta = crearMensaje("error",
								"Error: Todos los campos son requeridos."
							);
						}
					}else{
						var mensaje_alerta = crearMensaje("error",
							"Ha sucedido un problema, intenta más tarde."
						);
					}
					var nodos = comentForm.getElementsByTagName("div");
					comentForm.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
			e.preventDefault();
		});
	}

	var mangacaps = document.querySelectorAll("a[data-cap]") || [];
	if( mangacaps ){
		var totalcaps = mangacaps.length;
		for( i=0; i<totalcaps; i++ ){
			mangacaps[i].addEventListener("click", function(e){
				e.preventDefault();
				getAjax(this.getAttribute("data-cap"), function(respuesta){
					var respuesta = JSON.parse(respuesta) || {};
					console.log(respuesta);
					var newmangareader = new mtmangareader({
						header: respuesta.pagtitle,
						body: '',
					});
					respuesta.actual = 1;

					var redimencionar = SITIO_URL+"/miniatura?w=600&q=100&src=";

					var imgpagac = document.createElement("img");
					imgpagac.setAttribute("id", "mreaderimg");
					imgpagac.setAttribute("src", redimencionar+respuesta.pages[respuesta.actual]);
					var btnright = document.createElement("button");
					btnright.setAttribute("class", "btnflr icon-circle-left");
					var btnleft = btnright.cloneNode();
					btnleft.setAttribute("class", "btnflr icon-circle-right bx-right");

					btnright.addEventListener("click", function(){
						var mreaderimg = document.querySelector("#mreaderimg");
						if( respuesta.actual > 0 ) respuesta.actual -= 1;
						mreaderimg.src = redimencionar+respuesta.pages[respuesta.actual];
					});
					btnleft.addEventListener("click", function(){
						var mreaderimg = document.querySelector("#mreaderimg");
						if( respuesta.actual < respuesta.pages.length ) respuesta.actual += 1;
						mreaderimg.src = redimencionar+respuesta.pages[respuesta.actual];
					});
					newmangareader.append(imgpagac);
					newmangareader.append(btnright);
					newmangareader.append(btnleft);

					newmangareader.insert();
				});
			});
		}
	}

	/*
	* Procesar formulario de contacto
	*/
	function contacto_enviar(){
		if(document.contacto_form){
			var contacto_form = document.contacto_form;
			contacto_form.addEventListener("submit", function(e){
				contacto_form.querySelector("button[type=submit]").setAttribute("disabled", "disabled");
				postAjax(this.action, {
					cnombre: this.cnombre.value,
					cmail: this.cmail.value,
					cmensaje: this.cmensaje.value,
					casunto: this.casunto.value
				}, function(data){
					var respuesta = data;
					if(respuesta == 1){
						var mensaje_alerta = crearMensaje("success",
							"Tu mensaje se ha enviado correctamente."
						);
						var nodos = contacto_form.getElementsByTagName("div");
						contacto_form.insertBefore(mensaje_alerta, nodos[0]);
					}else if( respuesta == 2 ){
						var mensaje_alerta = crearMensaje("error",
							"Todos los campos del formulario son requeridos."
						);
						var nodos = contacto_form.getElementsByTagName("div");
						contacto_form.insertBefore(mensaje_alerta, nodos[0]);
					}else{
						var mensaje_alerta = crearMensaje("error",
							"Ha ocurrido un problema al procesar el formulario, intenta más tarde."
						);
						var nodos = contacto_form.getElementsByTagName("div");
						contacto_form.insertBefore(mensaje_alerta, nodos[0]);
					}
				});
				contacto_form.querySelector("button[type=submit]").removeAttribute("disabled");
				e.preventDefault();
			});
		}
	}
	contacto_enviar();
	
	var myLazyLoad = new LazyLoad();

}, false);
