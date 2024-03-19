<?php
session_start();
require_once '../../vendor/autoload.php';
require_once '../../model/user.php';
$loader = new Twig\Loader\FilesystemLoader('../../view/user',);
$twig = new Twig\Environment($loader);
$database = new Database();
$limit = 5;
$email = $_SESSION['email'];
$searchValue = isset($_POST['search']) ? $_POST['search'] : '';
$sortOrder = isset($_POST['sort_order']) ? $_POST['sort_order'] : '';
$page = isset($_POST["page_no"]) ? $_POST["page_no"] : 1;
$sno = ($page - 1) * $limit + 1;
if ($searchValue !== "") {
    $result = $database->searchUser($searchValue, (int)$limit);
    $total_record = $database->getTotalRecords(['f_name'], $searchValue);
    $total_page = ceil($total_record / $limit);
    echo $twig->render('UserViewList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'searchValue' => $searchValue, 'email' => $email]);
}elseif($sortOrder !==''){
    $result=$database->getUsersSorted($sortOrder,$limit);
    $total_record = $database->getTotalRecords();
    $total_page = ceil($total_record / $limit);
    echo $twig->render('UserViewList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'email' => $email]);
} 
else {
    $result = $database->selectAllUser($limit, $page);
    $total_record = $database->getTotalRecords();
    $total_page = ceil($total_record / $limit);
    echo $twig->render('UserViewList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'email' => $email]);
}

?>
