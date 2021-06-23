<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Facade para la seccion pedidos
	*/
	/*
	* Metodo para crear pedidos
	*/
	function setPedido($nombre){
		if( !empty($nombre) ){
			$nombre = dbConnector::escape($nombre);
			$fecha = date('Y-m-d');
			$query = "INSERT INTO mt_pedidos(nombre, fecha) VALUES('{$nombre}','{$fecha}')";
			$resultado = dbConnector::sendQuery($query);
			if( $resultado ) return 1;
		}
		return 0;
	}

	/*
	* Metodo para obtener pedidos
	*/
	function getPedidos(){
		$query = "SELECT
			id as pedido_id,
			nombre as pedido_nombre,
			estado as pedido_estado,
			fecha as pedido_fecha
		FROM mt_pedidos ORDER BY fecha DESC LIMIT 50";
		$resultado = dbConnector::query($query);
		if( $resultado ) return $resultado;
		return array();
	}

	if( isset( $_GET['pedido'] ) ):
		if( isset( $_POST['pedido'] ) ):
			$validacaptcha = extras::validaReCaptcha(RECAPTCHA_SECRET_KEY, $_POST['captchaResponse']);
			if( $validacaptcha ) echo setPedido($_POST['pedido']);
			else echo 0;
		else: echo 2;
		endif;
	exit();endif;

	$lista_pedidos = getPedidos();
	foreach ($lista_pedidos as $k => $v) {
		$lista_pedidos[$k]['pedido_estado'] = ( 1 == $v['pedido_estado'] ) ? 'Si' : 'En proceso';
	}
	$mt->plantilla->setBloque('lista_pedidos', $lista_pedidos);

	$mt->plantilla->display('tpl/pedidos');
