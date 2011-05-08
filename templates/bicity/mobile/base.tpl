<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" dir="ltr" lang="es">
<head>
<title>{{page.app_name}} | {%block title%}{%endblock%}</title>
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Last-Modified" content="0" />
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="Robots" content="noarchive" />
<meta name="rating" content="general" /> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{%block meta%}
{%endblock%}
	
{%block css%}
<link rel="stylesheet" href="{{page.url_css}}jquery.mobile-1.0a4.1.css" />
<link rel="stylesheet" href="{{page.url_theme_css}}custom.css" />
{%endblock%}
	
{%block css_add%}
{%endblock%}

{%block js%}
<script src="{{page.url_js}}jquery-1.6.min.js"></script>
<script src="{{page.url_js}}1.js"></script>
<script src="{{page.url_js}}2.js"></script>
<script src="{{page.url_js}}jquery.mobile-1.0a4.1.min.js"></script>
<script src="{{page.url_js}}modernizr-1.7.min.js"></script>
<!--<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>-->
<script src="http://maps.google.es/maps/api/js?sensor=false&language=es" type="text/javascript"></script>
{%endblock%}
		
{%block js_add%}
{%endblock%}
</head>
<body>

<div data-role="page" data-theme="b">
	{%block header%}
	<!--Cabecera del sitio-->
	<div id="header-index">
	<span class="linea-header-index"></span>
	</div>
	<h1 class="logo-index"><span>Bicity Muévete por la ciudad en bicicleta y ahorra combustible</span></h1>
	<!--Cabecera del sitio END-->
	{%endblock%}
	
{%block body%}	

{%endblock%}
{%block footer%}
	<!--Pie de la Web-->
	<div id="footer" data-role="footer" data-position="fixed" data-theme="a">
	<div data-role="navbar">
		<ul>
			<li><a href="{{page.url}}/buscador/" data-icon="search" data-iconpos="top" data-rel="dialog">Buscar</a></li>
			<li><a href="{{page.url}}/geo/" rel="external" data-icon="alert">Geo</a></li>
			<li><a href="{{page.url}}/faq/" data-icon="info">Info</a></li>
			<li><a href="{{page.url}}/contacto/" data-icon="gear">Contacto</a></li>
		</ul>
	</div><!-- /navbar -->
</div>
	<!--Pie de la Web END-->
{%endblock%}
</div>
<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', '{{page.analytics_id}}']);
_gaq.push(['_trackPageview']);

(function() {
 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>
</body>
</html>
