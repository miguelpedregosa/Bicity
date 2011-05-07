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

require_once 'config.php';
define('ROOT', dirname(__FILE__));
define('PATH_TOOLS', ROOT.'/tools/');
define('PATH_PAGES', ROOT.'/pages/');
define('PATH_CLASSES', ROOT.'/classes/');
define('PATH_LIBS', ROOT.'/libs/');
define('PATH_TMP', ROOT.'/tmp/');
define('PATH_AJAX', ROOT.'/ajax/');

//Establecemos el objeto de Mongo para el almacen de datos
try
{
	//Revisar esta parte con un servidor Mongo con clave
$mongo_store = new Mongo("mongodb://{".$configuracion['mongo_user']."}:{".$configuracion['mongo_password']."}@".$configuracion['mongo_host']);
$mongo_db = $mongo_store->selectDB($configuracion['mongo_store']);
}
catch (Exception $e)
{
	$mongo_store = new Mongo($configuracion['mongo_host'].":27017", array("persist" => "x"));
	$mongo_db = $mongo_store->selectDB($configuracion['mongo_store']);
}

//si está activo el debub cargamos algunas herramientas como krumo

if($configuracion['debug'])
{
	require_once PATH_TOOLS.'krumo/class.krumo.php';
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('display_errors','On');
}
else
{
	error_reporting(E_ALL);
	ini_set('log_errors' , '1');
	ini_set('error_log',PATH_TMP.'php_errors.log');
	ini_set('display_errors','0');
}

//Cargo el motor de plantillas H2O
require_once PATH_TOOLS.'h2o/h2o.php';

//Cargamos todas las librerías que estén en la carpeta Libs
$libs_dir = opendir(PATH_LIBS);
while($archivo=readdir($libs_dir))
{
   if(!is_dir($archivo) && $archivo!="." && $archivo!="..")
   {
           //Solo cargo los archivos que comienzan con lib_ y terminan con .php
           $partes_nombre = explode('.', $archivo);
           if(end($partes_nombre) != 'php')
				continue;
				
		   $partes_nombre = explode('_', $archivo);
           if($partes_nombre[0] != 'lib')
				continue;
			
			require_once PATH_LIBS.$archivo;
    }
}

//Cargamos todas las clases que estén en la carpeta classes

$class_dir = opendir(PATH_CLASSES);
while($archivo=readdir($class_dir))
{
   if(!is_dir($archivo) && $archivo!="." && $archivo!="..")
   {
           //Solo cargo los archivos que comienzan con class_ y terminan con .php
           $partes_nombre = explode('.', $archivo);
           if(end($partes_nombre) != 'php')
				continue;
				
		   $partes_nombre = explode('_', $archivo);
           if($partes_nombre[0] != 'class')
				continue;
			
			require_once PATH_CLASSES.$archivo;
    }
}

//Ahora cargamos el directorio de templates 
define('DEVICE_TYPE', 'mobile'); //En un futuro se detectará el tipo de dispositivo
define('PATH_TEMPLATE', ROOT.'/templates/'.$configuracion['template'].'/'.DEVICE_TYPE.'/');

//Ahora defino url para tenerlas siempre a mano, luego serán pasadas a las templates
define('URL_ROOT', $configuracion['http_root']);
define('URL_JS', URL_ROOT.'/js/');
define('URL_CSS', URL_ROOT.'/css/');
define('URL_IMAGES', URL_ROOT.'/images/');
define('URL_AJAX', URL_ROOT.'/ajax/');

define('URL_THEME', URL_ROOT.'/templates/'.$configuracion['template'].'/'.DEVICE_TYPE.'/');
define('URL_THEME_CSS', URL_THEME.'css/');
define('URL_THEME_IMAGES', URL_THEME.'images/');
