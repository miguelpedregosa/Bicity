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

class GpsPage
{
	public function index($params=null)
	{
		global $POST;
		global $configuracion;
		
		//krumo($POST);
		
		return true;
	}
	
	public function ruta($params=null)
	{
		global $POST;
		global $configuracion;
		
		//krumo($POST);
		
		$latitud = $POST['latitud'];
		$longitud = $POST['longitud'];
		$latitud_hasta = $POST['latitud_hasta'];
		$longitud_hasta = $POST['longitud_hasta'];
		
		if(empty($latitud) OR empty($longitud) OR empty($latitud_hasta) OR empty($longitud_hasta)){
			header("Location: ".$configuracion['http_root'].'/gps/error/');
			exit();
		}
		
		$cercana_origen = new Search();
		$origen = ($cercana_origen->cercanas($latitud, $longitud, null, 1)); //ojo es un array en otro
		$salida = new Station($origen[0]['city'],$origen[0]['number']);
		//krumo($salida->to_Array());
		$cercana_destino = new Search();
		$destino = ($cercana_destino->cercanas($latitud_hasta, $longitud_hasta, null, 1)); //ojo es un array en otro
		$llegada = new Station($destino[0]['city'],$destino[0]['number']);
		//krumo($llegada->to_Array());
		$punto_salida = array(
			'latitud'=>$latitud,
			'longitud'=>$longitud
		);
		//krumo($punto_salida);
		$punto_llegada = array(
			'latitud'=>$latitud_hasta,
			'longitud'=>$longitud_hasta
		);
		//krumo($punto_llegada);
		
		//krumo(floatval(Geo::distancia_haversin($latitud,$latitud_hasta,$longitud,$longitud_hasta)/1000));
		$kilometros = (floatval(Geo::distancia_haversin($latitud,$latitud_hasta,$longitud,$longitud_hasta)/1000));
		
		$consumos = array(
		'consumo'=>Consumos::getGastoGasolina($kilometros),
		'emisiones' => Consumos::getEmisiones($kilometros)
		);
		
		$precios = Consumos::getPreciosGasolina();
		//krumo($consumos);
		
		$output = array(
		'salida'=>$salida->to_Array(),
		'llegada'=>$llegada->to_Array(),
		'punto_salida'=>$punto_salida,
		'punto_llegada'=>$punto_llegada,
		'consumos'=>$consumos,
		'precios'=>$precios
		);
		return $output;
	}
	
	public function error($params=null)
	{
		return true;
	}
	
	
}
