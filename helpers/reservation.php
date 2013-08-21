<?php 
//defined('_JEXEC') or die;
define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(dirname(__FILE__)));
define( 'DS', DIRECTORY_SEPARATOR );

require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');

jimport('joomla.mail.helper');



//notificacion por email de una nueva reservacion o comentario de contacto

$data =  $_POST;

$tipo= $data['type'];

$asunto = "Reservation in 3monkiescr"; 

if ($tipo == 'tour'){
	$actividades = $data['Activitie'];
	$cuerpo = '

	<h1>Datos de Reservacion:</h1>


	<strong>Tipo:</strong> '.$data['type'] .'<br />
	<strong>Activities:</strong> '.json_encode($actividades).'<br />
	<strong>Category:</strong> '.$data['category'].'<br />
	<strong>Pickup Location:</strong> '.$data['pickuplocation'].'<br />
	<strong>Drop Off:</strong> '.$data['dropoff'].'<br />
	<strong>Date:</strong> '.$data['date'].'<br />
	<strong>First Name:</strong> '.$data['fname'].'<br />
	<strong>Last Name:</strong> '.$data['lname'].'<br />
	<strong>Email:</strong> '.  $data['email'].'<br />
	<strong>Adults: </strong>'.  $data['Adults'].'<br />
	<strong>Childrens:</strong> '.  $data['Childrens'].'<br />
	<strong>Important Notes:</strong> '.  $data['notes'];

}
else
	{
		$cuerpo= '

		<h1>Datos de Reservacion:</h1>


		<strong>Tipo:</strong> '.$data['type'] .'<br />
		<strong>Pickup From:</strong> '.$data['pickupfrom'].'<br />
		<strong>To Destination:</strong> '.$data['todestination'].'<br />
		<strong>Date:</strong> '.$data['dateP'].'<br />
		<strong>Time:</strong> '.$data['time'].'<br />
		<strong>Passengers:</strong> '.$data['passengers'].'<br />
		<strong>Flight #:</strong> '.$data['flight'].'<br />
		<strong>First Name:</strong> '.$data['fnameP'].'<br />
		<strong>Last Name:</strong> '.$data['lnameP'].'<br />
		<strong>Email:</strong> '.  $data['emailP'].'<br />
		<strong>Important Notes:</strong> '.  $data['notesP'];
	}
/*$config = JFactory::getConfig();
$emailuser= array( 
			$config->getValue( 'config.mailfrom' ),
			$config->getValue( 'config.fromname' )
			 );*/
$emailuser = 'alonso@avotz.com';
$destinatario = 'alons182@hotmail.com'; //$email_yokue;





//verificamos los datos con los métodos de JMailHelper
if(!JMailHelper::isEmailAddress($destinatario))return false;
if(!JMailHelper::cleanAddress($destinatario)) return false;
//limpiamos el asunto de posible código malicioso 
$subject = JMailHelper::cleanSubject($asunto); 
//limpiamos el mensaje (cuerpo del email) de posible código malicioso

$body = JMailHelper::cleanText($cuerpo); 



$mailer = JFactory::getMailer(); 
$mailer->isHtml(true);

$mailer->setSender($emailuser); 
$mailer->addRecipient($destinatario); 
$mailer->setSubject($asunto); 
$mailer->setBody($body); 
if($mailer->send()) 
	echo 'ok';
else
  echo 'error';


		


	
	
	


?>