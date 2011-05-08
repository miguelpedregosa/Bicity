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
	protected $latitud;
	protected $longitud;
	
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
			$this->latitud = $cursor['latitud'];
			$this->longitud = $cursor['longitud'];
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
		'city'=>$this->city,
		'latitud'=>$this->latitud,
		'longitud'=>$this->longitud
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
		global $mongo_db;
		$bicity = $mongo_db->estaciones;
		$info_estacion=null;
		
		//me traigo la info de la base de datos antes de leer desde sevici.
		$cursor = $bicity->findOne(array('number' => $this->number, 'city' => Text::slug($this->city)));
		if($cursor != null){
			$toma = intval($cursor['timestamp']);
			$ahora = time();
			//krumo("Leo de BD ".intval(($ahora-$toma)/60));
			if(intval(($ahora-$toma)/60)<15){
				$info_estacion = array(
					'available'=>$cursor['available'],
					'free'=>$cursor['free'],
					'total'=>$cursor['free'],
					'ticket'=>$cursor['ticket']
				);
				return $info_estacion;
			}
			else{		
				//krumo("Pa bajo por tiempo");
				$ch = curl_init("http://www.sevici.es/service/stationdetails/".$this->number);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				$data = curl_exec($ch);
				$error = curl_error($ch);
				curl_close($ch);
				
				$doc = new SimpleXmlElement($data, LIBXML_NOCDATA);
				$info_estacion = array(
					'available'=>intval((string)$doc->available),
					'free'=>intval((string)$doc->free),
					'total'=>intval((string)$doc->total),
					'ticket'=>intval((string)$doc->ticket),
					'timestamp' => time()
				);
				$newdata = array('$set' => $info_estacion);
				$bicity->update(array('number' => $this->number), $newdata);
				return $info_estacion;
			}			
		}else{		
			//krumo("Pa bajo por falta");
			$ch = curl_init("http://www.sevici.es/service/stationdetails/".$this->number);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$data = curl_exec($ch);
			$error = curl_error($ch);
			curl_close($ch);
			
			$doc = new SimpleXmlElement($data, LIBXML_NOCDATA);
			$info_estacion = array(
				'available'=>intval((string)$doc->available),
				'free'=>intval((string)$doc->free),
				'total'=>intval((string)$doc->total),
				'ticket'=>intval((string)$doc->ticket),
				'timestamp' => time()
			);
			$newdata = array('$set' => $info_estacion);
			$bicity->update(array('number' => $this->number), $newdata);
			return $info_estacion;
		}
	}
	
	public function bornetasAvailable(){
		global $mongo_db;
		$bicity = $mongo_db->estaciones;
		
		$cursor = $bicity->findOne(array('number' => $this->getNumber()));
		if($cursor != null){
			$toma = intval($cursor['timestamp']);
			$ahora = time();
			if(intval(($ahora-$toma)/60)<45){
				return ($cursor['free'] > 0 ? true : false );
			}
			else return true;
		}
		else{
			$estacion = $this->getStationInfo();
			return ($estacion['free'] > 0 ? true : false );
		}
	}
	
	public function bikesAvailable(){
		global $mongo_db;
		$bicity = $mongo_db->estaciones;
		
		$cursor = $bicity->findOne(array('number' => $this->getNumber()));
		if($cursor != null){
			$toma = intval($cursor['timestamp']);
			$ahora = time();
			if(intval(($ahora-$toma)/60)<45){
				return ($cursor['available'] > 0 ? true : false );
			}
			else return true;
		}
		else{
			$estacion = $this->getStationInfo();
			return ($estacion['free'] > 0 ? true : false );
		}
	}
	
	public function has_anclajes()
	{
		return $this->bornetasAvailable();
	}
	public function has_bicis()
	{
		return $this->bikesAvailable();
	}
	
	public function getLink($options = array()){
		$text = utf8_decode('Estación ').$this->getName();
		$path = $this->getCity().'/estacion/'.$this->getNumber().'/'.Text::slug($this->getName());
		if($this->getName()==null) $path = '#';
		return (Text::href($text, $path, $options));
	}
	
	public function getHref(){
		//Ciudad/estacion/numero/slugnombreparada
		global $configuracion;
		if($this->getName()==null) return '#';
		
		$path = $configuracion['http_root'].'/'.$this->getCity().'/estacion/'.$this->getNumber().'/'.Text::slug($this->getName());
		return $path;
	}
}
