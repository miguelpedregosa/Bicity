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
 global $mongo_db;
 $coches = $mongo_db->coches;
 
 //Leemos todos los html del directorio coches
 $ruta = "./coches/";
 if($d = opendir($ruta))
 {
	while (($archivo = readdir($d)) !== false)
	{
		if (substr($archivo, strlen($archivo) - 5) == '.html')
		//Solo lee los archivos .html
		{
			$html=file_get_contents($ruta.$archivo);
			
			if(preg_match_all('/<td class="principal" align="left">.*<\/label><\/td>/', $html, $coincidencias))
			//guardamos cada linea que contiene los datos de coches
			{
				foreach($coincidencias[0] as $linea)
				{
					$coche = array("modelo"=>"", "consumo"=>0, "emisiones"=>0,"categoria"=>'X');
					$trozos=  explode("</td>",$linea);
					//MODELO
					$coche['modelo']= strip_tags($trozos[0]);
					$coche['consumo']= floatval(str_replace(",",".",strip_tags($trozos[1])));
					$coche['emisiones']= floatval(str_replace(",",".",strip_tags($trozos[2])));
					if(preg_match("/coches[\w]+\.gif/",$trozos[3],$categoria))
					{
						$coche['categoria']=$categoria[0][7];
					}
					print_r($coche);
					$coches->insert($coche);
				}
			}
		}
	}
	closedir($d);
 }