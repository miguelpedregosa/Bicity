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

require_once 'init.php';

//Cargando las variables GET y POST después de pasarlas por un filtro de validación
$GET = Input::_GET();
$POST = Input::_POST();
$SERVER = Input::_SERVER();

//Llegados a este punto tengo cargadas las clases, las librerías y las herramientas que voy a necesitar

//Vamos a parsear la url para ver que page tengo que cargar y con que parametros
$url = Routing::URI_route($SERVER);

//Si es una ciudad tengo que comprobar que existe en la base de datos antes de seguir
if($url['ciudad'] == true)
{
	//Compruebo si la ciudad está en el sistema dada de alta
	$ciudad = $url['page'];
	$coleccion = $mongo_db->ciudades;
	$mongo_ciudad = $coleccion->findOne(array('slug' => $ciudad));

	if($mongo_ciudad['slug'] == $ciudad)
	{
		$configuracion['ciudad'] = $ciudad;
		//La ciudad existe en la BD, dependiendo del método cargo una pagina u otra
		if($url['function'] == 'estacion')
		{
				$page = 'estacion';
				$function = 'index';
		}
		else
		{
				$page = $ciudad;
				$function = $url['function'];
		}
	}
	else
	{
		//La ciudad no existe en la BD
		$page = 'error';
		$function = 'e404';
	}
}
else
{
	//Si no es una ciudad en la URL debe venir que se debe cargar
	$page = $url['page'];
	$function = $url['function'];
}
//Cargo la lógica de los datos que necesite, según la URL

if(file_exists(PATH_PAGES.$page.'.php'))
{
require_once PATH_PAGES.$page.'.php';
$page_class = ucwords($page).'Page';

$dispatch = new $page_class();

if(method_exists($dispatch, $function))
{
	$datos = call_user_func_array(array($dispatch,$function),$url['params']);
}
else
{
	//Aqui cargamos una pagina de error desconocido
	require_once PATH_PAGES.'error.php';
	$page = 'error';
	$function = 'e404';
	//Cargo la logica de las página de error por si se quiere ejecutar algo
	$page_class = ucwords($page).'Page';
	$dispatch = new $page_class();
	$datos = call_user_func_array(array($dispatch,$function),$url);

}

}
else
{
	//Aqui cargamos una pagina de error desconocido
		require_once PATH_PAGES.'error.php';
		$page = 'error';
		$function = 'e404';
		//Cargo la logica de las página de error por si se quiere ejecutar algo
		$page_class = ucwords($page).'Page';
		$dispatch = new $page_class();
		$datos = call_user_func_array(array($dispatch,$function),$url);
}


//krumo($page);
//krumo($function);
//die;

//Por último cargo la plantilla correspondiente con dichos datos y la renderizo
$page = new Template($page,$function, $datos);
//Cargo los datos del tiempo para Sevilla de momento
$ciudad = new City("Sevilla");
$tiempo = $ciudad->getMeteo();
$weather = array();
$weather['tiempo_maxima'] = $tiempo['temperatura_maxima'];
$weather['tiempo_minima'] = $tiempo['temperatura_minima'];
$weather['tiempo_imagen'] = $tiempo['sky_code'];
$page->set_data($weather, 'data');		
//El último paso es renderizar la plantilla al navegador		
$page->render_template();
