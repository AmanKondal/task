<?php
session_start();
require_once '../../vendor/autoload.php';
require_once '../../model/user.php';
$loader = new Twig\Loader\FilesystemLoader([
    '../../view/admin',
    '../../view/include',
]);
$database = new Database();
$twig = new Twig\Environment($loader);
echo $twig->render('adminView.twig');
?>