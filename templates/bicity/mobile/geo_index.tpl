{%extends 'base.tpl'%}

{% block title %}
Paradas cercanas a tu posición actual
{% endblock %}

{%block js_add%}

<script src="{{page.url_js}}gears_init.js"></script>
<script src="{{page.url_js}}jquery.timers-1.2.js"></script>

<script type="text/javascript">
//Funciones de Javascript para la localización del usuario y búsqueda de estaciones cercanas

function reverse_geocoding(latitud, longitud)
{
var geocoder;
geocoder = new google.maps.Geocoder();

if (geocoder)
{
	var latlng = new google.maps.LatLng(latitud, longitud);
	geocoder.geocode({'latLng': latlng}, function(results, status) {
		if(status == google.maps.GeocoderStatus.OK)
		{
			//Tengo la dirección a partir de las coordenadas
			if (results[0])
			{
				var midire = results[0].formatted_address;
				//console.log(results[0].formatted_address);
				if(pintar_input)
					$('#midire').html(midire);
			}
			
		}
	});	

}


}



function initiate_geolocation() {
   if (navigator.geolocation)
      {
          navigator.geolocation.getCurrentPosition(handle_geolocation_query_auto, handle_errors_auto, {enableHighAccuracy:true});
      }
      else
      {
        gl = google.gears.factory.create('beta.geolocation');
         if(gl != null){
          gl.getCurrentPosition(handle_geolocation_query_auto, handle_errors_auto, {enableHighAccuracy:true});
		}    
	  }
}



function handle_errors_auto(error)
{
	
	$('#loader_text').html('Consultando estaciones cercanas');
	
	switch(error.code)
     {
		 case error.PERMISSION_DENIED:
			$('#loader_text').html('Acceso a posición denegado');
		 break;
		 
		 case error.POSITION_UNAVAILABLE:
			$('#loader_text').html('No te hemos encontrado');
		 break;
		 
		 case error.TIMEOUT:
			$('#loader_text').html('Sin respuesta a tiempo');
		 break;
		 
		 default:
			$('#loader_text').html('Error descoocido');
		 break;
		 
	 }
	
	
}

function handle_geolocation_query_auto(position)
{
	milat = position.coords.latitude;
	milong = position.coords.longitude;
	
	$('#loader_text').html('Consultando estaciones cercanas');
	
	//console.log(milat+' , '+milong);
	//Obtengo la dirección a partir de las coordenas y la inserto en la página
	reverse_geocoding(milat, milong);
	
	//Ahora cargo las estaciones cercanas
	var url = '{{page.url_ajax}}geo.php?latitud='+milat+'&longitud='+milong;
	//console.log(url);
	$.ajax({
		url: url,
        cache: false,
		success: function(data) {
			var datos_json = eval('(' + data + ')');
			$('#estacion-ajax').html(datos_json.html);
			
		}
			
	});


}

jQuery(window).ready(function()
{

initiate_geolocation();

//Cada dos minutos se actualiza la posición y las paradas cercanas

$(document).everyTime('120s', function(i) {
  pintar_input = false;
  if(ya_calculado)
  {
	initiate_geolocation();
   }
}, 0);


});
</script>
{% endblock %}

{%block header%}
<!--Cabecera del sitio-->
<div data-role="header" id="headd" data-position="inline" data-theme="a">
<a class="a-logo" href="{{page.url}}"><img src="{{page.url_theme_images}}logo-mini.png" /></a>
<h1 class="vacio"></h1>
</div>
<!--Cabecera del sitio END-->
{% endblock %}

{% block body %}
<!--Cuerpo de la Web-->
	<div id="cuerpo" data-role="content">
	<h1>Geolocalización</h1>
	<p class="gris"><img style="float:left;margin-top:-7px;" src="{{page.url_theme_images}}your-position.png"> <strong>Tu posición: </strong><span id="midire">-</span></p>
	<p class="gris small">El sistema de Geolocaliación de esta sección se actualizando automáticamente cada 2 minutos mientras te desplazas mostrándote en tiempo real la distancia a la que te encuentras de las estaciones. <strong>ADVERTENCIA</strong>: <span class="italic">El uso semi-intensivo del GPS y de la conexión 3G reducen el tiempo de duración de la batería</span>.</p>
		
	<h2>Estaciones cercanas</h2>
	<div id="estacion-ajax">
<div class="giratorio">
	<img class="cargando" src="{{page.url_theme_images}}loading.gif" />
	<strong class="cargando" id = "loader_text" name ="loader_text" style="width:300px;">Cargando posici&oacute;n. Por favor, espere...</strong>
	</div>
</div>

</div>
	<!--Cuerpo de la Web END-->
{% endblock %}
