<?php
/*
 * Proyecto Bicity - Sistema público de prestamo y alquiler de bicicletas
 * 					AbreDatos 2011 (7 y 8 de mayo)
 * 
 * Código fuente publicado con licencia open source GNU AFFERO GENERAL PUBLIC LICENSE v3
 * 
 * Proyecto desarrollado por:
 *  - Miguel Ángel Pedregosa (@miguelpedregosa)
 *  - Josen Antonio Lopez (@JoseAntonio1982)
 *  - Cesar Santiago (@csm_web)
 *  - Abelardo Aguado (@aBeholic)
 * 
 */

class Template
{
	protected $_h2o;
	protected $headers = array();
	protected $_var = array();
	
	
	public function __construct($page, $function, $data=null)
	{
		global $configuracion;
		$template_name = PATH_TEMPLATE.strtolower($page).'_'.strtolower($function).'.tpl';
		
		if(!file_exists($template_name))
		{
			if(file_exists(PATH_TEMPLATE.'error_e404.tpl'))
			{
				$template_name = PATH_TEMPLATE.'error_e404.tpl';
			}
			else
			{
				echo 'No existe ni la plantilla de error, esto es grave';
				exit();
			}
		}
				
		$options = array(
			'cache' => $configuracion['template_cache'],
			'cache_dir'=> PATH_TMP.'cache/'
		);
		
		//Creo el objeto de H2O para la plantilla		
		$this->_h20 = new h2o($template_name, $options);
		
		if($data != null)
		{
			$this->set_data($data, 'data');
		}

	}
	
	function set($name, $value, $tpl_var = 'document')
	{
		$this->_var[$tpl_var][$name] = $value;
		
	}
	
	function set_data($datos, $tpl_var)
	{
		if(is_array($datos))
		{
			while($dato_value = current($datos))
			{
				$this->set(key($datos), $dato_value, $tpl_var);
				next($datos);
			}
			
		}
	}
	
	function set_header($header)
	{
		array_push($this->headers, $header);
	}
	
	function remove_headers()
	{
		$this->headers = array();
	}
	
	function send_headers()
	{
		foreach($this->headers as $header)
		{
			header($header);
		}
	}
	
	function render_template()
	{
			global $configuracion;
			
			$vars = array(
				'app_name' => $configuracion['app_name'],
				'analytics_id' => $configuracion['analytics_id'],
				'url_root' => URL_ROOT,
				'url_ajax' => URL_AJAX,
				'url_js' => URL_JS,
				'url_css' => URL_CSSS,
				'url_images' => URL_IMAGES,
				'url_theme' => URL_THEME,
				'url_theme_css' => URL_THEME_CSS,
				'url_theme_images'=> URL_THEME_IMAGES
			);
			$this->set_data($vars, 'page');
			$this->send_headers();
			echo $this->_h20->render($this->_var);
	}
	
}
