<html>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<div class="modal" id="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>

</html>
<?php
include 'main_db.php';
$database = new Database();
$table = 'studentrecord';
$rows = '*';
$limit = 5;
$searchValue = isset($_POST['search']) ? $_POST['search'] : '';
$page = isset($_POST["page_no"]) ? $_POST["page_no"] : 1;

if ($searchValue !== "") {
    $columns = array('f_name');
    $result = $database->search($table, $columns, $searchValue, $limit, $rows);
    $total_record = $database->count($table, $columns, $searchValue);
    $total_page = ceil($total_record / $limit);
} else {
    $result = $database->select($table, $rows, $limit, $page);
    $total_record = $database->count($table);
    $total_page = ceil($total_record / $limit);
}

$sno = ($page - 1) * $limit + 1;

if (!empty($result)) {
?>
    <center><?php include 'message.php' ?></center>
    <table class='table table-bordered table-dark'>
        <tr class='table-info'>
            <th scope='col'>S.no</th>
            <th scope='col'>Name</th>
            <th scope='col'>Age</th>
            <th scope='col'>Email-Id</th>
            <th scope='col'>Phone-No</th>
            <th scope='col'>Gender</th>
            <th scope='col'>Image</th>
            <th scope='col'>Action</th>
        </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td scope='row'>$sno</td>
                <td scope='row'>{$row['f_name']} {$row['l_name']}</td>
                <td scope='row'>{$row['age']}</td>
                <td scope='row'>{$row['emailId']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['gender']}</td>
                <td><img src='uploads/{$row['userimage']}' alt='User Image' width='50'></td>
                <td>
                    <button type='submit' class='btn btn-success' data-eid='{$row['id']}'>Edit</button>
                    <button type='submit' class='btn btn-danger' data-id='{$row['id']}'>Delete</button>
                </td>
            </tr>";
        $sno++;
    }
    echo "</table>";
    echo "<ul class='pagination'>";
    for ($i = 1; $i <= $total_page; $i++) {
        $class_name = ($i == $page) ? "active" : "";
        if ($searchValue !== "") {
            echo "<li class='Search-item $class_name'><a class='page-link' id='{$i}' href='?page=$i&search=$searchValue'>$i</a></li>";
        } else {
            echo "<li class='page-item $class_name'><a class='page-link' id='{$i}' href='?page=$i'>$i</a></li>";
        }
    }
    echo "</ul>";
} else {
    echo "<h2>No Record Found.</h2>";
}
    ?>