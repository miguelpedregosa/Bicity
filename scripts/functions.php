 <?php
 /*
 * Proyecto Bicity - Sistema p�blico de prestamo y alquiler de bicicletas
 * 					AbreDatos 2011 (7 y 8 de mayo)
 * 
 * C�digo fuente publicado con licencia open source GNU AFFERO GENERAL PUBLIC LICENSE v3
 * 
 * Proyecto desarrollado por:
 *  - Miguel �ngel Pedregosa (@miguelpedregosa)
 *  - Josen Antonio Lopez (@JoseAntonio1982)
 *  - Cesar Santiago (@csm_web)
 *  - Abelardo Aguado (@aBeholic)
 * 
 */
 
 function calcular_pvp_medio($id, $ciudad, $gas)
 /*
	Extrae los precios de la gasolina desde la web del ministerio de industria para una determinada ciudad
	Par�metros:
		id 		- n�mero identificador de la provincia.
		ciudad	- nombre de la ciudad.
		gas		- c�digo del tipo de gasolina (1 sp95, 3 sp98, 4 diesel)
	
	Retorna el precio medio de ese tipo de gasolina en la ciudad dada.	
 */
 {
	$res= 0;//n�mero de resultados hallados
	$i=0; //iteraci�n del bucle
	$pvp=0; //precio de la gasolina
	$pvp_medio=0;//precio medio de la gasolina
	
	/*Configuramos curl y realizamos la consulta*/
	$ch = curl_init("http://geoportal.mityc.es/hidrocarburos/eess/searchAddress.do");
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, "nomProvincia=".$id."&nomMunicipio=".$ciudad."&tipoCarburante=".$gas."&rotulo=&tipoVenta=false&nombreVia=&numVia=&codPostal=&economicas=false&tipoBusqueda=0&ordenacion=P&posicion=0");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);      
    curl_close($ch);
	
	/*filtramos los datos*/
		/*n�mero de resultados*/
	if(preg_match('/<p>.*<\/p>/', $output, $coincidencias))
	{
		//eliminamos todo lo que no sean n�meros
		$res=ereg_replace('[^[:digit:]]','',$coincidencias[0]);
	}
	
	if ($res!=0)
	{
		do
		{
		/*Por cada p�gina obtenemos todos los precios de la gasolina*/
			if(preg_match_all('/<td class="tdXShort">[0-9,]{5}<\/td>/', $output, $coincidencias))
			{
				//eliminamos todo lo que no sean n�meros
				foreach ($coincidencias as $c)
				{
					foreach($c as $precio)
					{
						$pvp=$pvp+floatval(str_replace(",",".",strip_tags($precio)));
					}
				}
			}
		
			$i= $i+10;
			
			/*Configuramos curl y realizamos la consulta*/
			$ch = curl_init("http://geoportal.mityc.es/hidrocarburos/eess/searchAddress.do");
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS, "nomProvincia=".$id."&nomMunicipio=".$ciudad."&tipoCarburante=".$gas."&rotulo=&tipoVenta=false&nombreVia=&numVia=&codPostal=&economicas=false&tipoBusqueda=0&ordenacion=P&posicion=".$i."");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);      
			curl_close($ch);
			
		}while($i<$res);
		
		$pvp_medio= number_format(($pvp/$res),3);
	}
	
	return $pvp_medio;
 }//Fin get_atributos