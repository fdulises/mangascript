/*
* Metodo ajax para enviar datos por post
*/
function postAjax(url, data, success){
	var params = typeof data == 'string' ? data : Object.keys(data).map(
		function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
	).join('&');

	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
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
/*
* Metodo ajax para enviar datos por get
*/
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

function CKupdate(){
	for (instance in CKEDITOR.instances)
		CKEDITOR.instances[instance].updateElement();
	return true;
}

/*
* Procesar formulario de la seccion agregar usuario
*/
function form_usuario_agregar(){
  if(document.form_u_agregar){
    var fu_agregar = document.form_u_agregar;
    fu_agregar.addEventListener("submit", function(e){
      postAjax(fu_agregar.action, {
        nickname: fu_agregar.nickname.value,
        email: fu_agregar.email.value,
        clave: hex_sha512(fu_agregar.clave.value),
        grupo: fu_agregar.grupo.value,
        nombre: this.nombre.value,
        descrip:  this.descrip.value,
        sitio: this.sitio.value
      }, function(data){
        var respuesta = JSON.parse(data);
        if(respuesta.result) window.location = "usuario";
        else{
          var msg = "<div class=\"msg-error\">Hay algunos errores con los datos ingresados.</div>";
          document.getElementById("lista_errores").innerHTML = msg;
        }
      });
      e.preventDefault();
    });
  }
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

/*
* Procesar formulario de la seccion editar usuario
*/
function form_usuario_editar(){
	if(document.form_u_editar){
		var fu_editar = document.form_u_editar;
		fu_editar.addEventListener("submit", function(e){
			var datos = {
				email: this.email.value,
				grupo: this.grupo.value,
				nombre: this.nombre.value,
				descrip: this.descrip.value,
				sitio: this.sitio.value
			};
			if( this.clave.value ) datos.clave = hex_sha512(this.clave.value);
			postAjax(fu_editar.action, datos, function(data){
				if( datos.clave ) window.location = "usuario";
				var respuesta = JSON.parse(data);
				subir();
				if(respuesta.result){
					var mensaje_alerta = crearMensaje(
						"success", "Se han actualizado los datos del usuario"
					);
					var nodos = fu_editar.getElementsByTagName("div");
					fu_editar.insertBefore(mensaje_alerta, nodos[0]);
				}else{
					var mensaje_alerta = crearMensaje(
						"error", "Hay algunos errores con los datos ingresados."
					);
					var nodos = fu_editar.getElementsByTagName("div");
					fu_editar.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
			e.preventDefault();
		});
	}
}

/*
* Procesar formulario de la seccion agregar pagina
*/
function form_pagina_agregar(){
  if(document.form_e_agregar){
    var fe_agregar = document.form_e_agregar;
    fe_agregar.addEventListener("submit", function(e){
      postAjax(fe_agregar.action, {
        titulo: fe_agregar.titulo.value,
        url: fe_agregar.url.value,
        contenido: fe_agregar.contenido.value,
        descrip: fe_agregar.descrip.value,
        portada: fe_agregar.portada.value,
        estado: fe_agregar.estado.value,
		plantilla: this.plantilla.value
      }, function(data){
        var respuesta = JSON.parse(data);
        if(respuesta.result) window.location = "pagina";
        else{
			subir();
  		 	var mensaje_alerta = crearMensaje("error",
  				"Hay algunos errores con los datos ingresados."
  			);
			var nodos = fe_agregar.getElementsByTagName("div");
			fe_agregar.insertBefore(mensaje_alerta, nodos[0]);
        }
      });
      e.preventDefault();
    });
  }
}

/*
* Procesar formulario de la seccion editar pagina
*/
function form_pagina_editar(){
  if(document.form_e_editar){
    var fe_agregar = document.form_e_editar;
    fe_agregar.addEventListener("submit", function(e){
      postAjax(fe_agregar.action, {
        titulo: this.titulo.value,
        url: this.url.value,
        contenido: this.contenido.value,
        descrip: this.descrip.value,
        portada: this.portada.value,
        estado: this.estado.value,
		plantilla: this.plantilla.value
      }, function(data){
        var respuesta = JSON.parse(data);
        if(respuesta.result){
			subir();
			var mensaje_alerta = crearMensaje("success",
				"Se han actualizado los datos de la página."
			);
			var nodos = fe_agregar.getElementsByTagName("div");
			fe_agregar.insertBefore(mensaje_alerta, nodos[0]);
		}else{
		  subir();
		  var mensaje_alerta = crearMensaje("error",
			  "Hay algunos errores con los datos ingresados."
		  );
		  var nodos = fe_agregar.getElementsByTagName("div");
		  fe_agregar.insertBefore(mensaje_alerta, nodos[0]);
        }
      });
      e.preventDefault();
    });
  }
}

/*
* Funcionamiento de boton Eliminar usuarios
*/
function usuario_eliminar(){
  if(document.querySelector('a[data-eliminar]') ){
    [].forEach.call(document.querySelectorAll('a[data-eliminar]'), function (el){el.addEventListener('click', function(e) {
      var confirmar = confirm("Realmente quieres eliminar este usuario?");
	  if(confirmar){
		  fadeOut(this.parentNode.parentNode, 500);
		  getAjax(this.href, function(data){
			  var respuesta = JSON.parse(data);
			  if(!respuesta.result) alert("No se pudo eliminar el usuario.");
		  });
	  }
      e.preventDefault();
    }, false);});
  }
}

/*
* Funcionamiento de boton Eliminar pagina
*/
function pagina_eliminar(){
	if(document.querySelector("a[href^='pagina\?accion\=eliminar']") ){
		[].forEach.call(document.querySelectorAll("a[href^='pagina\?accion\=eliminar']"),
		function (el){el.addEventListener('click', function(e) {
			var confirmar = confirm("Realmente quieres eliminar esta Página?");
			if(confirmar){
				fadeOut(this.parentNode.parentNode, 500);
				getAjax(this.href, function(data){
					var respuesta = JSON.parse(data);
					if(!respuesta.result) alert("No se pudo eliminar la página.");
				});
			}
			e.preventDefault();
		}, false);});
	}
}

/*
* Animacion de ir arriba
*/
function subir(){
	var arriba;
	function animarSubir(){
		if (document.body.scrollTop != 0 || document.documentElement.scrollTop != 0) {
			window.scrollBy(0, -20);
			arriba = setTimeout(animarSubir, 5);
		}else clearTimeout(arriba);
	}
	animarSubir();
}

/*
* Procesar formulario de la seccion agregar categoria
*/
function form_categoria_crear(){
	if(document.form_c_agregar){
		var fc_agregar = document.form_c_agregar;
		fc_agregar.addEventListener("submit", function(e){
			postAjax(fc_agregar.action, {
				nombre: fc_agregar.nombre.value,
				url: fc_agregar.url.value,
				descrip: fc_agregar.descrip.value
			}, function(data){
				var respuesta = JSON.parse(data);
				if(respuesta.result) window.location = "categoria";
				else{
					subir();
					var mensaje_alerta = crearMensaje("error",
						"Hay algunos errores con los datos ingresados."
					);
					var nodos = fc_agregar.getElementsByTagName("div");
					fc_agregar.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
			e.preventDefault();
		});
	}
}

/*
* Procesar formulario de la seccion editar categoria
*/
function form_categoria_editar(){
	if(document.form_c_editar){
		var fc_editar = document.form_c_editar;
		fc_editar.addEventListener("submit", function(e){
			postAjax(fc_editar.action, {
				nombre: fc_editar.nombre.value,
				url: fc_editar.url.value,
				descrip: fc_editar.descrip.value
			}, function(data){
				var respuesta = JSON.parse(data);
				if(respuesta.result){
					subir();
					var mensaje_alerta = crearMensaje("success",
						"Los cambios han sido guardado correctamente."
					);
					var nodos = fc_editar.getElementsByTagName("div");
					fc_editar.insertBefore(mensaje_alerta, nodos[0]);
				}else{
					subir();
					var mensaje_alerta = crearMensaje("error",
						"Hay algunos errores con los datos ingresados."
					);
					var nodos = fc_editar.getElementsByTagName("div");
					fc_editar.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
			e.preventDefault();
		});
	}
}

/*
* Funcionamiento de boton Eliminar categoria
*/
function categoria_eliminar(){
	if(document.querySelector("a[href^='categoria\?accion\=eliminar']") ){
		[].forEach.call(document.querySelectorAll("a[href^='categoria\?accion\=eliminar']"),
		function (el){el.addEventListener('click', function(e) {
			var confirmar = confirm("Realmente quieres eliminar esta Categoría?");
			if(confirmar){
				fadeOut(this.parentNode.parentNode, 500);
				getAjax(this.href, function(data){
					var respuesta = JSON.parse(data);
					if(!respuesta.result) alert("No se pudo eliminar la Categoría.");
				});
			}
			e.preventDefault();
		}, false);});
	}
}

function manga_import_info(fa_agregar){
	var importselect = fa_agregar.importar;
	var importid = fa_agregar.mangaid;

	function rellenarcampos(text){
		var datos = JSON.parse(text);
		if( datos.estado ){
			fa_agregar.titulo.value = datos.titulo;
			fa_agregar.contenido.value = datos.descrip;
			fa_agregar.descrip.value = datos.descrip;
			fa_agregar.portada.value = datos.cover;
			fa_agregar.tags.value = datos.generos.join();

			subir();
			var nodos = fa_agregar.getElementsByTagName("div");
			fa_agregar.insertBefore(crearMensaje("success",
				"Se han importado los datos del manga correctamente."
			), nodos[0]);
		}else{
			alert("No se pudo obtener dados de manga");
		}
	}

	document.querySelector("#submit_mimport").addEventListener('click', function(){
		var importador = importselect.value;
		var importadorid = importid.value;
		if( importador && importadorid ){
			if( importador == 1 ) var url = SITIO_URL+'/apimanga/'+importadorid;
			else if( importador == 2 ) var url = SITIO_URL+'/apimanga2?id='+importadorid;
			getAjax(url, rellenarcampos);
		}else{
			modal_alert("Error", "Debe seleccionar el id a importar y una opcion para hacerlo");
		}
	});
}
/*
* Procesar formulario de la seccion agregar articulo
*/
function form_articulo_agregar(){
	if(document.form_a_agregar){
		var fa_agregar = document.form_a_agregar;
		//Importar datos de manga
		manga_import_info(fa_agregar);
		fa_agregar.addEventListener("submit", function(e){
			var datos = {
				titulo: fa_agregar.titulo.value,
				url: fa_agregar.url.value,
				contenido: fa_agregar.contenido.value,
				descrip: fa_agregar.descrip.value,
				portada: fa_agregar.portada.value,
				estado: fa_agregar.estado.value,
				categoria: fa_agregar.categoria.value,
				tags: fa_agregar.tags.value,
			};
			if( fa_agregar.importar.value && fa_agregar.mangaid.value ){
				datos.manga_api = fa_agregar.importar.value;
				datos.manga_api_id = fa_agregar.mangaid.value;
			}
			postAjax(fa_agregar.action, datos, function(data){
				var respuesta = JSON.parse(data);
				if(respuesta.result) window.location = "manga";
				else{
					subir();
					var mensaje_alerta = crearMensaje("error",
						"Hay algunos errores con los datos ingresados."
					);
					var nodos = fa_agregar.getElementsByTagName("div");
					fa_agregar.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
			e.preventDefault();
		});
	}
}

/*
* Procesar formulario de la seccion editar articulo
*/
function form_articulo_editar(){
	if(document.form_a_editar){
		var fa_agregar = document.form_a_editar;
		manga_import_info(fa_agregar);
		fa_agregar.addEventListener("submit", function(e){
			var datos = {
				titulo: fa_agregar.titulo.value,
				url: fa_agregar.url.value,
				contenido: fa_agregar.contenido.value,
				descrip: fa_agregar.descrip.value,
				portada: fa_agregar.portada.value,
				estado: fa_agregar.estado.value,
				categoria: fa_agregar.categoria.value,
				tags: fa_agregar.tags.value,
				manga_api: 0,
				manga_api_id: '',
			}
			if( fa_agregar.importar.value && fa_agregar.mangaid.value ){
				datos.manga_api = fa_agregar.importar.value;
				datos.manga_api_id = fa_agregar.mangaid.value;
			}
			postAjax(fa_agregar.action, datos, function(data){
				var respuesta = JSON.parse(data);
				if(respuesta.result){
					subir();
					var mensaje_alerta = crearMensaje("success",
						"Se han actualizado los datos del artículo."
					);
					var nodos = fa_agregar.getElementsByTagName("div");
					fa_agregar.insertBefore(mensaje_alerta, nodos[0]);
				}else{
					subir();
					var mensaje_alerta = crearMensaje("error",
						"Hay algunos errores con los datos ingresados."
					);
					var nodos = fa_agregar.getElementsByTagName("div");
					fa_agregar.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
			e.preventDefault();
		});
	}
}

/*
* Funcionamiento de boton Eliminar pagina
*/
function articulo_eliminar(){
	if(document.querySelector("a[href^='manga\?accion\=eliminar']") ){
		[].forEach.call(document.querySelectorAll("a[href^='manga\?accion\=eliminar']"),
		function (el){el.addEventListener('click', function(e) {
			var confirmar = confirm("Realmente quieres eliminar esta entrada?");
			if(confirmar){
				fadeOut(this.parentNode.parentNode, 500);
				getAjax(this.href, function(data){
					var respuesta = JSON.parse(data);
					if(!respuesta.result) alert("No se pudo eliminar la entrada.");
				});
			}
			e.preventDefault();
		}, false);});
	}
}

/*
* Procesar formulario de la seccion editar informacion del sitio
*/
function form_sitio_editar(){
	if(document.form_s_editar){
		var fs_editar = document.form_s_editar;
		fs_editar.addEventListener("submit", function(e){
			postAjax(fs_editar.action, {
				titulo: this.titulo.value,
				lema: this.lema.value,
				descrip: this.descrip.value,
				url: this.url.value,
				email: this.email.value
			}, function(data){
				var respuesta = JSON.parse(data);
				if(respuesta.result){
					subir();
					var mensaje_alerta = crearMensaje("success",
						"Se han actualizado los datos del sitio."
					);
					var nodos = fs_editar.getElementsByTagName("div");
					fs_editar.insertBefore(mensaje_alerta, nodos[0]);
				}else{
					subir();
					var mensaje_alerta = crearMensaje("error",
						"Hay algunos errores con los datos ingresados."
					);
					var nodos = fs_editar.getElementsByTagName("div");
					fs_editar.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
			e.preventDefault();
		});
	}
}

/*
* Procesar formulario de la seccion editar configuracion del sitio
*/
function form_config_editar(){
	if(document.form_sc_editar){
		var fs_editar = document.form_sc_editar;
		fs_editar.addEventListener("submit", function(e){
			postAjax(fs_editar.action, {
				epp: this.epp.value,
				comentarios: this.comentarios.value,
				intentos: this.intentos.value,
				registro: this.registro.value,
				validaemail: this.validaemail.value,
				tema_nombre: this.tema_nombre.value,
				tema_url: this.tema_url.value,
				tema_ext: this.tema_ext.value
			}, function(data){
				var respuesta = JSON.parse(data);
				if(respuesta.result){
					subir();
					var mensaje_alerta = crearMensaje("success",
						"Se ha actualizado la configuración del sitio."
					);
					var nodos = fs_editar.getElementsByTagName("div");
					fs_editar.insertBefore(mensaje_alerta, nodos[0]);
				}else{
					subir();
					var mensaje_alerta = crearMensaje("error",
						"Hay algunos errores con los datos ingresados."
					);
					var nodos = fs_editar.getElementsByTagName("div");
					fs_editar.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
			e.preventDefault();
		});
	}
}

/*
* Procesar formulario de la seccion editar comentario
*/
function form_comentario_editar(){
	if( document.form_coment_editar ){
		var formularioenv = document.form_coment_editar;
		formularioenv.addEventListener("submit", function(e){
			var datos = {
				autor: this.autor.value,
				contenido: this.contenido.value,
				estado: this.estado.value
			};
			postAjax(formularioenv.action, datos, function(data){
				var respuesta = JSON.parse(data);
				subir();
				if(respuesta.result){
					var mensaje_alerta = crearMensaje(
						"success", "El comentario se ha actualizado"
					);
					var nodos = formularioenv.getElementsByTagName("div");
					formularioenv.insertBefore(mensaje_alerta, nodos[0]);
				}else{
					var mensaje_alerta = crearMensaje(
						"error", "Hay algunos errores con los datos ingresados."
					);
					var nodos = formularioenv.getElementsByTagName("div");
					formularioenv.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
			e.preventDefault();
		});
	}
}

/*
* Funcionamiento de boton Eliminar comentario
*/
function btn_comentario_eliminar(){
	if(document.querySelector("a[href^='comentario\?accion\=eliminar']") ){
		[].forEach.call(document.querySelectorAll("a[href^='comentario\?accion\=eliminar']"),
		function(el){el.addEventListener('click', function(e) {
			fadeOut(this.parentNode.parentNode, 500);
			getAjax(this.href, function(data){
				var respuesta = JSON.parse(data);
				if(!respuesta.result) alert("No se pudo eliminar la entrada.");
			});
			e.preventDefault();
		}, false);});
	}
}
function modal_alert(titulo, contenido){
	var modalert = new mw({'header': titulo,'body': contenido});
	modalert.insert();
}

function mtajaxfull(elemento, retorno){
	var retorno = retorno || function(e){};
	function onreadystatechangeHandler(evt, retornofunc) {
		var status, text, readyState;
		try {
			readyState = evt.target.readyState;
			text = evt.target.responseText;
			status = evt.target.status;
		}
		catch(e) { return;}
		if (readyState == 4 && status == '200' && evt.target.responseText) {
			retornofunc(evt.target.responseText);
		}
	}
	var formData = new FormData(elemento);
	var action = elemento.getAttribute('action');
	var xhr = new XMLHttpRequest();
	xhr.addEventListener('readystatechange', function(e){
		onreadystatechangeHandler(e, retorno);
	}, false);
	xhr.open('POST', action, true);
	xhr.send(formData);
}
function modal_upload(inuploadid){
	var mw_upload = new mw({'header': 'Subir imagen','body': ''});
	var newuploadbox = document.createElement("div");
	newuploadbox.id = "newuploadbox";

	var nuewimgformupload = document.createElement("form");
	nuewimgformupload.setAttribute("class", "gd-100 tx-center");
	nuewimgformupload.setAttribute("action", "imgupload");
	nuewimgformupload.setAttribute("method", "post");
	nuewimgformupload.setAttribute("enctype", "multipart/form-data");
	nuewimgformupload.setAttribute("id", "imgformupload");

	nuewimgformupload.addEventListener("submit", function(e){
		e.preventDefault();
		mtajaxfull(this, function(resultado){
			var resultado = JSON.parse(resultado);
			if( resultado.estado == 1 ){
				mw_upload.remove();
				modal_alert("Exito", "La imagen se ha subido correctemente");
				document.querySelector(inuploadid).value = resultado.ruta;
			}else{
				modal_alert("Error:", "<p>Ha ocurrido un error al procesar lo solicitado</p><p>Vuelva a intentar más tarde</p>");
			}
		});
	});

	var nuewimgtoup = document.createElement("input");
	nuewimgtoup.setAttribute("name", "imgtoup");
	nuewimgtoup.setAttribute("type", "file");
	nuewimgtoup.setAttribute("id", "imgtoup");

	var mangaid = document.querySelector("form[data-mangaid]");
	mangaid = mangaid.getAttribute("data-mangaid");

	var dirimgtoup = document.createElement("input");
	dirimgtoup.setAttribute("name", "dirimgtoup");
	dirimgtoup.setAttribute("type", "hidden");
	dirimgtoup.setAttribute("id", "dirimgtoup");
	dirimgtoup.setAttribute("value", mangaid);

	var btnformuploadsub = document.createElement("button");
	btnformuploadsub.setAttribute("class", "bta icon-upload2");
	btnformuploadsub.setAttribute("type", "submit");

	nuewimgformupload.appendChild(nuewimgtoup);
	nuewimgformupload.appendChild(dirimgtoup);
	nuewimgformupload.appendChild(btnformuploadsub);
	newuploadbox.appendChild(nuewimgformupload);

	mw_upload.mw.appendChild(newuploadbox);
	mw_upload.insert();
}
function nrand(){return Math.ceil(Math.random()*100000);}
function form_mimport(form_ma_agregar){
	submit_mimport.addEventListener("click", function(){
		var opcionImport = form_ma_agregar.importar.value;
		var mangaIdImport = form_ma_agregar.mangaid.value;
		var submit_mimport = form_ma_agregar.submit_mimport.value;

		if( !(form_ma_agregar.importar.value && form_ma_agregar.mangaid.value) ){
			modal_alert("Error", "Debe seleccionar el id a importar y una opcion para hacerlo");
			return;
		}
		var rutaapi = '';
		if( 1 == opcionImport ) rutaapi = SITIO_URL+'/apimanga/'+mangaIdImport;
		else if( 2 == opcionImport ) rutaapi = SITIO_URL+'/apimanga2/?id='+mangaIdImport;

		getAjax( rutaapi, function(resultado){
			resultado = JSON.parse(resultado);
			var infocapsp = {
				estado: true,
				total: resultado.caps.length,
				actual: 1,
				completados: 0,
				restantes: resultado.caps.length,
				registro: [],
				errores: 0,
			};
			if( 0 == infocapsp.total ){
				alert("No se encontrarón capitulos, la importación no se ha podido llevar a cabo");
				return;
			}
			var respuesta = confirm("En total hay "+infocapsp.total+" capitulos\n Desea continuar?");
			var htmlresp = "<p>Se estan importando los capitulos...</p><h3>Información del proceso</h3><div class='gd-80'>Total:</div><div id='infocapsp_total' class='gd-20'>"+infocapsp.total+"</div><div class='gd-80'>Completados:</div><div id='infocapsp_completados' class='gd-20'>0</div><div class='gd-80'>Restantes:</div><div id='infocapsp_restantes' class='gd-20'>"+infocapsp.restantes+"</div><div class='gd-80'>Actual:</div><div id='infocapsp_actual' class='gd-20'>"+infocapsp.actual+"</div>";
			htmlresp += "<p class='tx-center'><button type='button' class='btn-default' id='infocapsp_btn'>Detener</button></p>"
			if( respuesta ){
				modal_alert("Procesando", htmlresp);
				var infocapsp_btn = document.querySelector("#infocapsp_btn");
				var infocapsp_completados = document.querySelector("#infocapsp_completados");
				var infocapsp_restantes = document.querySelector("#infocapsp_restantes");
				var infocapsp_actual = document.querySelector("#infocapsp_actual");

				infocapsp_btn.addEventListener("click", function(){
					infocapsp.estado = false;
				});

				while( infocapsp.completados < infocapsp.total ){
					if( !infocapsp.estado ) break;
					infocapsp.completados += 1;
					infocapsp_completados.innerHTML = parseInt(infocapsp_completados.innerHTML)+1;
					var actionenvioPostCaps = ( 1 == opcionImport ) ? rutaapi+'/'+infocapsp.actual+'?all' : rutaapi+'&cap='+infocapsp.actual+'&all';

					getAjax(actionenvioPostCaps, function(resultactual){
						resultactual = JSON.parse(resultactual);
						if( resultactual ){
							var datos = {
								titulo: resultactual.pagtitle,
								idcapitulo: resultactual.pagid,
								paginas: resultactual.pages.join(),
							};
							postAjax(form_ma_agregar.action, datos, function(data){
								var respuesta = JSON.parse(data);
								if(!respuesta.result) infocapsp.errores += 1;
							});
						}else infocapsp.errores += 1;
					});

					infocapsp.actual += 1;
					infocapsp_actual.innerHTML = parseInt(infocapsp_actual.innerHTML)+1;
				}
				alert("El proceso se ha completado con "+ infocapsp.errores + " errores");

				/*function envioPostCaps(action, data, retorno){
					postAjax(form_ma_agregar.action, datos, retorno);
				}*/

			}
		});
	});
}
function form_ma_adcap(){
	var form_ma_agregar = document.form_ma_agregar;
	if( form_ma_agregar ){
		form_mimport(form_ma_agregar);

		var adimgpag = document.querySelector("#adimgpag");
		var imgpaginas = document.querySelector("#imgpaginas");
		adimgpag.addEventListener("click", function(){
			var newcont = document.createElement("div");
			var newcont1 = document.createElement("div");
			newcont1.setAttribute("class", "gd-10");
			var newcont2 = document.createElement("div");
			newcont2.setAttribute("class", "gd-90");

			var numerorand = nrand();

			var newbtnupload = document.createElement("button");
			newbtnupload.setAttribute("class", "bta icon-upload2");
			newbtnupload.setAttribute("title", "Subir imágen");
			newbtnupload.setAttribute("type", "button");
			newbtnupload.setAttribute("id", "btnupload_"+numerorand);
			newbtnupload.addEventListener("click", function(){
				modal_upload("#inpupload_"+numerorand);
			});

			var newcampo = document.createElement("input");
			newcampo.setAttribute("class", "form-in imgpagcampo");
			newcampo.setAttribute("placeholder", "Dirección de la imagen");
			newcampo.setAttribute("id", "inpupload_"+numerorand);

			newcont1.appendChild(newbtnupload);
			newcont2.appendChild(newcampo);
			newcont.appendChild(newcont1);
			newcont.appendChild(newcont2);
			imgpaginas.appendChild(newcont);
		});

		form_ma_agregar.addEventListener("submit", function(e){
			var paginas = [];
			var paglista = document.querySelectorAll(".imgpagcampo") || [];
			var totallista = paglista.length;
			for(i=0; i<totallista; i++){
				paginas[i] = paglista[i].value;
			}
			paginas=paginas.join();
			e.preventDefault();
			var datos = {
				titulo: this.titulo.value,
				idcapitulo: this.idcapitulo.value,
				paginas: paginas
			};
			postAjax(form_ma_agregar.action, datos, function(data){
				var respuesta = JSON.parse(data);
				subir();
				if(respuesta.result){
					window.location.href = document.querySelector("#mangacap_col").href;
				}else{
					var mensaje_alerta = crearMensaje(
						"error", "Hay algunos errores con los datos ingresados."
					);
					var nodos = form_ma_agregar.getElementsByTagName("div");
					form_ma_agregar.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
		});
	}
}

/*
* Funcionamiento de boton Eliminar pagina
*/
function manga_cap_eliminar(){
	if(document.querySelector("a[href^='manga\?accion\=delcap']") ){
		[].forEach.call(document.querySelectorAll("a[href^='manga\?accion\=delcap']"),
		function (el){el.addEventListener('click', function(e) {
			var confirmar = confirm("Realmente quieres eliminar esta Capitulo?");
			if(confirmar){
				fadeOut(this.parentNode.parentNode, 500);
				getAjax(this.href, function(data){
					var respuesta = JSON.parse(data);
					if(!respuesta.result) alert("No se pudo eliminar la página.");
				});
			}
			e.preventDefault();
		}, false);});
	}
}

document.addEventListener("DOMContentLoaded", function(){
	//Procesamos formulario de creacion de usuaios
	form_usuario_agregar();
	//Procesamos formulario de edicion de usuaios
	form_usuario_editar();
	//Funcionamiento de boton eliminar usuario
	usuario_eliminar();
	//Procesamos formulario de creacion de paginas
	form_pagina_agregar();
	//Procesamos formulario de edicion de paginas
	form_pagina_editar();
	//Procesamos formulario de la seccion crear categoria
	form_categoria_crear();
	//Procesamos formulario de la seccion editar categoria
	form_categoria_editar();
	//Funcionamiento en el boton eliminar categoria
	categoria_eliminar();
	//Funcionamiento en el boton eliminar página
	pagina_eliminar();
	//Procesamos formulario de creacion de articulos
	form_articulo_agregar();
	//Procesamos formulario de edicion de articulos
	form_articulo_editar();
	//Funcionamiento en el boton eliminar articulo
	articulo_eliminar();
	//Procesamos formulario de edicion de informacion del sitio
	form_sitio_editar();
	//Procesamos formulario de edicion de configuracion del sitio
	form_config_editar();
	//Procesamos formulario de edicion de comentarios
	form_comentario_editar();
	//Funcionamiento del boton eliminar comentario
	btn_comentario_eliminar();
	//Procesamos formulario de subida de capitulos
	form_ma_adcap();
	form_ma_editcap();
	manga_cap_eliminar()
});

function form_ma_editcap(){
	if( document.form_ma_editar ){
		var form_ma_editcap = document.form_ma_editar;
		var adimgpag = document.querySelector("#adimgpag");
		var imgpaginas = document.querySelector("#imgpaginas");
		adimgpag.addEventListener("click", function(){
			var newcont = document.createElement("div");
			var newcont1 = document.createElement("div");
			newcont1.setAttribute("class", "gd-10");
			var newcont2 = document.createElement("div");
			newcont2.setAttribute("class", "gd-90");

			var numerorand = nrand();

			var newbtnupload = document.createElement("button");
			newbtnupload.setAttribute("class", "bta icon-upload2");
			newbtnupload.setAttribute("title", "Subir imágen");
			newbtnupload.setAttribute("type", "button");
			newbtnupload.setAttribute("id", "btnupload_"+numerorand);
			newbtnupload.addEventListener("click", function(){
				modal_upload("#inpupload_"+numerorand);
			});

			var newcampo = document.createElement("input");
			newcampo.setAttribute("class", "form-in imgpagcampo");
			newcampo.setAttribute("placeholder", "Dirección de la imagen");
			newcampo.setAttribute("id", "inpupload_"+numerorand);

			newcont1.appendChild(newbtnupload);
			newcont2.appendChild(newcampo);
			newcont.appendChild(newcont1);
			newcont.appendChild(newcont2);
			imgpaginas.appendChild(newcont);
		});

		form_ma_editcap.addEventListener("submit", function(e){
			e.preventDefault();
			var paginas = [];
			var paglista = document.querySelectorAll(".imgpagcampo") || [];
			var totallista = paglista.length;
			for(i=0; i<totallista; i++){
				paginas[i] = paglista[i].value;
			}
			paginas=paginas.join();
			var datos = {
				titulo: this.titulo.value,
				idcapitulo: this.idcapitulo.value,
				paginas: paginas,
			};
			postAjax(form_ma_editcap.action, datos, function(data){
				var respuesta = JSON.parse(data);
				subir();
				if(respuesta.result){
					var mensaje_alerta = crearMensaje(
						"success", "La entrada se ha actualizado correctamente."
					);
					var nodos = form_ma_editcap.getElementsByTagName("div");
					form_ma_editcap.insertBefore(mensaje_alerta, nodos[0]);
				}else{
					var mensaje_alerta = crearMensaje(
						"error", "Hay algunos errores con los datos ingresados."
					);
					var nodos = form_ma_editcap.getElementsByTagName("div");
					form_ma_editcap.insertBefore(mensaje_alerta, nodos[0]);
				}
			});
		});
	}
}


function llamar_ckeditor(){
	CKEDITOR.replace( 'contenido', {
		filebrowserBrowseUrl: SITIO_URL+'/mt_extras/finder/ckfinder.html',
		filebrowserUploadUrl: SITIO_URL+'/mt_extras/finder/core/connector/php/connector.php?command=QuickUpload&type=Files'
	} );
	document.querySelector(".mteditor").addEventListener('submit', CKupdate, false);
}
function cover_mostrar(){
	var portadacampo = document.querySelector("#portada");

	function appendPortada(){
		var portadaurl = portadacampo.value;
		if( portadaurl != '' ){
			var portada = document.querySelector("#cover_preview") || document.createElement("img");
			portada.setAttribute("src", portadaurl);
			portada.setAttribute("id", "cover_preview");
			document.querySelector("#coverinput").appendChild(portada);
		}else{
			var portada = document.querySelector("#cover_preview");
			if( portada  ) portada.parentNode.removeChild(portada);
		}
	}
	appendPortada();
	portadacampo.addEventListener("blur", function(){
		appendPortada();
	});
}
