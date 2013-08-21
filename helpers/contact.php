<?php 
//defined('_JEXEC') or die;
define( '_JEXEC', 1 );
define('JPATH_BASE', dirname(dirname(__FILE__)));
define( 'DS', DIRECTORY_SEPARATOR );

require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');

jimport('joomla.mail.helper');
jimport('joomla.filesystem.file');

$app = JFactory::getApplication('site');
$app->initialise();

$data =  $_POST;

//notificacion por email de una nueva reservacion

$asunto = "Contact Form in 3monkiescr"; 



$cuerpo = '

<strong>Nombre:</strong> '.$data['namec'].'<br />
<strong>Email:</strong> '.  $data['emailc'].'<br />
<strong>Comentarios: </strong>'.  $data['comments'];


/*$config =& JFactory::getConfig();
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


		
	


?>