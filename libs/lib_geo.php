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

class Geo
{
	public static function distancia_haversin($lat1, $lat2, $long1, $long2){
		$R = (float)6371;
		$dLat = deg2rad($lat2 - $lat1);
		$dLong = deg2rad($long2 - $long1);
	
		$a = (sin($dLat/2) * sin($dLat/2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * (sin($dLong/2)*sin($dLong/2));
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));
		//$c = 2 * asin(sqrt($a));
		$d = $R * $c;
		//if($d < 1)
			//$d = 0;
	return (round($d*1000));
	}
	
	public static function ordenar_vector_distancias($vector){
       $size = count($vector);
    
    for($i=0; $i < $size; $i++){
        for($j = $size-1; $j > $i; $j--){
            
            if($vector[$j]['distancia'] < $vector[$j-1]['distancia']){
                $temp = $vector[$j];
                $vector[$j] = $vector[$j-1];
                
					$vector[$j-1] = $temp;
                
            }
            
            
        }
    }
    
    return $vector;
}
	
}
