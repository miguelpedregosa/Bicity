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

 echo "Leyendo la información de las estaciones de bicicletas de sevilla";
 
 if(function_exists('curl_init')){
	 //Puedo utilizar CURL para leer la información de las estaciones
	 $ch = curl_init("http://www.sevici.es/service/carto");
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 curl_setopt($ch, CURLOPT_HEADER, 0);
	 $data = curl_exec($ch);
	 curl_close($ch);	 
	 //parseo los datos con SimpleXml
	 $doc = new SimpleXmlElement($data, LIBXML_NOCDATA);
	 $estaciones = $doc->markers->marker;
	 
	 foreach($estaciones as $estacion):		
		$actual_date = date('d/m/Y H:i:s');		
		$atributos = $estacion->attributes();
		$datos_estacion = array(
			'name'=>(string)$atributos->name,
			'number'=>intval((string)$atributos->number),
			'address'=>(string)$atributos->address,
			'fulladdress'=>(string)$atributos->fullAddress,
			'latitud'=>floatval((string)$atributos->lat),
			'longitud'=>floatval((string)$atributos->lng),
			'open'=> ((string)$atributos->open == '0' ? false : true),
			'bonus'=>((string)$atributos->bonus == '0' ? false : true),
			'city'=> Text::slug('Sevilla')
		);
		echo "Procediendo a guardar en Base de datos la información de la estación ".$datos_estacion['name']." de ".$datos_estacion['city']."\n";
		//guardo la estación en la base de datos
		//compruebo que la estación número x no esté en el sistema
		$cursor = $bicity->findOne(array('number' => $datos_estacion['number']));		
		if($cursor!=NULL){
			//actualizo
			$datos_estacion['modificado']=$actual_date;		
			$newdata = array('$set' => $datos_estacion);
			$bicity->update(array('number' => $datos_estacion['number']), $datos_estacion);
			echo '- Se ha actualizado la estación '.$datos_estacion['name']."\n";
		}
		else{
			//inserto
			$datos_estacion['creado']=$actual_date;		
			$datos_estacion['modificado']=$actual_date;		
			$bicity->insert($datos_estacion);
			echo '- Se ha insertado la estación '.$datos_estacion['name'].' con el ID: ' . $datos_estacion['_id']."\n";
		}
	 endforeach; 
 }
 else{
	 echo "No voy a poder leer la información de las estaciones";
 }

