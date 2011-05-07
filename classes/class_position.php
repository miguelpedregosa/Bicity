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

class Position
{
	protected $latitud;
	protected $longitud;
	protected $direccion;
	protected $tipo_coordenadas;
	
	
	public function __construct($param=null)
	{
		global $mongo_db;
		$bicity = $mongo_db->estaciones;
		
		if(is_string($param))//estoy pasando la direccion
		{
			//le digo al sr. google que me de una dirección buena
			$direccion = urlencode($param);
			$url_info = "http://maps.google.com/maps/api/geocode/json?address=".$direccion."&sensor=false";
			$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
			curl_setopt($ch, CURLOPT_URL, $url_info);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				
			$resultado = utf8_encode(curl_exec($ch));
			$error = curl_error($ch);
			$json = json_decode($resultado);
			
			$this->direccion = $json->results[0]->formatted_address;
			$this->latitud = ($json->results[0]->geometry->location->lat);
			$this->longitud = ($json->results[0]->geometry->location->lng);
			$this->tipo_coordenadas = ($json->results[0]->geometry->location_type);
		}
		elseif (is_array($param))//estoy pasando latitud, longitud
		{
			$coordenada = $param['latitud'].','.$param['longitud'];
	
			$url_info = "http://maps.google.com/maps/api/geocode/json?latlng=".$coordenada."&sensor=false";
			$useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
			curl_setopt($ch, CURLOPT_URL, $url_info);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				
			$resultado = utf8_encode(curl_exec($ch));
			$error = curl_error($ch);
			$json = json_decode($resultado);
			
			$this->direccion = $json->results[0]->formatted_address;
			$this->latitud = ($json->results[0]->geometry->location->lat);
			$this->longitud = ($json->results[0]->geometry->location->lng);
			$this->tipo_coordenadas = ($json->results[0]->geometry->location_type);
		}
	}	
	
	public function to_Array(){
		$posicion = array(
		'latitud'=>$this->latitud,
		'longitud'=>$this->longitud,
		'direccion'=>$this->direccion,
		'tipo_coordenadas'=>$this->tipo_coordenadas
		);
		return $posicion;
	}
	
	public function getLatLon(){
		$latlon=array(
			'latitud'=>$this->latitud,
			'longitud'=>$this->longitud
		);
		return $latlon;
	}
	
	public function getDireccion(){
		return $this->direccion;
	}
	
	public function getTipoCoordenadas(){
		return $this->tipo_coordenadas;
	}
	
}
