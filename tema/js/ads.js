function rand (min, max) {
	var argc = arguments.length
	if (argc === 0) {
		min = 0;
		max = 2147483647;
	}else if (argc === 1) {
		throw new Error('Warning: rand() expects exactly 2 parameters, 1 given');
	}
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
function cargarmaspublic() {
	function e() {
		var listcod = [
			'<script src="'+SITIO_URL+'/tema/js/opc1.js"></script>',
			'<script src="'+SITIO_URL+'/tema/js/opc2.js"></script>',
			'<script src="'+SITIO_URL+'/tema/js/opc3.js"></script>'
		];
		return listcod[rand(0,3)];
	}

	function t() {
		var t = document.createElement("div");
		t.id = "capanegra", t.style.backgroundColor = "black", t.style.minWidth = "100%", t.style.minHeight = "100%", t.style.position = "fixed", t.style.left = 0, t.style.top = 0;
		var n = document.createElement("div");
		n.id = "publicont", n.style.textAlign = "center", n.style.margin = "16% auto 0", n.style.width = "728px";
		var r = document.createElement("div");
		r.innerHTML = 'Click en la X para cerrar o Esperar <span id="publitimer">15</span> segundos', r.style.color = "#fff", r.style.marginBottom = "15px", n.appendChild(r);
		var i = document.createElement("div");
		i.id = "contbtncerrar", i.style.position = "absolute", i.style.textAlign = "right", i.style.width = "728px", i.style.margin = "0 auto";
		var a = document.createElement("button");
		return a.id = "btncerrarpubli", a.innerHTML = "X", a.setAttribute("style", "background-color: #fff;border: medium none;border-radius: 100%;display: inline-block;font-size: 20px;font-weight: bold;line-height: 100%;padding: 4px;"), i.appendChild(a), n.appendChild(i), n.innerHTML += e(), t.appendChild(n), t
	}

	function n() {
		var e = 15;
		i = setInterval(function() {
			e > 0 ? (--e, document.querySelector("#publitimer").innerHTML = e) : (clearInterval(i), r())
		}, 1e3)
	}

	function r() {
		clearInterval(i), document.body.removeChild(document.querySelector("#capanegra"))
	}
	var i;
	document.body.appendChild(t()), n();
}
document.addEventListener("DOMContentLoaded", function() {
	function e(e) {
		var t = document.cookie.match("(^|;) ?" + e + "=([^;]*)(;|$)");
		return t ? t[2] : null
	}

	function t(e, t, n) {
		var r = new Date;
		r.setTime(r.getTime() + 864e5 * n), document.cookie = e + "=" + t + ";path=/;expires=" + r.toGMTString()
	}
	var n = e("utilPubliBanner");
	n || t("utilPubliBanner", (new Date).getTime(), 1);
	var r = (setInterval(function() {
		console.log("Func1");
		n = e("utilPubliBanner");
		var r = (new Date).getTime();
		n + 36e5 >= r && (t("utilPubliBanner", (new Date).getTime(), 1), cargarmaspublic())
	}, 6e4), setInterval(function() {
		console.log("Func2");
		n = e("utilPubliBanner");
		var t = (new Date).getTime();
		n + 3e5 >= t && (cargarmaspublic(), clearInterval(r))
	}, 6e4))
});