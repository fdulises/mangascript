<?php
	/*
	* Mictlan Manga CMS - Todos los derechos reservados
	* V Alpha 16.08.05
	* Desarrollado por Ulises Rendón - http://debred.com - ulises@debred.com
	*/
	$lista_final = array();
	$html1 = "<article class=\"gd-100\"><a href=\"";
	$html2 = "\"><h3>";
	$html3 = "</h3></a></article>";

	$lista_articulos = $mt->getEntrada(array(
		'columnas' => array(
			'e.titulo as articulo_titulo',
			'enlace as articulo_enlace',
		),
		'tipo' => 2,
		'orden' => 'e.titulo',
		'disp' => 'ASC',
	));
	
	function listadoAlfabetico($lista) {
		$html = '';
		global $html1, $html2, $html3;
		foreach (range('A', 'Z') as $letter) {
			$iniciales[] = $letter;
			if ($letter=='C') {$iniciales[] = 'Ç';}
			if ($letter=='N') {$iniciales[] = 'Ñ';}
		}

		$i=0;
		$eliminar = array();
		while ($i<count($iniciales)) {
			$inicial = $iniciales[$i];

			$htmlLetra='';
			$j=0;
			$k=0;
			while ($j<count($lista)) {
				if ($lista[$j]['articulo_titulo']{0}==$inicial or $lista[$j]['articulo_titulo']{0}==strtolower($inicial)) {
					$htmlLetra .= "{$html1}{$lista[$j]['articulo_enlace']}{$html2}{$lista[$j]['articulo_titulo']}{$html3}";
					$eliminar[] = $j;
					$k++;
				}
				$j++;
			}

			// Si hay elementos con la inicial actual se eliminan del array y se genera el HTML
			if ($k>0) {
				rsort($eliminar);
				$l=0;
				while ($l<count($eliminar)) {
					$lista = quitarElemento($lista, $eliminar[$l]);
					$l++;
				}
				$html .= '<h2 class="gd-100">'.$inicial.'</h2>'.$htmlLetra;
			}
			$eliminar = array();
			$i++;
		}

		// Con el resto de elementos se saca el apartado del 0 al 9
		if (count($lista)>0) {
			$htmlLetra='';
			$m=0;
			while ($m<count($lista)) {
				$selTag='span';
				$htmlLetra .= "{$html1}{$lista[$m]['articulo_enlace']}{$html2}{$lista[$m]['articulo_titulo']}{$html3}";
				$m++;
			}
			$html .= '<h2 class="gd-100">0-9</h2>'.$htmlLetra;
		}

		return $html;
	}

	function quitarElemento($elementos, $indice) { 
		if (is_array($elementos)) {
			unset($elementos[$indice]);
			if(gettype($indice)!="string") {
				$listaTemporal=array(); 
				$i=0; 
				foreach ($elementos as $value) {
					$listaTemporal[$i]=$value;
					$i++;
				}
				$elementos=$listaTemporal;
			} 
			return $elementos;
		} 
		else return false;
	}
	
	$mt->plantilla->setEtiqueta('lista_articulos', listadoAlfabetico($lista_articulos));
	
	$mt->plantilla->setBloque('lista_articulos', $lista_final);
	$mt->plantilla->display('tpl/letra');
