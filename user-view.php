<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<div class="modal" id="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>

<?php
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
                <th scope="col">Action</th>
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
                    <td><button type='button' class='btn btn-success' data-eid='{$row['id']}'>Edit</button>
                    <button type='button' class='btn btn-danger' data-id='{$row['id']}'>Delete</button>
                        </td>
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
} ?>
<script>
    $(document).on("click", ".btn.btn-danger", function() {
        if (confirm("Do You Really want to Delete this record ?")) {
            var userId = $(this).data("id");
            var element = this;
            $.ajax({
                url: "Delete.php",
                type: "POST",
                data: {
                    id: userId
                },
                success: function(data) {
                    if (data == 1) {
                        $(element).closest("tr").fadeOut();
                    } else {
                        $("#error-message").html("can't Delete Record.").slideDown();
                        $("#success-message").slideUp();
                    }
                }
            })
        }
    });
    $(document).on("click", ".btn.btn-success", function() {
        if (confirm("Do You Really want to Update this record ?")) {
            var updateId = $(this).data("eid");
            $.ajax({
                url: "update.php",
                type: "POST",
                data: {
                    id: updateId // Make sure to include the id parameter
                },
                success: function(data) {
                    // Load the modal content
                    $("#modal .modal-content").html(data);
                    // Show the modal
                    $("#modal").modal("show");
                }
            });
        }
    });
</script>