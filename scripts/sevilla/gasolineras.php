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
 
 require_once "../../init.php";
 require_once "../functions.php";
 
 class Gasolinera {
 /*Clase que representa el estado de las gasolineras de Sevilla
	Forma de uso:
	
	$g= new Gasolinera();
	//Guardamos el objeto en la base de datos
	$g->almacenar_datos();
	
	//Actualizar el objeto en la base de datos
	$g->actualizar_datos();
	
	//Obtenerm datos de una determinada fecha
	$array = g->obtener_datos($fecha);
 */
 
 public $id=41; //identificador de la ciudad en la web del ministerio de industria
 public $ciudad="sevilla";//nombre de la ciudad
 public $fecha;//fecha de obtención de los datos
 public $sp95;//precio medio del combustible gasolina super 95
 public $sp98;//precio medio del combustible gasolina super 98
 public $diesel;//precio medio del combustible diesel
 
 function __construct()
 {
	/*Establecemos la fecha de creación del objeto*/
	$this->fecha= date ( "d/m/Y" ,time ());
	/*Calculamos el precio de sp95*/
	$this->sp95=calcular_pvp_medio($this->id, $this->ciudad, 1);
	/*Calculamos el precio de sp98*/
	$this->sp98=calcular_pvp_medio($this->id, $this->ciudad, 3);
	/*Calculamos el precio de diesel*/
	$this->diesel=calcular_pvp_medio($this->id, $this->ciudad, 4);
 } 
 
 public function almacenar_datos()
 /*inserta los datos de gasolinera en la base de datos*/
 {
	if($this->obtener_datos($this->fecha) == NULL)
	{
		global $mongo_db;
		$gasolineras = $mongo_db->gasolineras;
		$gasolineras->insert($this);
	}
 }
 
 public function actualizar_datos()
 /*Actualiza los datos existentes de la gasolinera en la fecha actual*/
 {
	if($this->obtener_datos($this->fecha) != NULL)
	{
		global $mongo_db;
	
		$filter = array('fecha'=>$this->fecha);
		$options['multiple'] = false;
		$gasolineras = $mongo_db->gasolineras;
		$gasolineras->update($filter, $this, $options);
	}	
 }
 
 public function obtener_datos($fecha)
 /*Obtiene los datos existentes de la gasolinera y retorna un array con los datos
	en la fecha actual.
 */
 {
	global $mongo_db;
	
	$filter = array('fecha'=>$fecha);
	$gasolineras = $mongo_db->gasolineras;
	$gasolinera = $gasolineras->findOne($filter);
	
	return $gasolinera;
 }
 
 }//Fin Gasolinera
 
	$g= new Gasolinera();
	//Guardamos el objeto en la base de datos
	$g->almacenar_datos();
	
	//Actualizar el objeto en la base de datos
	$g->actualizar_datos();
	
	//Obtenerm datos de una determinada fecha
	$a = $g->obtener_datos($g->fecha);
	
	foreach($a as $atrib=>$valor)
	{
		echo "\n".$atrib." = ".$valor;
	}
 