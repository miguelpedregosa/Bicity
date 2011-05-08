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

class EstacionPage
{
	function index($estacion = null)
	{
		global $url;
		$ciudad = $url['page'];
		$estacion = new Station($ciudad, $estacion);
		$datos = $estacion->to_array();
		$estacion_var = array();
		if($datos['name'] == null)
		{
			$error_page = URL_ROOT.'/error/404/';
			header('Location: '.$error_page);
			exit();
		}
		$estacion_var['info'] = $datos;
		$posicion = $estacion->getPosition();
		$estacion_var['location'] = $posicion->to_array();
		$estacion_var['bicicletas'] = $estacion->getStationInfo();	
		
		//krumo($estacion_var);
		//die;
		return $estacion_var;	
	}
	
}
