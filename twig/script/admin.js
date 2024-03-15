$(document).ready(function () {
    // Function to load table data
    function loadTable(page) {
        $.ajax({
            url: "adminUserList.php",
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
            url: "adminUserList.php",
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

    // Delete code
    $(document).on("click", ".btn.btn-danger", function () {
        var confirmDelete = confirm("Do You Really want to Delete this record ?");
        var userId = $(this).data("id");
        var element = this;
        if (confirmDelete) {
            $.ajax({
                url: "adminUserList.php",
                type: "POST",
                data: {
                    id: userId
                },
                success: function (data) {
                    console.log("UserID:", userId);
                    if (data == 1) {
                        $(element).closest("tr").fadeOut();
                    } else {
                        $("#error-message").html("can't Delete Record.").slideDown();
                        $("#success-message").slideUp();
                    }
                },
                complete: function () {
                    loadTable();
                }
            });
        }
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

// // view
// $(document).ready(function () {
//     $(document).on("click", ".btn.btn-info", function () {
//         var updateId = $(this).data("eid");
//         $.ajax({
//             url: "viewUserData.php",
//             type: "POST",
//             data: {
//                 id: updateId
//             },
//             success: function (data) {
//                 console.log(updateId);
//                 $('.modal-content').html(data);
//                 $('#userData').modal('show');
//             }
//         });
//     });
// });


// view
// $(document).ready(function () {
//     $('view_data').click(function (e){
//         e.preventDefault();
//         var updateId = $(this).data("eid");
//         $.ajax({
//             url: "viewUserData.php",
//             type: "POST",
//             data: {
//                 id: updateId
//             },
//             success: function (respone) {
//                 $('.modal-content').html(respone);
//                 $('#userData').modal('show');
//             }
//         });
//         });
// });