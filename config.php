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

//Fichero de configuración de la aplicación, define el acceso a la BD y otras variables

$configuracion = array(); //array de configuracion

$configuracion['mongo_host'] = 'localhost';
$configuracion['mongo_user'] = null;
$configuracion['mongo_password'] = null;
$configuracion['mongo_store'] = 'bicity';


$configuracion['analytics_id'] = 'UA-23187702-1';

$configuracion['app_name'] = 'Bicity';
$configuracion['consumo_medio'] = 8.57348645; //Litros a los 100 km en ciudad


$configuracion['template'] = 'bicity';
$configuracion['template_cache'] = false;

$configuracion['debug'] = true;

//Cambiar solo si no detecta bien la url
$configuracion['http_root'] = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'] : "http://".$_SERVER['SERVER_NAME'];
$configuracion['http_root'] = rtrim($configuracion['http_root'], '/');
