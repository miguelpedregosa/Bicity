{%extends 'base.tpl'%}

{% block title %}
Estación nº {{data.info.number}} - {{data.info.address}}
{% endblock %}

{%block js_add%}
<script src="{{page.url_js}}gears_init.js"></script>
<script src="{{page.url_js}}jquery.timers-1.2.js"></script>
<script type="text/javascript">

var map;
var directionDisplay;
var directionsService = new google.maps.DirectionsService();
	
function pintar_parada()
{
	var estacion = new google.maps.LatLng({{data.info.latitud}}, {{data.info.longitud}});
	
	var IconoEstacion = new google.maps.MarkerImage('{{page.url_theme_images}}position-map.png', new google.maps.Size(24, 32), new google.maps.Point(0,0), new google.maps.Point(8, 37) );

    var opciones = {
				zoom: 16,
				center: estacion,
				scrollwheel: false,
				streetViewControl: false,
				navigationControl: true,
				navigationControlOptions: {
					style: google.maps.NavigationControlStyle.DEFAULT
					},
				scaleControl: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP,

			}
    map = new google.maps.Map(document.getElementById("position-map"), opciones);
    
    marker = new google.maps.Marker({
							position: estacion,
							icon: IconoEstacion,
							map: map
							});
	var infowindow = new google.maps.InfoWindow(); 
	var html = '<strong>Estación número: {{data.info.number}}</strong><br />{{data.info.fullAddress}}';
	
	infowindow.setContent(html);
	
	google.maps.event.addListener(marker, 'click', function() {
							infowindow.open(map, marker);
						});
	
	
}

function mostrar_pasos_ruta(resultado)
 {
	var myRoute = resultado.routes[0].legs[0];
	var html = '';
	
	html = html   + '<ol>';
		
	console.log(myRoute);
		
	//Recorro los pasos 
	for (var i = 0; i < myRoute.steps.length; i++) {
				
		var instrucciones = myRoute.steps[i].instructions;
		var distancia = myRoute.steps[i].distance;
		var duracion = myRoute.steps[i].duration;
		
		html = html   + '<li><strong>' + instrucciones + '</strong> '+distancia.text +'</li>';						
		
		}
			
		html = html + '</ol>';
		$('#pasos').html(html);
		
}

function error_directions()
{
		var html = '<p class="gris"><strong>Lamentamos nos poder ofrecer este servicio temporalmente. Pedimos disculpas por las molestias causadas</p>';
		$('#pasos').html(html);
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
	//$('#loader_text').html('Consultando estaciones cercanas');
	
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
	
	var usuario = new google.maps.LatLng(milat, milong);
	var IconoUsuario = new google.maps.MarkerImage('{{page.url_theme_images}}user.png', new google.maps.Size(32, 32), new google.maps.Point(0,0), new google.maps.Point(8, 37) );

	marker_u = new google.maps.Marker({
							position: usuario,
							icon: IconoUsuario,
							map: map
							});
	var infowindow_u = new google.maps.InfoWindow(); 
	var html = '<strong>Tu posición aproximada</strong>';
	
	infowindow_u.setContent(html);
	
	google.maps.event.addListener(marker_u, 'click', function() {
							infowindow_u.open(map, marker_u);
	});
	
	//Ahora muestro las instrucciones para llegar a esta parada desde mi posición
	
	var start = usuario;
	var end = new google.maps.LatLng({{data.info.latitud}}, {{data.info.longitud}});
	
	
	var rendererOptions = {
			suppressMarkers: true
	}
		
	directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
	directionsDisplay.setMap(map);
		
	var request = {
			origin:start, 
			destination:end,
			travelMode: google.maps.DirectionsTravelMode.WALKING,
			optimizeWaypoints: true,
			region: "es"
	};
		 
	directionsService.route(request, function(result, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				//Pinto la ruta en el mapa y actualizo la tabla de indicaciones
				mostrar_pasos_ruta(result);
				directionsDisplay.setDirections(result);
				
			}
			else
			{
				//Muestro un mensaje de error al usuario
				error_directions();
			}
		}); 	
	
}

function pintar_posicion()
{
	initiate_geolocation();
}

jQuery(window).ready(function()
{
	pintar_parada();
	pintar_posicion();
	
	
	
	$(document).everyTime('120s', function(i) {
	   pintar_posicion();
	}, 0);
	
	
});
</script>
{% endblock %}

{%block header%}
<!--Cabecera del sitio-->
<div data-role="header" id="headd" data-position="inline" data-theme="a">
<a class="a-logo" href="{{page.url_root}}"><img src="{{page.url_theme_images}}logo-mini.png" /></a>
<h1 class="vacio"></h1>
<a href="{{page.url_root}}" class="el-tiempo"><span>Sevilla hoy: <strong>{{data.tiempo_maxima}}ºC / {{data.tiempo_minima}}ºC</strong></span><img src="{{page.url_theme_images}}{{data.tiempo_imagen}}.png" /></a>
</div>
<!--Cabecera del sitio END-->
{%endblock%}

{% block body %}
<!--Cabecera del sitio END-->
	<!--Cuerpo de la Web-->
	<div id="cuerpo" data-role="content">
	<h1>Estación nº {{data.info.number}}</h1>
	<div id="desde-hasta" class="ui-body ui-corner-all">
	<h3 class="no-sombra">{{data.info.fullAddress}}</h3>
	
<div class="ui-grid-b">
	<div class="ui-block-a"><img src="{{page.url_theme_images}}bici.png" class="float-l-icon" /><span class="txt-b">{{data.bicicletas.available}}<span></div>
	<div class="ui-block-b"><img src="{{page.url_theme_images}}ancla.png" class="float-l-icon" /><span class="txt-b">{{data.bicicletas.free}}<span></div>
	<div class="ui-block-c"><img src="{{page.url_theme_images}}tarjeta.png" class="float-l-icon" /><span class="txt-b">{% if data.bicicletas.ticket %} Si {% else %} No {% endif %}<span></div>
</div><!-- /grid-a -->
	</div>
	<h2>Mapa</h2>
	
	<div id="position-map" style="width: 80%; height: 20em"></div>
	
	<div class="colapsa" data-role="collapsible" data-collapsed="true">
	<h2 class="de-boton">Cómo llegar a la Estación</h2>
	<div id="pasos"></div>
	</div>	
	</div>
	<!--Cuerpo de la Web END-->
{% endblock %}
