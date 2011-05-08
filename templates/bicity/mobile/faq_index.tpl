{%extends 'base.tpl'%}

{% block title %}
Todo sobre Bicity
{% endblock %}


{%block js_add%}
<script type="text/javascript">
    // tapping the whole LI triggers click on the first link
 $list.delegate( "li", "click", function(event) {
  if ( !$( event.target ).closest( "a" ).length ) {

  var a = $( this ).find( "a" );               
  var href = a.attr("href");

  if(href && href[0] == '#') {
     window.location.hash = href;   
     return true;
   } else {
     a.first().trigger( "click" );   
   }               
   return false;
   }
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
<h1>F.A.Q. (Preguntas Frecuentes)</h1>
	<div class="colapsa" data-role="collapsible" data-collapsed="true">
	<h2>¿Qué es Bicity?</h2>
<p class="gris">
	<strong>Bicity</strong> es una aplicación web que pretende fomentar el uso de la bicicleta en el entorno urbano como medio de transporte práctico y rápido, 
	respetuoso con el medio ambiente y determinante para el ahorro energético de la ciudad. 
	Nuestro objetivo es el de ofrecer toda la información que pueda ser útil para el usuario y hacerla llegar a través de cualquier dispositivo capaz de 
	conectarse a la red de Internet.
	<br><br>
	El desarrollo de este proyecto se realizó con motivo de su participación en el desafío <strong>#abredatos</strong> 2011 para el desarrollo exprés de servicios tecnológicos 
	al ciudadano basados en el uso de datos públicos. 
</p>
	</div>
<div class="colapsa" data-role="collapsible" data-collapsed="true">
<h2>¿Dónde funciona Bicity?</h2>
<p class="gris">
	En la actualidad, <strong>Bicity</strong> cubre todo el área urbana de Sevilla (España), centrándose principalmente en el servicio público de alquiler de bicicletas de las 
	principales ciudades españolas. Trabajamos para incluir dia a dia más ciudades en nuestro rádio de actuación.
</p>
</div>
<div class="colapsa" data-role="collapsible" data-collapsed="true">
<h2>¿De dónde salen los datos?</h2>
<p class="gris">
	Toda la información mostrada en la web de <a href="http://bicity.info" target="_self">bicity.info</a> se obtiene a través del procesamiento de los datos
	que se registran en las siguientes fuentes de carácter público:
	<ul>
		<li><strong>SEVici</strong>, el servicio de alquiler de bicicletas públicas, <a style="color:#959b1f;" href="http://www.sevici.es/" target="_blank" rel="nofollow">www.sevici.es</a>, perteneciente al
		Ayuntamiento de la ciudad de Sevilla.</li>
		<li><strong>GEOPORTAL</strong>, la web informativa del Ministerio de Industria, Turismo y Comercio (Gobierno de España), <a style="color:#959b1f;" href="http://geoportal.mityc.es/hidrocarburos/eess/" target="_blank" rel="nofollow">geoportal.mityc.es</a>.</li>
		<li><strong>AEMET</strong>, la agencia estatal de meteorología, <a style="color:#959b1f;" href="http://www.aemet.es/es/portada" target="_blank" rel="nofollow">www.aemet.es</a>, del Ministerio de 
		Medio Ambiente y Medio Rural y Marino (Gobierno de España).</li>
		<li><strong>IDAE</strong>, Instituto para la Diversificación y Ahorro de la Energía, <a style="color:#959b1f;" href="http://www.idae.es/" target="_blank" rel="nofollow">www.idae.es</a>, adscrito al Ministerio 
		de Industria, Turismo y Comercio (Gobierno de España), y cuya base de datos contiene información sobre indicaciones de consumos y emisiones de CO<sub>2</sub>.
		</li>
	</ul>
</p>
</div>
<div class="colapsa" data-role="collapsible" data-collapsed="true">
<h2>Bicicletas públicas</h2>
<p class="gris">
	El servicio de bicicleta pública es una propuesta de reciente aplicación en diversas ciudades españolas, que pretende motivar el uso de la bicicleta en desplazamientos
	urbanos, poniendo a disposición de los ciudadanos varios lugares de estacionamiento y recogida automatizados y repartidos en puntos estratégicos de la ciudad. 
	El préstamo es gratuito o simbólico, durante un tiempo limitado.
</p>
</div>
<div class="colapsa" data-role="collapsible" data-collapsed="true">
<h2>Cálculo de rutas en tiempo real</h2>
<p class="gris">
	Para ayudar al usuario a encontrar sus paradas más cercanas y los trayectos más cortos en su desplazamiento por la ciudad, <strong>Bicity</strong> emplea el uso 
	de herramientas de geolocalización. Si el dispositivo desde el cual se accede a la aplicación permite compartir esta información, el sistema registrará automáticamente las
	las coordenadas de su posición y establecerá la dirección correspondiente como punto de inicio del trayecto. En caso contrario puede introducirse manualmente la dirección
	de inicio usando el cuadro de texto habilitado.<br>
	Una vez establecido el punto de inicio de la ruta, <strong>Bicity</strong> procederá a mostrar la lista de puntos de recojida más cercanos junto con el número de bicicletas
	disponibles para su uso en ese momento.<br>
	Haciendo click en el icono del punto de recojida deseado, podrán conocerse otros datos de interés así como el camino más corto a pié para retirar una bicicleta.
	<br><br>
	De idéntica forma puede consultarse la ruta hasta el punto de anclaje deseado para dejar la bicicleta, una vez finalizado el uso de la misma.
</p>
</div>
<div class="colapsa" data-role="collapsible" data-collapsed="true">
<h2>Estimación del ahorro</h2>
<p class="gris">
	<strong>Bicity</strong> también es capaz de calcular la media de ahorro conseguido durante el desplazamiento en bicicleta, frente al uso del automóvil.
	El cálculo de dicho ahorro es una estimación realizada a partir de los datos de consumo de más de 4.280 modelos de cohes y el precio medio del combustible, 
	a la fecha de consulta, en las gasolineras de la ciudad.
</p>
</div>
<div class="colapsa" data-role="collapsible" data-collapsed="true">
<h2>Estimación de emisiones</h2>
<p class="gris">
	De la misma forma, se puede prever el grado de contaminación a la atmósfera que evitamos en los desplazamientos utilizando la bicicleta en lugar del coche,
	a partir de los datos de emisión de gramos de CO<sub>2</sub> por kilómetro recorrido de cada uno de los modelos almacenados en nuestra base de datos.
</p>
</div>
<div class="colapsa" data-role="collapsible" data-collapsed="true">
<h2>El futuro de Bicity</h2>
<p class="gris">
	Los servicios de prestamo temporal de bicicletas y medios de transporte individual y de bajo consumo, son una propuesta de nuevo crecimiento que sin duda
	se verá impulsada en los próximos años con el desarrollo de nuevas tecnologías y el apoyo de las instituciones públicas. 
	En este sentido, el equipo de <strong>Bicity</strong> se esfuerza por mantenersevactualizado con respecto a los cambios y mejoras del sector, 
	para ofrecer una solución útil y totalmente gratuita, llegando cada día a más usuarios.
</p>
</div>
</div>
<!--Cuerpo de la Web END-->
{% endblock %}
