<?php
require_once '../../vendor/autoload.php';
require_once '../../model/user.php';
$loader = new Twig\Loader\FilesystemLoader('../../view/user');
$twig = new Twig\Environment($loader);
$database = new Database();
$updateid = isset($_POST["id"]) ? $_POST["id"] : null;
$result = $database->userData($updateid);
echo $twig->render('loginUserData.twig', ['row' => $result]);
