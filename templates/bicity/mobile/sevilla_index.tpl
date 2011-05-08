{%extends 'base.tpl'%}

{% block title %}
Todo sobre Bicity
{% endblock %}

{%block js_add%}

<script type="text/javascript">

var map;
var marker;
function pintar_paradas()
{
	var IconoEstacion = new google.maps.MarkerImage('{{page.url_theme_images}}position-map.png', new google.maps.Size(24, 32), new google.maps.Point(0,0), new google.maps.Point(8, 37) );
	var estacion = new google.maps.LatLng(37.3824, -5.996);

    var opciones = {
				zoom: 14,
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
    var infowindow = new google.maps.InfoWindow();
    
    {% for estacion in data.estaciones %}
    marker = new google.maps.Marker({
      position: new google.maps.LatLng({{estacion.latitud}}, {{estacion.longitud}}), 
      icon: IconoEstacion,
      map: map
	});
	
	var html = '<p>loquesea</p>';
	
	infowindow.setContent(html);
	
	google.maps.event.addListener(marker, 'click', function() {
							infowindow.open(map, marker);
						});
    {% endfor %}
}

jQuery(window).ready(function()
{
	pintar_paradas();
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
<!--Cuerpo de la Web-->
	<div id="cuerpo" data-role="content">
	<h1>Bicity Sevilla</h1>
	<p class="gris">
	El servicio de alquiler Bicicletas públicas en la ciudad de <strong>Sevilla</strong> fue implantado por <a href="http://www.sevici.es/">Sevici</a> en julio de 2007, promovido por el <a href="http://www.sevilla.org/">Ayuntamiento de Sevilla</a> y explotado por la empresa <a href="http://www.sevici.es/">JCDecaux</a>.
	</p>
	<div class="colapsa" data-role="collapsible" data-collapsed="true">
	<h2 class="de-boton">Puntos de recogida/entrega y horario</h2>
	<p class="gris">Siempre encontrará un Área de aparcamiento cerca (para entrega o recogida de bicicletas). En total, <strong>habrá 250</strong> repartidos por toda la ciudad con una <strong>distancia entre ellos de 300 metros</strong> aproximadamente. 
Cada Área de Aparcamiento está formada por un elemento interactivo, a través del cual podrá darse de alta en el servicio, seleccionar la bicicleta a retirar, etc. y varios puntos de anclaje que bloquean o desbloquean las bicis. 
El Sistema le permite coger una bicicleta en cualquier Área de Aparcamiento de la ciudad y devolverla en cualquier otro. 
Este sistema está diseñado para estar en <strong>funcionamiento de manera ininterrumpida los 7 días de la semana, las 24 horas del día.</strong>
</p>
	</div>
	
	<div class="colapsa" data-role="collapsible" data-collapsed="false">
	<h2 class="de-boton">Precio de los carburantes</h2>
	<table>
	<tr><th>Última actualización: </th colspan="2"><td>{{data.consumos.fecha}}</td></tr>
	<tr><td>Sin Plomo 95: </td><td>{{data.consumos.sp95}}</td><td><img src="{{page.url_theme_images}}euro.png"></td></tr>
	<tr><td>Sin Plomo 98: </td><td>{{data.consumos.sp98}}</td><td><img src="{{page.url_theme_images}}euro.png"></td></tr>
	<tr><td>Diesel: </td><td>{{data.consumos.diesel}}</td><td><img src="{{page.url_theme_images}}euro.png"></td></tr>
	</table>
	<p class="gris"><a href="{{page.url_root}}/faq/">¿Cómo se calculan estos precios?</a></p>
	</div>
	
	
	
	<!--<div class="colapsa" data-role="collapsible" data-collapsed="true">//-->
	<h2 class="de-boton">Mapa con todas las Estaciones</h2>
	<div id="position-map" style="width: 80%; height: 20em"></div>
	</div>
	</div>
	<!--Cuerpo de la Web END-->
{% endblock %}

