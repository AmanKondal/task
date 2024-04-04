<?php
session_start();
require_once '../../vendor/autoload.php';
require_once '../../service/Service.php';
require_once '../pagination.php';
$loader = new Twig\Loader\FilesystemLoader([
    '../../view/user'
]);
$twig = new Twig\Environment($loader);
$userService = new UserService();
$limit = 5;
$offset = !empty($_POST['page']) ? $_POST['page'] : 1;
$sno = $offset;
$searchValue = isset($_POST['search']) ? $_POST['search'] : '';
$sortSQL = '';
$sortOrder = 'ASC';
if (!empty($_POST['coltype']) && !empty($_POST['colorder'])) {
    $coltype = $_POST['coltype'];
    $colorder = $_POST['colorder'];
    $sortSQL = " $coltype $colorder";
    $sortOrder = strtoupper($colorder);
}
$result = $userService->getUsers($limit, $offset, $searchValue, $sortSQL);
$total_record = $userService->getTotalRecords($searchValue);
$pagination = new Pagination([
    'totalRows' => $total_record,
    'perPage' => $limit,
    'currentPage' => $offset,
    'contentDiv' => 'dataContainer',
    'link_func' => 'columnSorting'
]);
$paginationLinks = $pagination->createLinks();
echo $twig->render('userViewList.twig', ['result' => $result, 'sno' => $sno, 'paginationLinks' => $paginationLinks]);
