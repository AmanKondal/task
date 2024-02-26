<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="Untitled-1.js"></script>
    <title>Document</title>
    <style>
        .pagination {
            justify-content: center;
        }
    </style>
</head>

<body>

    <nav>
        <a href="index.php" class="btn btn-primary">Create-User</a>
    </nav>
    <div id="search" style="position: absolute; right: 80px; top: 5px; margin-right: 10px;">
        <label>Search</label>
        <input type="text" id="searchInput" autocomplete="off">
    </div>
    <button class="btn btn-warning" id="resetButton" style="position: absolute; right: 10px; top: 2px; margin-right: 10px;">Reset</button>
    <div id="table-data">
    </div>
    <script>
        $(document).ready(function() {
            function loadsearch(page) {
                var search_term = $("#searchInput").val();
                $.ajax({
                    url: "user-view-db.php",
                    type: "POST",
                    data: {
                        search: search_term,
                        page_no: page
                    },
                    success: function(data) {
                        $("#table-data").html(data);
                    }
                });
            }
            
            $(document).on("keyup", "#searchInput", function() {
                loadsearch();
            });
            // code for pagination search
            $(document).on("click", ".pagination a", function(e) {
                e.preventDefault();
                var page_id = $(this).attr("id");
                loadsearch(page_id);
            });
          
            // user-view load code 
            function loadTable(page) {
                $.ajax({
                    url: "user-view-db.php",
                    type: "POST",
                    data: {
                        page_no: page
                    },
                    success: function(data) {
                        $("#table-data").html(data);
                    }
                });
            }

            loadTable();
            // pagination for user-view
            $(document).on("click", ".pagination a", function(e) {
                e.preventDefault();
                var page_id = $(this).attr("id");
                loadTable(page_id);
            });
            
            // Rest Code 
            $("#resetButton").click(function() {
                $("#searchInput").val('');
                loadTable();
            });
        });

    </script>
</body>

</html>