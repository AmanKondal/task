<?php
require_once '../vendor/autoload.php';
require_once '../model/user.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$database = new Database();

$loader = new FilesystemLoader('../view');
$twig = new Environment($loader);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $email = $_POST['email'];
    $token = $_POST['token'];

    $tokenIsValid = $database->validateToken($uid, $token);

    if ($tokenIsValid) {
        $password = md5($_POST['password']);
        $userData = array(
            'uid' => $uid,
            'email' => $email,
            'password' => $password,
        );

        $result = $database->updatePassword($userData);
        if ($result) {
            echo 1; // Password updated successfully
        } else {
            echo 0; // Password update failed
        }
    } else {
        echo "You already Update your Password";
    }
}
