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
	<h1>Contacta con nosotros</h1>
	<div id="{{data.send_id}}" class="ui-body ui-corner-all">
	<h2>{{data.send_text}}</h2>
	<p>{{data.send_text2}}</p>
	<a href="{{page.url_root}}">Volver al inicio</a>
	</div>
	<p class="gris">Rellena el siguiente formulario para ponerte en contacto con nosotros si tienes alguna duda. ¡Contestaremos con la mayor brevedad posible!</p>
	<div id="desde-hasta" class="ui-body ui-corner-all">
	<form action="{{page.url_root}}/contacto/enviado/" method="post" data-ajax="false">
	<div data-role="fieldcontain">
    <label for="name">Nombre:</label>
    <input type="text" name="name" id="name" value=""  />
	</div>
	<div data-role="fieldcontain">
    <label for="email">Correo Electr&oacute;nico:</label>
    <input type="text" name="email" id="email" value=""  />
	</div>
	<div data-role="fieldcontain">
    <label for="asunto">Asunto:</label>
    <input type="text" name="asunto" id="asunto" value=""  />
	</div>
	<div data-role="fieldcontain">
	<label for="textarea">Mensaje:</label>
	<textarea cols="40" rows="8" name="textarea" id="textarea"></textarea>
</div>
<input type="submit" data-role="button" data-icon="gear" value="Enviar" />
</form>
	</div>
	<h2>Síguenos en: </h2>
	<div class="ui-grid-a">
	<div class="ui-block-a"><p class="gris"><a style="text-decoration:none;" href="http://twitter.com/bicity_info"><img src="{{page.url_theme_images}}twitter1.png" alt="Bicity en Twitter" /></a></p></div>
	<div class="ui-block-b"><p class="gris"><a style="text-decoration:none;" href="https://www.facebook.com/pages/Bicity/203476519691757?sk=info"><img src="{{page.url_theme_images}}face.png" alt="Bicity en Facebook" /></a></p></div>
</div><!-- /grid-a -->
	</div>
	<!--Cuerpo de la Web END-->
{% endblock %}

