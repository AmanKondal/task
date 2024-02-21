<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="modal" id="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Content will be loaded dynamically here -->
        </div>
    </div>
</div>

<?php
include 'main_db.php';
$database = new Database();
$limit = 5;
$rows = '*';
$table = 'studentrecord';
$result = $database->Select($table, $rows, $limit);
$output = "";
$sno = 1;

if (!empty($result)) {
    echo "<table class='table table-bordered table-dark'>
            <tr class='table-info'>
                <th scope='col'>S.no</th>
                <th scope='col'>Name</th>
                <th scope='col'>Age</th>
                <th scope='col'>Email-Id</th>
                <th scope='col'>Phone-No</th>
                <th scope='col'>Gender</th>
                <th scope='col'>Image</th>
                <th scope='col'>Action</th>
            </tr>";

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

    echo "<div class='center'>" . $database->pagination($table, $limit) . "</div>";
} else {
    echo "<h2>No Record Found.</h2>";
}
?>

</body>
</html>
