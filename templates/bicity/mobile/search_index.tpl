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
		<input type="text" name="texto" id="texto" class="ddesde" value="" style="width:95%;" />
		</div>
		<input type="submit" value="Buscar" data-role="button" data-icon="search" />
</form>
	</div>	

</div>
	<!--Cuerpo de la Web END-->
{% endblock %}
