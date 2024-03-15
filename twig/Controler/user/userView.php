<?php
require_once '../../vendor/autoload.php';
require_once '../../model/user.php';
$loader = new Twig\Loader\FilesystemLoader([
    '../../view/user',
    '../../view/include',
]);
$database = new Database();
$twig = new Twig\Environment($loader);
$database->loginSession();
echo $twig->render('userView.twig');
?>