<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Document</title>
    <style>
        .pagination {
            justify-content: center;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <nav>
        <a href="index.php" class="btn btn-success">Create-User</a>
    </nav>
    <center><?php include 'main.php'; ?></center>
    <?php
    $conn = mysqli_connect("localhost", "root", "", "record") or die("Connection failed:" . mysqli_connect_error());
    $limit = 5;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;
    $selectQuery = "SELECT * FROM studentrecord LIMIT $start,$limit";
    $result = mysqli_query($conn, $selectQuery);
    if ($result) {
        $a = $start + 1;
    ?>
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
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                          <td scope='row'>$a</td>
                          <td scope='row'>{$row['f_name']} {$row['l_name']}</td>
                          <td scope='row'>{$row['age']}</td>
                          <td scope='row'>{$row['emailId']}</td>
                          <td>{$row['phone']}</td>
                          <td>{$row['gender']}</td>
                          <td><img src='uploads/{$row['userimage']}' alt='User Image' width='50'></td>
                      </tr>";
                $a++;
            }
            ?>
        </table>

        <center>
            <nav aria-label='Page navigation example'>
                <ul class='pagination'>
                    <?php
                    $paginationQuery = "SELECT COUNT(id) as total FROM studentrecord";
                    $paginationResult = mysqli_query($conn, $paginationQuery);
                    $paginationRow = mysqli_fetch_assoc($paginationResult);
                    $totalRecords = $paginationRow['total'];
                    $totalPages = ceil($totalRecords / $limit);
                    if ($page > 1) {
                        echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "'>Previous</a></li>";
                    }

                    for ($i = 1; $i <= $totalPages; $i++) {
                        $active = ($i == $page) ? 'active' : '';
                        echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
                    }
                    if ($page < $totalPages) {
                        echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "'>Next</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </center>
    <?php
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    ?>
</body>
<script>
        $(document).ready(function () {
            function refreshTable(page) {
                $.ajax({
                    url: 'user.php',  
                    type: 'POST', 
                    data: { page: page },
                    success: function (data) {
                        $('#table-container').html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Error fetching data. Check console for details.');
                    }
                });
            }
            refreshTable(1);
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                var page = $(this).attr('href').split('=')[1];
                refreshTable(page);
            });
        });
    </script>
</html>
