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

class SevillaPage
{
	function index($param1 = null)
	{
		global $mongo_db;
		$bicity = $mongo_db->estaciones;
		
		$consumos = Consumos::getPreciosGasolina();
		$estaciones = array();
		$cursor = $bicity->find();
		
		foreach($cursor as $estacion){
			$estaciones[]=array(
				'number'=>$estacion['number'],
				'address'=>$estacion['address'],
				'available'=>$estacion['available'],
				'free'=>$estacion['free'],
				'latitud'=>$estacion['latitud'],
				'longitud'=>$estacion['longitud']
			);
		}

		$output = array(
			'estaciones'=>$estaciones,
			'consumos'=>$consumos
		);
		return $output;
	}
}
