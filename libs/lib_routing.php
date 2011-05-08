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
class Routing
{
	public static function URI_to_array($SERVER)
	{
	
	$uri_nav = strtolower($SERVER['REQUEST_URI']);
	$server_uri = preg_replace('/\?(.)*/','',$uri_nav );
	$url_args = preg_split('/\/+/', $server_uri);
	array_shift($url_args);
	if(end($url_args) == '')
		array_pop($url_args);
	return $url_args;
	
	}

	public static function URI_route($SERVER)
	{
		$context = array();
		$partes = Routing::URI_to_array($SERVER);
		$context['ciudad'] = false;
		
		if($partes[0] == '')
		{
				$context['page'] = 'home';
				$context['function'] = 'index';
				$context['params'] = false;
				
		}
		else
		{
			switch($partes[0])
			{
				case 'test':
					$context['page'] = 'test';					
				break;
				
				case 'buscador':
					$context['page'] = 'buscador';	
				break;
				
				case 'search':
					$context['page'] = 'search';	
				break;
				
				case 'faq':
					$context['page'] = 'faq';	
				break;
				
				case 'contacto':
					$context['page'] = 'contacto';	
				break;
				
				case 'geo':
					$context['page'] = 'geo';	
				break;
				
				case 'gps':
					$context['page'] = 'gps';	
				break;
				
				case 'vehiculo':
					$context['page'] = 'vehiculo';	
				break;
				
				default:
					$context['page'] = Input::validate_string($partes[0]); //Si no la conozco devuelvo para que se procese más arriba, será una ciudad
					$context['ciudad'] = true;
				break;
					
			}
			$function = 'index';
			if(isset($partes[1]))
				{
					$function = Input::validate_string($partes[1]);
				}	
			$context['function'] = $function;
			$params = false;
			if(isset($partes[2]))
				{
				$params = array();
					for($i = 2; $i < count($partes); $i++)
					{
						$params[] = $partes[$i];
					}
				}
			$context['params'] = $params;
			
		}
		
		
		return $context;
	}

}
