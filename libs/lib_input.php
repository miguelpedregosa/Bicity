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

class Input
{
	
public static function get_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_GET[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_input(INPUT_GET, $var_name, FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_input(INPUT_GET, $var_name, FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_input(INPUT_GET, $var_name, FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_input(INPUT_GET, $var_name, FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
	}
		
public static function post_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_POST[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_input(INPUT_POST, $var_name, FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_input(INPUT_POST, $var_name, FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_input(INPUT_POST, $var_name, FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_input(INPUT_POST, $var_name, FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
}

public static function cookie_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_COOKIE[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_input(INPUT_COOKIE, $var_name, FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_input(INPUT_COOKIE, $var_name, FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_input(INPUT_COOKIE, $var_name, FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_input(INPUT_COOKIE, $var_name, FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
}

public static function server_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_SERVER[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_input(INPUT_SERVER, $var_name, FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_input(INPUT_SERVER, $var_name, FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_input(INPUT_SERVER, $var_name, FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_input(INPUT_SERVER, $var_name, FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
}

public static function env_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_ENV[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_input(INPUT_ENV, $var_name, FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_input(INPUT_ENV, $var_name, FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_input(INPUT_ENV, $var_name, FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_input(INPUT_ENV, $var_name, FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
}
 
public static function request_var($var_name, $filter = 'special_chars')
	{
		
		if(isset($_REQUEST[$var_name]))
		{
			switch($filter)
			{
				case 'special_chars':
					return filter_var($_REQUEST[$var_name], FILTER_SANITIZE_SPECIAL_CHARS);
				break;
				
				case 'encoded':
					return filter_var($_REQUEST[$var_name], FILTER_SANITIZE_ENCODED);
				break;
				
				case 'magic_quotes':
					return filter_var($_REQUEST[$var_name], FILTER_SANITIZE_MAGIC_QUOTES);
				break;
				
				case 'string':
				default:
					return filter_var($_REQUEST[$var_name], FILTER_SANITIZE_STRING);
				break;
				
			}
			
		}
		else
		{
			return false;
		}
		
}
	
public static function _GET($var_name = null)
{
	if($var_name != null){
		return Input::get_var($var_name);
	}
		$get_data = array();
		$keys = array_keys($_GET);
		
		for($i=0; $i < count($keys); $i++)
		{
			$key = $keys[$i];
			$var = filter_var($_GET[$key], FILTER_SANITIZE_SPECIAL_CHARS);
			$get_data[$key] = $var;
		}
			
		return $get_data;
}

public static function _POST($var_name = null)
{
	if($var_name != null){
		return Input::post_var($var_name);
	}
		$get_data = array();
		$keys = array_keys($_POST);
		
		for($i=0; $i < count($keys); $i++)
		{
			$key = $keys[$i];
			$var = filter_var($_POST[$key], FILTER_SANITIZE_SPECIAL_CHARS);
			$get_data[$key] = $var;
		}
			
		return $get_data;
}

public static function _SERVER($var_name = null)
{
	if($var_name != null){
		return Input::server_var($var_name);
	}
		$get_data = array();
		$keys = array_keys($_SERVER);
		
		for($i=0; $i < count($keys); $i++)
		{
			$key = $keys[$i];
			$var = filter_var($_SERVER[$key], FILTER_SANITIZE_SPECIAL_CHARS);
			$get_data[$key] = $var;
		}
			
		return $get_data;
}

public static function _ENV($var_name = null)
{
	if($var_name != null){
		return Input::env_var($var_name);
	}
	
		$get_data = array();
		$keys = array_keys($_ENV);
		
		for($i=0; $i < count($keys); $i++)
		{
			$key = $keys[$i];
			$var = filter_var($_ENV[$key], FILTER_SANITIZE_SPECIAL_CHARS);
			$get_data[$key] = $var;
		}
			
		return $get_data;
}
 
public static function _REQUEST($var_name = null)
{
	if($var_name != null){
		return Input::request_var($var_name);
	}
	
		$get_data = array();
		$keys = array_keys($_REQUEST);
		
		for($i=0; $i < count($keys); $i++)
		{
			$key = $keys[$i];
			$var = filter_var($_REQUEST[$key], FILTER_SANITIZE_SPECIAL_CHARS);
			$get_data[$key] = $var;
		}
			
		return $get_data;
}
 	
public static function validate_email($email)
{
		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
			if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {
				return $sanitized_email;
			}
			else
			{
				return false;
			}

}

	
public static function validate_float($float)
{
		$sanitized_float = filter_var($float, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
			if (filter_var($sanitized_float, FILTER_VALIDATE_FLOAT)) {
				return (float) $sanitized_float;
			}
			else
			{
				return false;
			}

}

public static function validate_int($int)
{
		$sanitized_int = filter_var($int, FILTER_SANITIZE_NUMBER_INT);
			if (filter_var($sanitized_int, FILTER_VALIDATE_INT)) {
				return (int) $sanitized_int;
			}
			else
			{
				return false;
			}

}	

public static function validate_url($url)
{
		$sanitized_url = filter_var($url, FILTER_SANITIZE_URL);
			if (filter_var($sanitized_url, FILTER_VALIDATE_URL)) {
				return (string) $sanitized_url;
			}
			else
			{
				return false;
			}

}	
	
public static function validate_ip($ip)
{
		
			if (filter_var($ip, FILTER_VALIDATE_IP)) {
				return $ip;
			}
			else
			{
				return false;
			}

}


public static function validate_boolean($boolean)
{
			return filter_var($boolean, FILTER_VALIDATE_BOOLEAN);
}

 
public static function url_encode($string)
{
		return filter_var($string, FILTER_SANITIZE_ENCODED);
}

 
public static function validate_string($string)
{
		return filter_var($string, FILTER_SANITIZE_STRING);
}
	
	
public static function validate_array($var, $type = null)
{
		return is_array($var);
}

	
public static function magic_quotes($string)
{
		return filter_var($string, FILTER_SANITIZE_MAGIC_QUOTES);
}


}
