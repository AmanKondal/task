<?php
session_start();
require_once '../../vendor/autoload.php';
require_once '../../model/user.php';
$loader = new Twig\Loader\FilesystemLoader(
    '../../view/admin',
    '../../view/notification',
);
$twig = new Twig\Environment($loader);
$database = new Database();
$limit = 5;
$searchValue = isset($_POST['search']) ? $_POST['search'] : '';
$email = $_SESSION['email'];
$sortOrder = isset($_POST['sort_order']) ? $_POST['sort_order'] : '';
$page = isset($_POST["page_no"]) ? $_POST["page_no"] : 1;
$sno = ($page - 1) * $limit + 1;
if ($searchValue !== "") {
    $result = $database->searchUser($searchValue, (int)$limit);
    $total_record = $database->getTotalRecords(['f_name'], $searchValue);
    $total_page = ceil($total_record / $limit);
    echo $twig->render('adminUserList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'searchValue' => $searchValue, 'email' => $email, 'sortOrder' => $sortOrder]);
} elseif ($sortOrder !== '') {
    $result = $database->getUsersSorted($sortOrder, $limit);
    $total_record = $database->getTotalRecords();
    $total_page = ceil($total_record / $limit);
    echo $twig->render('adminUserList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'email' => $email, 'sortOrder' => $sortOrder]);
} else {
    $result = $database->selectAllUser($limit, $page);
    $total_record = $database->getTotalRecords();
    $total_page = ceil($total_record / $limit);
    echo $twig->render('adminUserList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'email' => $email, 'sortOrder' => $sortOrder]);
}

// <?php
// session_start();
// require_once '../../vendor/autoload.php';
// require_once '../../model/user.php';

// if (!isset($_SESSION['sort_order'])) {
//     $_SESSION['sort_order'] = ''; // Set default sort order if not set
// }

// // Store sorting order in session
// if (isset($_POST['sort_order'])) {
//     $_SESSION['sort_order'] = $_POST['sort_order'];
// var_dump($_SESSION);
// }

// $loader = new Twig\Loader\FilesystemLoader(
//     '../../view/admin',
//     '../../view/notification',
// );
// $twig = new Twig\Environment($loader);
// $database = new Database();
// $limit = 5;
// $searchValue = isset($_POST['search']) ? $_POST['search'] : '';
// $email = $_SESSION['email'];
// $sortOrder = isset($_POST['sort_order']) ? $_POST['sort_order'] : '';

// $page = isset($_POST["page_no"]) ? $_POST["page_no"] : 1;
// $sno = ($page - 1) * $limit + 1;

// if ($searchValue !== "") {
//     $result = $database->searchUser($searchValue, (int)$limit);
//     $total_record = $database->getTotalRecords(['f_name'], $searchValue);
//     $total_page = ceil($total_record / $limit);
//     echo $twig->render('adminUserList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'searchValue' => $searchValue, 'email' => $email, 'sortOrder' => $_SESSION['sort_order']]);
// } elseif ($_SESSION['sort_order']) {
//     $result = $database->getUsersSorted($_SESSION['sort_order'], $limit); // Corrected $_SESSION['sort_order']
//     $total_record = $database->getTotalRecords();
//     $total_page = ceil($total_record / $limit);
//     echo $twig->render('adminUserList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'email' => $email, 'sortOrder' => $_SESSION['sort_order']]);
// } else {
//     // Handle case when neither search nor sorting is applied
//     $result = $database->selectAllUser($limit, $page);
//     $total_record = $database->getTotalRecords();
//     $total_page = ceil($total_record / $limit);
//     echo $twig->render('adminUserList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'email' => $email, 'sortOrder' => $_SESSION['sort_order']]);
// }