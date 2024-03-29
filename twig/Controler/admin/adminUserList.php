<?php
session_start();
require_once '../../vendor/autoload.php';
require_once '../../model/user.php';
require_once '../pagination.php';

$loader = new Twig\Loader\FilesystemLoader(
    '../../view/admin',
    '../../view/notification',
);
$twig = new Twig\Environment($loader);
$database = new DataBase();
$limit = 5;
$offset = !empty($_POST['page']) ? $_POST['page'] : 0;
$searchValue = isset($_POST['search']) ? $_POST['search'] : '';
$sortSQL = '';
$sortOrder = 'ASC';
if (!empty($_POST['coltype']) && !empty($_POST['colorder'])) {
    $coltype = $_POST['coltype'];
    $colorder = $_POST['colorder'];
    $sortSQL = " $coltype $colorder";
    $sortOrder = strtoupper($colorder);
}
if ($searchValue !== "") {
    $result = $database->searchUser($searchValue,$offset, $limit);
} elseif ($sortSQL !== '') {
    $result = $database->getUsersSorted($sortOrder, $offset, $limit);
    
} else {
    $result = $database->selectAllUser($limit, $offset);
}
$total_record = $database->getTotalRecords(['f_name'], $searchValue);

$pagination = new Pagination([
    'totalRows' => $total_record,
    'perPage' => $limit,
    'currentPage' => $offset,
    'contentDiv' => 'dataContainer',
    'link_func' => 'columnSorting'
]);
$paginationLinks = $pagination->createLinks();
$email = $_SESSION['email'];
echo $twig->render('adminUserList.twig', ['result' => $result, 'email' => $email, 'paginationLinks' => $paginationLinks]);
