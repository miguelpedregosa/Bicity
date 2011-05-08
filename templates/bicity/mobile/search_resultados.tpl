{%extends 'base.tpl'%}

{% block title %}
Buscar estaciones de bicicletas en Bicity
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
	<h3>Buscar</h3>
		<div id="desde-hasta" class="ui-body ui-corner-all">
		<p>Introduce nº de estacion o la calle:</p>
		<form action="{{page.url_root}}/search/resultados/" method="post" data-ajax="false" >
		<div data-role="fieldcontain">
		<input type="text" name="texto" id="texto" class="ddesde" value="{{data.direccion}}" style="width:95%;" />
		</div>
		<input type="submit" value="Buscar" data-role="button" data-icon="search" />
</form>
	</div>	
	<h2>Resultado de búsqueda</h2>
	{% if data.vacio == 1 %}
		<p>No se han encontrado resultados para la búsqueda <strong>{{data.direccion}}</strong>. Pruebe con otra dirección.</p>
	{% else %}
		{% for resultado in data.resultados %}
			<div id="desde-hasta" onclick="window.location = '{{resultado.enlace}}'" style="cursor:pointer;" class="ui-body ui-corner-all">
				<div class="ui-grid-b">
				<div class="ui-block-a"><span class="small">A {{resultado.distancia}} m (Aprox)</span><br/><strong class="big">E-{{resultado.number}}</strong></div>
				<div class="ui-block-b"><img src="{{page.url_theme_images}}bici.png" class="float-l-icon" /><span class="txt-b">{{resultado.available}}<span></div>
				<div class="ui-block-c"><img src="{{page.url_theme_images}}ancla.png" class="float-l-icon" /><span class="txt-b">{{resultado.free}}<span></div>
				</div>
			</div>
		{% endfor %}
	{% endif %}
</div>
	<!--Cuerpo de la Web END-->
{% endblock %}
