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

class Search
{
	private $_results;
	
	public function __construct($search_string = null)
	{
		$this->_results = array();
	}
	
	public function all($ciudad = null, $order = null, $limit = null)
	{
		global $mongo_db;
		$estaciones = $mongo_db->estaciones;
		if($order == null)
			$this->_results = $estaciones->find(array(), array('number', 'city'));
		else
		{
			$this->_results = $estaciones->find(array(), array('number', 'city'));
			$this->_results->sort($order)->limit($limit);
		}
		return $this->_results;
	}
	
	public function cercanas($lat, $long, $max_distancia = null, $limit = null)
	{
		global $mongo_db;
		$estaciones = $mongo_db->estaciones;
		$distancias = array();
		$resultados=$estaciones->find(array(), array('number', 'city', 'latitud', 'longitud'));
		$resultados->sort(array('number' =>1));
		
		foreach($resultados as $resultado)
		{
			$distancia['number']=$resultado['number'];
			$distancia['city']=$resultado['city'];
			$distancia['distancia']=Geo::distancia_haversin($lat,$resultado['latitud'], $long, $resultado['longitud']);
			
			if($max_distancia != null)
			{
				if($distancia['distancia']<=$max_distancia)
				{
					$distancias[]=$distancia;
				}
			}
			else
			{
				$distancias[]=$distancia;
			}
		}
		$ordenado= Geo::ordenar_vector_distancias($distancias);
		if($limit != null && $limit<= count($ordenado))
		{
			$ordenado_nuevo= array();
			for($i=0;$i<$limit;$i++)
			{
				$ordenado_nuevo[]=$ordenado[$i];
			}
			
			return $ordenado_nuevo;
		
		}else{return $ordenado;}
		
	}
	
	
	
}
