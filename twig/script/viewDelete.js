$(document).ready(function ($) {
    $(document).on("click", ".btn.btn-info", function () {
        var updateId = $(this).data("eid");
        $.ajax({
            url: "viewUserData.php",
            type: "POST",
            data: {
                id: updateId
            },
            success: function (data) {
                $('.modal-content').html(data);
                $('#userData').modal('show');
            }
        });
    });
});



// $(document).on("click", ".btn.btn-primary", function () {
//         $.ajax({
//             url: "userUpdate.php",
//             type: "POST",
//                 data: $("#myForm").serialize(),
//             success: function (data) {
//                 console.log(data);
//                 if (data == 1) {
//                     showToast("Record Update successfully", "success");
//                 } else {
//                     showToast("Failed to Update record", "error");
//                 }
//             },
//             error: function () {
//                 showToast("Error in Updating record", "error");
//             },
//         });
// });

// function showToast(message, type) {
//     var toastElement = $(".toast");
//     var toastBody = $(".toast-body");
//     toastBody.text(message);
//     toastElement.removeClass("bg-success bg-error");
//     if (type === "success") {
//         toastElement.addClass("bg-success");
//     } else if (type === "error") {
//         toastElement.addClass("bg-error");
//     }
//     toastElement.toast({ delay: 2000 }).toast("show");
//     setTimeout(function () {
//         toastElement.toast("hide");
//     }, 5000);
// }
