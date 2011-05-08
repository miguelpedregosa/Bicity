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
 
 $bicity = $mongo_db->meteo;
 
 //http://www.aemet.es/es/eltiempo/prediccion/localidades/sevilla-41001
 
 echo "Leyendo la información meteorológica de Sevilla\n\n";
 
 if(function_exists('curl_init')){
	 //Puedo utilizar CURL para leer la información de las estaciones
	 $ch = curl_init("http://www.aemet.es/es/eltiempo/prediccion/localidades/sevilla-41001");
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 curl_setopt($ch, CURLOPT_HEADER, 0);
	 $data = curl_exec($ch);
	 curl_close($ch);	 
	 $meteo = array();
	 
	 $cielo = null;
	 $sky_code = null;
	 $precipitaciones = null;
	 $temperatura_maxima = null;
	 $temperatura_minima = null;
	 $viento = null;

	 $patron = '/<td class="borde_r?b"\s?(colspan="2")?><img src="\/imagenes\/gif\/estado_cielo\/[[:digit:]]+\.gif" title="[\w\s]+" alt="[\w\s]+" \/><\/td>/';
	 if(preg_match_all($patron,$data,$cadena)){
		 $cielo = preg_replace('/<td class="borde_r?b"\s?(colspan="2")?><img src="/','',$cadena[0][0]);
		 $cielo = trim(preg_replace('/" title="[\w\s]+" alt="[\w\s]+" \/><\/td>/','',$cielo));
		 $cielo = 'http://www.aemet.es'.$cielo;
		 $sky_code = str_replace('http://www.aemet.es/imagenes/gif/estado_cielo/','',$cielo);
		 $sky_code = str_replace('.gif','',$sky_code);
	 }
	 
	 $patron = '/<td class="borde_rb" colspan="2">[[:digit:]]+\%\&nbsp\;<\/td>/';
	 if(preg_match_all($patron,$data,$cadena)){
		 $precipitaciones=(addslashes(ucfirst(trim(strip_tags(str_replace('&nbsp;','',$cadena[0][0]))))));
	 }

	 $patron = '/<td colspan="2" class="borde_rb" ><span class="texto_rojo">[[:digit:]]+\&nbsp\;<\/span><\/td>/';
	 if(preg_match_all($patron,$data,$cadena)){
		 $temperatura_maxima=(addslashes(ucfirst(trim(strip_tags(str_replace('&nbsp;','',$cadena[0][0]))))));
	 }

	 $patron = '/<td colspan="2" class="borde_rb"><span class="texto_azul">[[:digit:]]+\&nbsp\;<\/span><\/td>/';
	 if(preg_match_all($patron,$data,$cadena)){
		 $temperatura_minima=(addslashes(ucfirst(trim(strip_tags(str_replace('&nbsp;','',$cadena[0][0]))))));
	 }
	 
	 $patron = '/<td (colspan="2")?\s?class="borde_r?b">[[:digit:]]+\&nbsp\;<\/td>/';
	 if(preg_match_all($patron,$data,$cadena)){
		 $viento=(addslashes(ucfirst(trim(strip_tags(str_replace('&nbsp;','',$cadena[0][0]))))));
	 }
	 
	 $meteo['date']=date('dmY');	
	 $meteo['cielo']=$cielo;
	 $meteo['sky_code']=$sky_code;
	 $meteo['precipitaciones']=$precipitaciones;
	 $meteo['temperatura_maxima']=$temperatura_maxima;
	 $meteo['temperatura_minima']=$temperatura_minima;
	 $meteo['viento']=$viento;
	 $meteo['city'] = Text::slug('Sevilla');
	 
	 $cursor = $bicity->findOne(array('date' => $meteo['date']));
	 if($cursor!=NULL){
		//actualizo
		$newdata = array('$set' => $meteo);
		$bicity->update(array('date' => $meteo['date']), $meteo);
		echo '- Se ha actualizado'."\n";
	 }
	 else{
		//inserto
		$bicity->insert($meteo);
		echo '- Se ha insertado'."\n";
	 }
 }
 else{
	 echo "No voy a poder leer la información de las estaciones";
 }
