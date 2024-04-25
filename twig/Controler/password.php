<?php
require_once '../vendor/autoload.php';
require_once '../model/user.php';
$database = new Database();

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader('../view');
$twig = new Environment($loader);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $userData = array(
        'uid' => $uid,
        'email' => $email,
        'password' => $password,
    );
    $result = $database->updatePassword($userData);
    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
}
