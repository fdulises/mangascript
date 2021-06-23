var mw = function(conf){
    var mwid = "mw-"+getRand();
    var newmw;
    var newscreen;

    function createElement(clase,tipo,texto){
        var elemento = document.createElement(tipo);
        elemento.setAttribute('class',clase);
        elemento.innerHTML = texto;
        return elemento;
    }

    function removeModal(){
        var modal = document.getElementById(mwid);
        newscreen = document.getElementById(mwid+'-screen');
        modal.setAttribute('data-estado','cerrado');
        newscreen.setAttribute('data-estado','cerrado');

        setTimeout(function(){
            document.querySelector("body").removeChild(newscreen);
        }, 500);
    }

    function createClose(){
        var close = createElement('mw-close','button','X');
        close.addEventListener('click',removeModal);
        return close;
    }

    function createHeader(text){
        var btnClose = createClose();
        var header = createElement('mw-header','div',text);
        header.appendChild(btnClose);
        return header;

    }

    function createBody(text){
        return createElement('mw-body','div',text);

    }

    function createBox(){
        var box = createElement('mw-box','div',"");
        box.setAttribute('id',mwid);
        box.appendChild(createHeader(conf.header));
        box.appendChild(createBody(conf.body));
		box.addEventListener("click", function(e){
			e.stopPropagation();
		});
        return box;
    }

    function getRand(){
        var nran = 0;
        nran = Math.ceil(Math.random()*100000);
        return nran;
    }
    function insert(){
        var screen = createScreen();
        screen.appendChild(newmw);
        document.body.appendChild(screen);
    }

    function createScreen(){
        var screen = createElement('mw-screen','div','');
        screen.setAttribute('id',mwid+'-screen');
		screen.addEventListener('click',removeModal);
        return screen;
    }

    function init(){
        newmw = createBox();
        return {
            mw: newmw,
            insert: insert,
			remove: removeModal
        };
    }
    return init();
};
