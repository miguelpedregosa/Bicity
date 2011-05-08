{%extends 'base.tpl'%}

{% block title %}
Rutas en bicicleta por la ciudad y ahorro de combustible
{% endblock %}

{%block js_add%}
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
	<h1>Salida - Destino</h1>
	<div id="desde-hasta" class="ui-body ui-corner-all">
	<p class="no-sombra italic">Desde: <strong>CALLE CHURRUCA - Aprox. C/ Gonzáles Cuadrado</strong></p>
	<p class="no-sombra italic">Hasta: <strong>CALLE CHURRUCA - Aprox. C/ Gonzáles Cuadrado</strong></p>
	<hr/>
	<p class="no-sombra italic">Estación de Salida: 345 <strong>CALLE CHURRUCA - Aprox. C/ Gonzáles Cuadrado</strong></p>
<div class="ui-grid-b">
	<div class="ui-block-a"><img src="images/bici.png" class="float-l-icon" /><span class="txt-b">7<span></div>
	<div class="ui-block-b"><img src="images/ancla.png" class="float-l-icon" /><span class="txt-b">4<span></div>
	<div class="ui-block-c"><img src="images/tarjeta.png" class="float-l-icon" /><span class="txt-b">Si<span></div>
</div><!-- /grid-a -->
<hr/>
	<p class="no-sombra italic">Estación de llegada: 43 <strong>CALLE CHURRUCA - Aprox. C/ Gonzáles Cuadrado</strong></p>
<div class="ui-grid-b">
	<div class="ui-block-a"><img src="images/bici.png" class="float-l-icon" /><span class="txt-b">7<span></div>
	<div class="ui-block-b"><img src="images/ancla.png" class="float-l-icon" /><span class="txt-b">4<span></div>
	<div class="ui-block-c"><img src="images/tarjeta.png" class="float-l-icon" /><span class="txt-b">Si<span></div>
</div><!-- /grid-a -->
	</div>
	<div class="colapsa" data-role="collapsible" data-collapsed="false">
	<h2 class="de-boton">Calculo de Ahorro</h2>
	<h2>Resumen</h2>
	<p class="gris"><strong>Distancia Recorrida: </strong>12 Km</p>
	<p class="gris"><strong>Emisiones ahorradas: </strong>34 gr CO2</p>
	<table>
	<tr style="font-weight:bold;"><td>Combustible </td><td>Dinero Gastado </td></tr>
	<tr><td>Sin Plomo 95: </td><td>{{data.consumos.sp95}}</td><td><img src="{{page.url_theme_images}}euro.png"></td></tr>
	<tr><td>Sin Plomo 98: </td><td>{{data.consumos.sp98}}</td><td><img src="{{page.url_theme_images}}euro.png"></td></tr>
	<tr><td>Diesel: </td><td>{{data.consumos.diesel}}</td><td><img src="{{page.url_theme_images}}euro.png"></td></tr>
	</table>
	<p class="gris">Precios calculados para un coche estandar. ¿Quieres ver un modelo concreto de vehiculo? <a href="{{page.url_root}}/vehiculo/">Pulsa aquí</a></p>
	<p class="gris"><a href="{{page.url_root}}/faq/">¿Cómo se calculan estos precios?</a></p>
	</div>
	<div class="colapsa" data-role="collapsible" data-collapsed="true">
	<h2 class="de-boton">Precio de los Carburantes</h2>
	<table>
	<tr><th>Última actualización: </th><td>{{data.consumos.fecha}}</td></tr>
	<tr><td>Sin Plomo 95: </td><td>{{data.consumos.sp95}}</td><td><img src="{{page.url_theme_images}}euro.png"></td></tr>
	<tr><td>Sin Plomo 98: </td><td>{{data.consumos.sp98}}</td><td><img src="{{page.url_theme_images}}euro.png"></td></tr>
	<tr><td>Diesel: </td><td>{{data.consumos.diesel}}</td><td><img src="{{page.url_theme_images}}euro.png"></td></tr>
	</table>
	<p class="gris"><a href="{{page.url_root}}/faq/">¿Cómo se calculan estos precios?</a></p>
	</div>
	<h2>Mapa</h2>
	<img src="images/map.png" class="mapp" class="float-l-icon" />
	<div class="colapsa" data-role="collapsible" data-collapsed="true">
	<h2 class="de-boton">Cómo llegar a la Estación</h2>
	</div>
	</div>
	<!--Cuerpo de la Web END-->
{% endblock %}
