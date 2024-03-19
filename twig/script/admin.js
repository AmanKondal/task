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


    // Delete Button
    $(document).on("click", ".btn.btn-danger", function () {
        var confirmDelete = confirm("Do You Really want to Delete this record ?");
        var userId = $(this).data("id");
        var element = this;
        if (confirmDelete) {
            $.ajax({
                url: "delete.php",
                type: "POST",
                data: {
                    id: userId
                },
                success: function (data) {
                    console.log("UserID:", userId);
                    if (data == 1) {
                        $(element).closest("tr").fadeOut();
                        showToast("Record deleted successfully", "success");

                    } else {
                        showToast("Failed to delete record", "error");
                    }
                },
                error: function () {
                    showToast("Error deleting record", "error");
                },
            });
        }
    });



    // Sort table code
    $(document).on("change", "#sort-order", function () {
        var sortOrder = $(this).val();
        sortTable(sortOrder);
    });

    $(document).on("click", ".Sorting a", function (e) {
        e.preventDefault();
        var page_id = $(this).attr("id");
        sortTable(page_id);
    });

    // Function to sort table
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



$(document).on("click", ".btn.btn-primary", function () {
    $.ajax({
        url: "userUpdate.php",
        type: "POST",
        data: $("#myForm").serialize(),
        success: function (respone) {
            console.log(respone);
            if (data == 1) {
                showToast("Record Update successfully", "success");
            } else {
                showToast("Failed to Update record", "error");
            }
        },
        error: function () {
            showToast("Error in Updating record", "error");
        },
    });
});
function showToast(message, type) {
    var toastElement = $(".toast");
    var toastBody = $(".toast-body");
    toastBody.text(message);
    toastElement.removeClass("bg-success bg-error");
    if (type === "success") {
        toastElement.addClass("bg-success");
    } else if (type === "error") {
        toastElement.addClass("bg-error");
    }
    toastElement.toast({ delay: 2000 }).toast("show");
    setTimeout(function () {
        toastElement.toast("hide");
    }, 5000);
}
