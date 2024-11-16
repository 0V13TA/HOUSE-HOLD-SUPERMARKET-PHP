<?php

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$directory = str_replace('\CONFIG', '', __DIR__);
require $directory . '\vendor\autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($directory);
$dotenv->load();



$mail = new PHPMailer(true);

// Server settings
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = $_ENV['EMAIL_ADDRESS']; // Your Gmail address
$mail->Password   = $_ENV['EMAIL_PASSWORD']; // The app password you generated
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port       = 465;
$mail->SMTPDebug = 2; // Enable verbose debug output
$mail->Debugoutput = 'html'; // Output format