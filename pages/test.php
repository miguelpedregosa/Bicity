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

class TestPage
{
	function index($param1=null, $param2 = null)
	{
		krumo($param1);
		krumo($param2);
		$exit = array('probando' => 'OK');
		return $exit;
	}
	function buscar()
	{
		krumo("Busqueda de prueba: cercanas");
		$busqueda = new Search();
		//$res = $busqueda->all(null, array('number' => 1), 2);
		//foreach($res as $doc)
		//{
			//krumo($doc);
		//}
		$res = $busqueda->cercanas(37.4129235511, -5.98890593824, 400, 10);
		krumo($res);
		
	}
	
}
