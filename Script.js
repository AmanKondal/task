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
    $(document).on("click", ".Search-item a", function(e) {
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
    $(document).on("click", ".page-item a", function(e) {
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
