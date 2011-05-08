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
 
 function calcular_emision_medio()
 {
	global $mongo_db;
	$coches = $mongo_db->coches;
	
	$a = $coches->find();
	$suma=0;
	$numero=0;
	
	foreach($a as $coche)
	{
		$suma=$suma + $coche["emisiones"];
		$numero++;
	}
	
	return number_format($suma/$numero,3);
 
 }
 
 function insertar_emision()
 {
	$fecha= date ( "d/m/Y" ,time ());
	$emision=array();
	$emision['fecha']=$fecha;
	$emision['media']=calcular_emision_medio();
	
	global $mongo_db;
	$emisiones = $mongo_db->emisiones;
	
	if(obtener_datos($fecha) == NULL)
	/*Si no existen ya datos de emision sobre la fecha*/
	{
		$emisiones->insert($emision);
	}
	else
	/*Si existe actualizamos los datos*/
	{
		$filter = array('fecha'=>$fecha);
		$options['multiple'] = false;
		$emisiones->update($filter, $emision, $options);
	}
 }
 
 function obtener_datos($fecha)
 {
	global $mongo_db;
	
	$filter = array('fecha'=>$fecha);
	$emisiones = $mongo_db->emisiones;
	$emisiones = $emisiones->findOne($filter);
	
	return $emisiones;
 }
 
 insertar_emision();