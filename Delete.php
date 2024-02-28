<?php
include 'main_db.php';
$database = new Database();
$table = 'studentrecord';
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $deleted = $database->deleteRecord($table, $id);
    if ($deleted) {
        echo 1;     
    } else {
        echo 0;
    }
}
?>