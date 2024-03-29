$(document).ready(function () {
    // Function to load table data
    function loadTable(page) {
        $.ajax({
            url: "userViewList.php",
            type: "POST",
            data: {
                page_no: page
            },
            success: function (data) {
                $("#table-data").html(data);
            }
        });
    }

    // Load table data initially
    loadTable();

    // Pagination for user-view
    $(document).on("click", ".page-link a", function (e) {
        e.preventDefault();
        var page_id = $(this).attr("id");
        loadTable(page_id);
    });

    // Search code
    function loadSearch(page) {
        var search_term = $("#searchInput").val();
        $.ajax({
            url: "userViewList.php",
            type: "POST",
            data: {
                search: search_term,
                page_no: page
            },
            success: function (data) {
                $("#table-data").html(data);
            }
        });
    }

    // Trigger search on keyup
    $(document).on("keyup", "#searchInput", function () {
        loadSearch();
    });

    // Code for pagination search
    $(document).on("click", ".page-item a", function (e) {
        e.preventDefault();
        var page_id = $(this).attr("id");
        loadSearch(page_id);
    });

    // Reset button code
    $("#resetButton").click(function () {
        $("#searchInput").val('');
        loadTable();
    });

    // Sort table code
    $(document).on("change", "#sort-order", function () {
        var sortOrder = $(this).val();
        sortTable(sortOrder);
    });

    function sortTable(order) {
        var currentPage = $("#current_page").val();
        $.ajax({
            url: "adminUserList.php",
            type: "POST",
            data: {
                page_no: currentPage,
                sort_order: order
            },
            success: function (data) {
                $("#table-data").html(data);
            }
        });
    }
});
$(document).on("click", "#sorting a", function (e) {
    e.preventDefault();
    var page_id = $(this).attr("id");
    sortTable(page_id);
});

// view
$(document).ready(function () {
    $(document).on("click", ".btn.btn-info", function () {
        var updateId = $(this).data("eid");
        $.ajax({
            url: "UserData.php",
            type: "POST",
            data: {
                id: updateId
            },
            success: function (data) {
                $("#modal .modal-content").html(data);
                $("#modal").modal("show");
            }
        });
    });
});



$(document).ready(function () {
    $('#email').blur(function () {
        var email = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'signUp.php',
            data: { email: email },
            success: function (response) {
                if (response === 'exists') {
                    $('#email-error').text('Email already exists');
                } else {
                    $('#email-error').text('');
                }
            }
        });
    });
});
