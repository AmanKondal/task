<?php
require_once '../../vendor/autoload.php';
require_once '../../model/user.php';
$loader = new Twig\Loader\FilesystemLoader('../../view/admin',
'../../view/notification',);
$twig = new Twig\Environment($loader);
$database = new Database();
$limit = 5;
$database->loginSession();
$searchValue = isset($_POST['search']) ? $_POST['search'] : '';
if (isset($_SESSION['email'])) {
    $id = $_SESSION['uid'];
    $query = $database->userData($id);
    var_dump($query);
}
$sortOrder = isset($_POST['sort_order']) ? $_POST['sort_order'] : '';
$page = isset($_POST["page_no"]) ? $_POST["page_no"] : 1;
$sno = ($page - 1) * $limit + 1;
if ($searchValue !== "") {
    $result = $database->searchUser($searchValue, (int)$limit);
    $total_record = $database->getTotalRecords(['f_name'], $searchValue);
    $total_page = ceil($total_record / $limit);
    echo $twig->render('adminUserList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'searchValue' => $searchValue, 'query' => $query]);
}elseif($sortOrder !==''){
    $result=$database->getUsersSorted($sortOrder,$limit);
    $total_record = $database->getTotalRecords();
    $total_page = ceil($total_record / $limit);
    echo $twig->render('adminUserList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'query' => $query]);
} 
else {
    $result = $database->selectAllUser($limit, $page);
    $total_record = $database->getTotalRecords();
    $total_page = ceil($total_record / $limit);
    echo $twig->render('adminUserList.twig', ['result' => $result, 'total_page' => $total_page, 'current_page' => $page, 'sno' => $sno, 'query' => $query]);
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $deleted = $database->deleteUser($id);
    if ($deleted) {
        echo '<script>$("#notification").text("User deleted successfully.").fadeIn().delay(3000).fadeOut();</script>';
    } else {
        echo '<script>$("#notification").text("Failed to delete user.").fadeIn().delay(3000).fadeOut();</script>';
    }
    exit;
}

?>
