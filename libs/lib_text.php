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

class Text{
	
	public static function slug($cadena)
	{
		$cadena = strtolower(trim($cadena));
		$cadena = preg_replace('/[^a-z0-9-]/', '-', $cadena);
		$cadena = preg_replace('/-+/', "-", $cadena);
		return $cadena;
	}
	
}

