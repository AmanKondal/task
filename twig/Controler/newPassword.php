<?php
require '../model/user.php';
require_once '../vendor/autoload.php';

$loader = new Twig\Loader\FilesystemLoader([
    '../view'
]);
$twig = new Twig\Environment($loader);
$database = new Database();
if (isset($_GET['token'])) {
    $token = $_GET['token'];

}
$result = $database->dataGet($token);
if($result){

    echo $twig->render('newPassword.twig', [
        'result' => $result,
    ]);
}else{
    echo "You Alreday Update Your password";
}
