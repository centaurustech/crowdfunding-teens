<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

/*
|--------------------------------------------------------------------------
| Protocolo de envio de correo
|--------------------------------------------------------------------------
 */
$config['protocol'] = 'smtp';

/*
|--------------------------------------------------------------------------
| Dirección SMTP del servidor
|--------------------------------------------------------------------------
 */
$config['smtp_host'] = 'mail.betadevconsult.com.br';

/*
|--------------------------------------------------------------------------
| Usuario SMTP
|--------------------------------------------------------------------------
 */
$config['smtp_user'] = 'no-reply@betadevconsult.com.br';// remplazarlo por un cuenta real de Gmail - usuario SMTP

/*
|--------------------------------------------------------------------------
| Password
|--------------------------------------------------------------------------
 */
$config['smtp_pass'] = 's04PQFb2+0mw';

/*
|--------------------------------------------------------------------------
| Puerto SMTP
|--------------------------------------------------------------------------
 */
$config['smtp_port'] = '587';// 465 o el '587' --  Puerto SMTP

/*
|--------------------------------------------------------------------------
| Tiempo de espera SMTP(segundos)
|--------------------------------------------------------------------------
 */
$config['smtp_timeout'] = '7';

/*
|--------------------------------------------------------------------------
| Nueva linea
|--------------------------------------------------------------------------
 */
//$config['email']['newline']  = '\r\n';

/*
|--------------------------------------------------------------------------
| Formato del mensaje
|--------------------------------------------------------------------------
|
| html para formato con texto enriquecido (HTML)
| txt para formato en texto plano
|
 */
$config['mailtype'] = 'html';

$config['charset'] = 'utf-8';

$config['validation'] = TRUE;

/* End of file email.php */
/* Location: ./application/config/email.php */