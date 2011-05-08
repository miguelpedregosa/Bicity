<?php
/*
 * Proyecto Bicity - Sistema público de prestamo y alquiler de bicicletas
 * 					AbreDatos 2011 (7 y 8 de mayo)
 * 
 * Código fuente publicado con licencia open source GNU AFFERO GENERAL PUBLIC LICENSE v3
 * 
 * Proyecto desarrollado por:
 *  - Miguel Ángel Pedregosa (@miguelpedregosa)
 *  - Josen Antonio Lopez (@JoseAntonio1982)
 *  - Cesar Santiago (@csm_web)
 *  - Abelardo Aguado (@aBeholic)
 * 
 */

class SearchPage
{
	function index($params=null)
	{
		return true;
	}
	
	function resultados($params=null)
	{		
		global $POST;
		
		if(is_numeric($POST['texto'])){
			//compruebo que el número corresponde a una parada
			$e = new Station('Sevilla',$POST['texto']);
			if($e->getHref()!='#'){
				header('Location: '.$e->getHref());
				exit();
			}			
		}
		$direccion = $POST['texto'];
		$direccion .= ", Sevilla";
		
		$posicion = new Position($direccion);
		$datos_posicion = $posicion->to_Array();
		
		$busqueda = new Search();
		$resultados = $busqueda->cercanas($datos_posicion['latitud'], $datos_posicion['longitud'], null,5);
		$datos = array();
		if(empty($resultados)){
			$output = array(
			'direccion'=>$POST['texto'],
			'vacio'=>1
			);
		}
		else{
			foreach($resultados as $resultado){
				$estacion = new Station('Sevilla',$resultado['number']);
				$info = ($estacion->getStationInfo());
				$datos[]=array(
				'number'=>$resultado['number'],
				'city'=>$resultado['city'],
				'distancia'=>$resultado['distancia'],
				'available'=>$info['available'],
				'free'=>$info['free'],
				'total'=>$info['total'],
				'enlace'=>$estacion->getHref()
				);
			}	
		
			$output = array(
				'direccion'=>$POST['texto'],
				'resultados'=>$datos,
				'vacio'=>0
			);
		}
		return $output;
	}
}
