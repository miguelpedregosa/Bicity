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

class Consumos{
	public static function getPreciosGasolina(){
		global $mongo_db;
		$bicity = $mongo_db->gasolineras;
		$gasolineras=null;
		
		$cursor = $bicity->findOne(array('fecha' => date('d/m/Y')));
		if($cursor != null){
			$gasolineras=array(
			'sp95'=>$cursor['sp95'],
			'sp98'=>$cursor['sp98'],
			'diesel'=>$cursor['diesel'],
			'fecha'=>date('d/m/Y')
			);
		}
		else{
			$ayer=date('d/m/Y', mktime(0,-1,0,date('m'),date('d'),date('Y')));
			$cursor = $bicity->findOne(array('fecha' => $ayer));
			if($cursor != null){
				$gasolineras=array(
				'sp95'=>$cursor['sp95'],
				'sp98'=>$cursor['sp98'],
				'diesel'=>$cursor['diesel'],
				'fecha'=>$ayer
				);
			}
		}
		return $gasolineras;
	}
	
	public static function getGastoGasolina($kilometros){
		global $configuracion;
		global $mongo_db;
		$bicity = $mongo_db->consumos;
		
		$precio = Consumos::getPreciosGasolina();
		$consumption = null;
		
		if($precio != null){		
			$cursor = $bicity->findOne(array('fecha' => date('d/m/Y')));
			if($cursor != null){
				$media = $cursor['media'];//litros a los 100Km
				$consumption=array(
					'sp95'=>array('litros'=>floatval(($kilometros*$media)/100),'euros'=>round(floatval((($kilometros*$media)/100)*$precio['sp95']),2)),
					'sp98'=>array('litros'=>floatval(($kilometros*$media)/100),'euros'=>round(floatval((($kilometros*$media)/100)*$precio['sp98']),2)),
					'diesel'=>array('litros'=>floatval(($kilometros*$media)/100),'euros'=>round(floatval((($kilometros*$media)/100)*$precio['diesel']),2))
				);
			}
			else{
				$ayer=date('d/m/Y', mktime(0,-1,0,date('m'),date('d'),date('Y')));
				$cursor = $bicity->findOne(array('fecha' => $ayer));
				if($cursor != null){
					$consumption=array(
					'sp95'=>array('litros'=>floatval(($kilometros*$media)/100),'euros'=>round(floatval((($kilometros*$media)/100)*$precio['sp95']),2)),
					'sp98'=>array('litros'=>floatval(($kilometros*$media)/100),'euros'=>round(floatval((($kilometros*$media)/100)*$precio['sp98']),2)),
					'diesel'=>array('litros'=>floatval(($kilometros*$media)/100),'euros'=>round(floatval((($kilometros*$media)/100)*$precio['diesel']),2))
					);
				}
			}
		}
		
		return $consumption;
	}
	
	public static function getEmisiones($kilometros){
		global $configuracion;
		global $mongo_db;
		$bicity = $mongo_db->emisiones;
		
		$emisiones = null;
		
		$cursor = $bicity->findOne(array('fecha' => date('d/m/Y')));
		if($cursor != null){
			$media = $cursor['media'];//litros a los 100Km
			$emisiones = floatval($media*$kilometros);
		}
		
		return $emisiones;
	}
}
