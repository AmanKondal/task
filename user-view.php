<?php
$conn = mysqli_connect("localhost", "root", "", "record") or die("Connection failed:" . mysqli_connect_error());
$limit = 5;
$page = "";
if (isset($_POST["page_no"])) {
    $page = $_POST["page_no"];
} else {
    $page = 1;
}
$start = ($page - 1) * $limit;
$sql = "SELECT * FROM studentrecord LIMIT {$start},{$limit}";
$result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");
$output = "";
$a = 1;
if (mysqli_num_rows($result) > 0) {
    $output .= '
    <table class="table table-bordered table-dark">
        <tr class="table-info">
            <th scope="col">S.no</th>
            <th scope="col">Name</th>
            <th scope="col">Age</th>
            <th scope="col">Email-Id</th>
            <th scope="col">Phone-No</th>
            <th scope="col">Gender</th>
            <th scope="col">Image</th>
        </tr>
      ';
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<tr>
                <td scope='row'>$a</td>
                <td scope='row'>{$row['f_name']} {$row['l_name']}</td>
                <td scope='row'>{$row['age']}</td>
                <td scope='row'>{$row['emailId']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['gender']}</td>
                <td><img src='uploads/{$row['userimage']}' alt='User Image' width='50'></td>
              </tr>
             ";
        $a++;
    }
    $output .= " </table>";
    $sql_total = "SELECT * FROM studentrecord ";
    $records = mysqli_query($conn, $sql_total) or die("Query Unsuccessful.");
    $totalRecords = mysqli_num_rows($records);
    $totalPages = ceil($totalRecords / $limit);
    $output .= '<div id="pagination">
<center>  
<nav aria-label="Page navigation example">
<ul class="pagination">
';
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            $class_name = "active";
        } else {
            $class_name = "";
        }
        $output .= "<li class='page-item {$class_name}'><a class='page-link'  id='{$i}' href='?page_no={$i}'>{$i}</a></l>";
    }
    $output .= ' </ul>
</nav>
</center></div>';
    echo $output;
} else {
    echo "<h2>No Record Found.";
}
