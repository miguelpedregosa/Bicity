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
 require_once "../../init.php";
 
 function calcular_consumo_medio()
 {
	global $mongo_db;
	$coches = $mongo_db->coches;
	
	$a = $coches->find();
	$suma=0;
	$numero=0;
	
	foreach($a as $coche)
	{
		$suma=$suma + $coche["consumo"];
		$numero++;
	}
	
	return number_format($suma/$numero,3);
 
 }
 
 function insertar_consumo()
 {
	$fecha= date ( "d/m/Y" ,time ());
	$consumo=array();
	$consumo['fecha']=$fecha;
	$consumo['media']=calcular_consumo_medio();
	
	global $mongo_db;
	$consumos = $mongo_db->consumos;
	
	if(obtener_datos($fecha) == NULL)
	/*Si no existen ya datos de consumo sobre la fecha*/
	{
		$consumos->insert($consumo);
	}
	else
	/*Si existe actualizamos los datos*/
	{
		$filter = array('fecha'=>$fecha);
		$options['multiple'] = false;
		$consumos->update($filter, $consumo, $options);
	}
 }
 
 function obtener_datos($fecha)
 {
	global $mongo_db;
	
	$filter = array('fecha'=>$fecha);
	$consumos = $mongo_db->consumos;
	$consumos = $consumos->findOne($filter);
	
	return $consumos;
 }
 
 insertar_consumo();
 