{%extends 'base.tpl'%}

{% block title %}
Contactar con Bicity
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
	<div id="desde-hasta2" style="margin-top:40px;"class="ui-body ui-corner-all">
	<h2>Lista aún no disponible</h2>
	<p>Estamos trabajando en ello.</p>
	<a style="color:#d9d9d9;" href="{{page.url_root}}">Volver al inicio</a>
	</div>
	</div>
	<!--Cuerpo de la Web END-->
	{% endblock %}
	