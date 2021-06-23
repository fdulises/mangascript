<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	/*
	* Archivo de presentacion para la subseccion pedidos
	*/

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
		$resultado = dbConector::query($query);
		if( $resultado ) return $resultado;
		return array();
	}

	function updatePedido($id, $estado){
		$query = "UPDATE mt_pedidos SET estado = '{$estado}' WHERE id = '{$id}'";
		$resultado = dbConector::sendQuery($query);
		if( $resultado ) return $resultado;
		return 0;
	}

	if( isset( $_GET['id'], $_GET['estado'] ) ){
		die(updatePedido( (INT) $_GET['id'], (INT) $_GET['estado'] ));
	}

	$lista_entradas = getPedidos();
	foreach ($lista_entradas as $k => $v) {
		if( $v['pedido_estado'] ){
			$htmlselect = '<option value="0">No</option>';
			$htmlselect .= '<option value="1" selected="selected">Si</option>';
		}else{
			$htmlselect = '<option value="0" selected="selected">No</option>';
			$htmlselect .= '<option value="1">Si</option>';
		}
		$htmlselect = "<select data-id=\"{$v['pedido_id']}\" class=\"pedidos_switch form-in\">".$htmlselect."</select>";
		$lista_entradas[$k]['pedido_switch'] = $htmlselect;
	}
	$plantilla->setBloque('lista_entradas', $lista_entradas, array(
		'entrada_id', 'entrada_titulo', 'entrada_estado', 'entrada_fecha', 'entrada_switch'
	));

	$plantilla->display($plantilla->getHTML('articulo-pedidos'));
