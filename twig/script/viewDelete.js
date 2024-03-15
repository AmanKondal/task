jQuery(document).ready(function ($) {
    $(document).on("click", ".btn.btn-info", function () {
        var updateId = $(this).data("eid");
        $.ajax({
            url: "viewUserData.php",
            type: "POST",
            data: {
                id: updateId
            },
            success: function (data) {
                console.log(updateId);
                $('.modal-content').html(data);
                $('#userData').modal('show');
            }
        });
    });
});
