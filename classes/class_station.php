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

class Station
{
	protected $id;
	protected $name;
	protected $number;
	protected $address;
	protected $fullAddress;
	protected $posicion;
	protected $open;
	protected $bonus;
	protected $city;
	
	/*Constructor de la estación de bicicletas
	 * $param puede ser un id o un número de estación
	 * si id > 0 => Se pretende crear una estación a partir de los datos almacenados en Base de datos.
	 * */
	public function __construct($ciudad="Sevilla", $param=null)
	{
		global $mongo_db;
		$bicity = $mongo_db->estaciones;
		
		if($param==null){
			$this->id = 0;
			$this->name = '';
			$this->number = 0;
			$this->address = '';
			$this->fullAddress = '';
			$this->posicion = new Position();
			$this->open = false;
			$this->bonus = false;
			$this->city = Text::slug($ciudad);
		}
		elseif(is_numeric($param)){
			$param = intval($param);
			$cursor = $bicity->findOne(array('number' => $param, 'city' => Text::slug($ciudad)));
			$this->id = ((string)$cursor['_id']);
			$this->name = ($cursor['name']);
			$this->number = ($cursor['number']);
			$this->address = ($cursor['address']);
			$this->fullAddress = ($cursor['fulladdress']);
			$this->open = ($cursor['open']);
			$this->bonus = ($cursor['bonus']);
			$this->posicion = new Position(array('latitud' => ($cursor['latitud']), 'longitud'=> ($cursor['longitud'])));
			$this->city = Text::slug($ciudad);
		}
	}
	
	public function to_Array(){
		$estacion = array(
		'id'=>$this->id,
		'name'=>$this->name,
		'number'=>$this->number,
		'address'=>$this->address,
		'fullAddress'=>$this->fullAddress,
		'posicion'=>$this->posicion,
		'open'=>$this->open,
		'bonus'=>$this->bonus,
		'city'=>$this->city
		);
		return $estacion;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getNumber()
	{
		return $this->number;
	}
	
	public function getAddress()
	{
		return $this->address;
	}
	
	public function getFullAddess()
	{
		return $this->fullAddress;
	}
	
	public function getPosition()
	{
		return $this->posicion;
	}
	
	public function isOpen()
	{
		return $this->open;
	}
	
	public function getBonus()
	{
		return $this->bonus;
	}
	
	public function getCity()
	{
		return $this->city;
	}
	
	public function getStationInfo()
	{
		$ch = curl_init("http://www.sevici.es/service/stationdetails/".$this->number);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch);
		curl_close($ch);
		//parseo los datos con SimpleXml
		$doc = new SimpleXmlElement($data, LIBXML_NOCDATA);
		$info_estacion = array(
			'available'=>intval((string)$doc->available),
			'free'=>intval((string)$doc->free),
			'total'=>intval((string)$doc->total),
			'ticket'=>((string)$doc->ticket == '1' ? true : false)
		);
		return $info_estacion;
	}
}
