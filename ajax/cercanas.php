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
 
 header('Cache-Control: no-cache, must-revalidate');
 header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
 require_once "../init.php";
 //Ahora realizo la busqueda de las estaciones mas cercanas a la posición
 $GET = Input::_GET();

if(isset($GET['latitud']) && isset($GET['longitud']))
 {
	 $buscar = new Search();
	 $cercanas = $buscar->cercanas((float)$GET['latitud'], (float)$GET['longitud'], null , 3);
	 foreach($cercanas as $estacion)
	 {
		 $est = new Station($estacion['city'], $estacion['number']);
		 $estacion_array = $est->to_array();
		 $distancia = $estacion['distancia'];
		 $medida = 'm';
		 if($distancia > 1000)
		 {
			 $distancia = round($distancia / 1000, 2);
			 $medida = 'Km';
			 $distancia = str_replace('.', ',', $distancia);
		 }
		 
		 $tiempo_real = $est->getStationInfo();
		 $enlace = $est->getHref();
?>
<div id="desde-hasta" onclick="window.location = '<?=$enlace?>'" style="cursor:pointer;" class="ui-body ui-corner-all">
	<div class="columnas-desiguales ui-grid-b">
	<div class="ui-block-a"><span class="small">A <?=$distancia?> <?=$medida?> Aprox</span><br/><strong class="big">E-<?=$estacion_array['number']?></strong></div>
	<div class="ui-block-b"><img src="<?=URL_THEME_IMAGES?>bici.png" class="float-l-icon" /><span class="txt-b"><?=$tiempo_real['available']?><span></div>
	<div class="ui-block-c"><img src="<?=URL_THEME_IMAGES?>ancla.png" class="float-l-icon" /><span class="txt-b"><?=$tiempo_real['free']?><span></div>
</div><!-- /grid-a -->
</div>
<?php
	 }
 }
 
