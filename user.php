<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Document</title>
    <style>
        .pagination {
            justify-content: center;
        }
    </style>
</head>

<body>
    <nav>
        <a href="index.php" class="btn btn-success">Create-User</a>
    </nav>
    <div id="search" style="position: absolute; right: 4px; top: 5px; margin-right: 10px;">
        <label>Search</label>
        <input type="text" id="searchInput" autocomplete="off">
    </div>


    <center><?php include 'main.php'; ?></center>
    <div id="table-data">
    </div>
    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var search_term = $(this).val();
                $.ajax({
                    url: "search-user.php",
                    type: "POST",
                    data: {
                        search: search_term
                    },
                    success: function(data) {
                        $("#table-data").html(data);
                    }
                })
            })
            function loadTable(page) {
                $.ajax({
                    url: "user-view.php",
                    type: "POST",
                    data: {
                        page_no: page
                    },
                    success: function(data) {
                        $("#table-data").html(data);
                    }
                })
            }
            loadTable();
            $(document).on("click", "#pagination a", function(e) {
                e.preventDefault();
                var page_id = $(this).attr("id");
                loadTable(page_id);
            });
        })
    </script>

</body>

</html>