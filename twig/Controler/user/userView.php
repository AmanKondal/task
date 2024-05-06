<?php
session_start();
$userprofile = $_SESSION['email'];
$username = $_SESSION['f_name'];
$uid = $_SESSION['uid'];

if ($userprofile == true) {

    // Check if the login message session variable is set
    if (!isset($_SESSION['login_message_displayed'])) {
        $loginMessage = "Login successful."; // Set login message
        $_SESSION['login_message_displayed'] = true; // Set session variable to indicate that the message has been displayed
    } else {
        $loginMessage = ""; // Initialize login message variable
    }

require_once '../../vendor/autoload.php';
require_once '../../model/user.php';
$loader = new Twig\Loader\FilesystemLoader([
    '../../view/user',
    '../../view/include',
]);
$database = new Database();
$twig = new Twig\Environment($loader);
echo $twig->render('userView.twig',['name'=>$username,'email'=>$userprofile,'uid'=>$uid, 'loginMessage' => $loginMessage]);
}else {
    header('location:../../index.php');
}
?>