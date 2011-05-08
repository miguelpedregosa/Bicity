{%extends 'base.tpl'%}

{% block title %}
Rutas en bicicleta por la ciudad y ahorro de combustible
{% endblock %}

{%block js_add%}
<script src="{{page.url_js}}gears_init.js"></script>
<script src="{{page.url_js}}jquery.timers-1.2.js"></script>

<script type="text/javascript">
//Funciones de Javascript para la localización del usuario y búsqueda de estaciones cercanas
pintar_input = true;
ya_calculado = false;
var geocoder;
geocoder = new google.maps.Geocoder();

function reverse_geocoding(latitud, longitud)
{

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
					$('#desde').val(midire);
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
	//console.log(error.code);
	$('#loader_text').html('Consultando estaciones cercanas');
	
	switch(error.code)
     {
		 case error.PERMISSION_DENIED:
			//$('#loader_text').html('Acceso a posición denegado');
		 break;
		 
		 case error.POSITION_UNAVAILABLE:
			//$('#loader_text').html('No te hemos encontrado');
		 break;
		 
		 case error.TIMEOUT:
			//$('#loader_text').html('Sin respuesta a tiempo');
		 break;
		 
		 default:
			//$('#loader_text').html('Error descoocido');
		 break;
		 
	 }
	
	
}

function handle_geolocation_query_auto(position)
{
	milat = position.coords.latitude;
	milong = position.coords.longitude;
	
	$('#latitud').val(milat);
	$('#latitud').val(milat);
	
	//$('#loader_text').html('Consultando estaciones cercanas');
	
	//console.log(milat+' , '+milong);
	//Obtengo la dirección a partir de las coordenas y la inserto en la página
	reverse_geocoding(milat, milong);

}
function address_to_gps()
{
	var dire1 = $('#desde').val();
	var dire2 = $('#hasta').val()+' Sevilla, Spain';
	
	if (geocoder) {
      geocoder.geocode( { 'address': dire1}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
			$('#latitud').val(results[0].geometry.location.lat());
			$('#longitud').val(results[0].geometry.location.lng());
          //console.log(results[0].geometry.location);
        } else {
          //alert("Geocode was not successful for the following reason: " + status);
        }
      });
   
   
	geocoder.geocode( { 'address': dire2}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
			$('#latitud_hasta').val(results[0].geometry.location.lat());
			$('#longitud_hasta').val(results[0].geometry.location.lng());
          //Ahora envío el form
			$('#ruta_form').submit();
        } else {
          //alert("Geocode was not successful for the following reason: " + status);
        }
      });
   
   
   
    }
	
	
}

jQuery(window).ready(function()
{

initiate_geolocation();

//
$('#bruta').click(function() {
  //$('#target').submit();
  address_to_gps();
});

//Cada minuto se actualiza la posición y las paradas cercanas

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
	<a class="a-logo" href="{{page.url_root}}"><img src="{{page.url_theme_images}}logo-mini.png" /></a>
	<h1 class="vacio"></h1>
</div>
	<!--Cabecera del sitio END-->
{%endblock%}

{% block body %}
<!--Cuerpo de la Web-->
	<div id="cuerpo" data-role="content">
	<div id="desde-hasta2" style="margin-top:40px;"class="ui-body ui-corner-all">
	<h2>Se ha producido un Error</h2>
	<a href="{{page.url_root}}">Volver al inicio</a>
	</div>
	<h2>Nueva ruta en bicicleta</h2>
	<p class="gris"><span class="small">Por favor introduzca la dirección de salida y de llegada para calcular la ruta.</span></p>
	<div id="desde-hasta" class="ui-body ui-corner-all">

<form id="ruta_form" name="ruta_form" action="{{page.url}}/gps/ruta/" method="post" data-ajax="false">
<div data-role="fieldcontain">
<label for="desde">Desde:</label>

<img src="{{page.url_theme_images}}button-geo2.png" id="geoo">

<input type="text" name="desde" id="desde" class="ddesde" value=""  />
<hr style="position:relative;z-index:-1;height:0;margin-bottom:5px;" />

<label for="hasta">Hasta:&nbsp;</label>
<input type="text" name="hasta" id="hasta" value=""  />
<input type="hidden" name="latitud" id="latitud" value=""  />
<input type="hidden" name="longitud" id="longitud" value=""  />
<input type="hidden" name="latitud_hasta" id="latitud_hasta" value=""  />
<input type="hidden" name="longitud_hasta" id="longitud_hasta" value=""  />
</div>
<input type="button" id="bruta" name="bruta" data-role="button" data-icon="search" value="Buscar ruta" />
</form>
</div>
</div>
<!--Cuerpo de la Web END-->
{% endblock %}
