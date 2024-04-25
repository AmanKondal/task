<?php

require_once '../vendor/autoload.php';
require '../model/user.php';
$loader = new Twig\Loader\FilesystemLoader('../view');
$twig = new Twig\Environment($loader);
if (isset($_POST['email'])) {
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);
   $database = new Database();
   $error = '';
   $message='';
}
$emailSent = $database->emailSend($email);
if($emailSent){
echo 1;
}else{
echo 0;
}