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

class ContactoPage
{
	
	private function sanitize_email($email)
	{
		return Input::validate_email($email);
	}
	
	private function send_text_email($data)
    {
		if(!is_array($data))
		{
			return false;
		}
		
		if(!isset($data['to']) || !isset($data['subject']) || !isset($data['text']))
			return false;
		$to = '';
		if(is_array($data['to']))
		{
			$to = '';
			foreach($data['to'] as $email_d)
			{
				$em = Input::validate_email($email_d);
				if($em != false)
				{
					$to .= $em.',';
				}
			}
			$to = rtrim($to, ',');
		}
		else
		{
			$to = Input::validate_email($data['to']);
			if($to == false)
			{
				return false;
			}
		}
		if($to == '')
		{
				return false;
		}
		return @mail( $to, $data['subject'], $data['text'] );
	}
	
	public function index($params=null)
	{
		
		return true;
	}
	
	public function enviado($params=null)
	{
		global $configuracion, $POST;
		
		//Vamos a enviar un correo a los administradores del sitio
		$to = $configuracion['admin_email'];
		$from = $POST['name'];
		$femail = $POST['email'];
		$asunto = 'Consuta enviada desde '.$configuracion['app_name'].': '.$POST['asunto'];
		$texto = $POST['textarea'];
				
$msg = '
El usuario '.$from.' ('.$femail.') ha enviado la siguiente consulta:
-------------------------------------------------------------------
'.$texto.'
';		
	//Enviamos el correo
	$data = array(
	'to' => $to,
	'subject' => $asunto,
	'text' => $msg
	
	);
	$res = $this->send_text_email($data);
	if($res)
	{
		$exit['send_text'] = 'Su mensaje se ha enviado correctamente'; 
		$exit['send_text2'] = 'Muchas gracias por ponerse en contacto con '.$configuracion['app_name']; 
		$exit['send_id'] = 'desde-hasta';
	}
	else
	{
		$exit['send_text'] = 'Ha ocurrido un error al enviar su mensaje';
		$exit['send_text2'] = 'Por favor intente enviar de nuevo este formulario. Asegúrese de que no hay ningún campo vacío';
		$exit['send_id'] = 'desde-hasta2';
	}	
		return $exit;
	}
}
