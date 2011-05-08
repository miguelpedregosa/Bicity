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

/* Script que se encarga de leer los datos de las estaciones de bicicletas de Sevilla */
 
 require_once '../../init.php';
 //$m = new Mongo(); // connect
 //$db = $m->selectDB("bicity");
 
 //Selecciono la colección sobre la que voy a trabajar
 $bicity = $mongo_db->estaciones;
 
 //me traigo todas las estaciones de la base de datos;
 $cursor = $bicity->find();
 
 foreach($cursor as $estacion){
	 
	 //Instancio una estación para obtener la información de la misma
	 $e = new Station('Sevilla', $estacion['number']);
	 $info = $e->getStationInfo();
	 
	 print_r($info);
	 $datos_estacion = array(
		'available'=>$info['available'],
		'free'=>$info['free'],
		'total'=>$info['total'],		
		'ticket'=>$info['ticket'],
		'timestamp' => time()
	 );
	 
	 $newdata = array('$set' => $datos_estacion);
	 $bicity->update(array('number' => $e->getNumber()), $newdata);
	 echo '- Se ha actualizado la estación '.$e->getNumber()."\n";
 }
