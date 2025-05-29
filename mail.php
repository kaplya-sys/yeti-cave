<?php
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
require_once('vendor/autoload.php');
require_once('config.php');

$dsn = "smtp://$mail_username:$mail_password@$mail_smtp_url:$mail_smtp_port?encryption=tls&auth_mode=login";
$transport = Transport::fromDsn($dsn);

$message = new Email();
$message->to($mail_to_address);
$message->from($mail_from_address);

$mailer = new Mailer($transport);
?>