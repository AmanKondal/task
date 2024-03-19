    function loadSearch(page) {
        var search_term = $("#searchInput").val();
        $.ajax({
            url: "userViewList.php",
            type: "POST",
            data: {
                search: search_term,
            },
            success: function (data) {
                $("#table-data").html(data);
            }
        });
    }
