<?php
require_once '../../vendor/autoload.php';
require_once '../../model/user.php';
$loader = new Twig\Loader\FilesystemLoader([
    '../../view/admin',
    '../../view/include',
]);
$database = new Database();
$twig = new Twig\Environment($loader);
$database->loginSession();
if (isset($_SESSION['email'])) {
    $id = $_SESSION['uid'];
    $query = $database->userData($id);
    var_dump($query);
}
echo $twig->render('adminView.twig');
?>