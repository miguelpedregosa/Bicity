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

class City
{
	protected $nombre;
	protected $slug;
	protected $googlename;
		
	public function __construct($param=null)
	{
		global $mongo_db;
		$bicity = $mongo_db->ciudades;
		
		$cursor = $bicity->findOne(array('slug' => Text::slug($param)));		
		if($cursor!=NULL){
			$this->nombre = $cursor['nombre'];
			$this->slug = $cursor['slug'];
			$this->googlename = $cursor['googlename'];
		}
	}	
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getSlug(){
		return $this->slug;
	}
	
	public function getGoogleName(){
		return $this->googlename;
	}
	
	public function getMeteo(){
		global $mongo_db;
		$bicity = $mongo_db->meteo;
		$meteo = null;
		
		$cursor = $bicity->findOne(array('date' => date('dmY')));
		if($cursor != null){
			$meteo=array(
				'cielo'=>$cursor['cielo'],
				'sky_code'=>$cursor['sky_code'],
				'precipitaciones'=>$cursor['precipitaciones'],
				'temperatura_maxima'=>$cursor['temperatura_maxima'],
				'temperatura_minima'=>$cursor['temperatura_minima'],
				'viento'=>$cursor['viento']
			);
		}
		else{
			$ayer=date('dmY', mktime(0,-1,0,date('m'),date('d'),date('Y')));
			$cursor = $bicity->findOne(array('date' => $ayer));
			if($cursor != null){
				$meteo=array(
					'cielo'=>$cursor['cielo'],
					'sky_code'=>$cursor['sky_code'],
					'precipitaciones'=>$cursor['precipitaciones'],
					'temperatura_maxima'=>$cursor['temperatura_maxima'],
					'temperatura_minima'=>$cursor['temperatura_minima'],
					'viento'=>$cursor['viento']
				);
			}
		}
		return $meteo;
	}
}
