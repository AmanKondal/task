<?php
$updateid = isset($_POST["id"]) ? $_POST["id"] : null;

if ($updateid) {
    $conn = mysqli_connect("localhost", "root", "", "record") or die("Connection failed:" . mysqli_connect_error());
    $updateid = mysqli_real_escape_string($conn, $updateid);
    $sql = "SELECT * FROM studentrecord WHERE id={$updateid}";
    $result = mysqli_query($conn, $sql) or die("Sql Query Failed");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
?>
        <form method="post" enctype="multipart/form-data" class="container mt-5" id="myForm">
            <div class="text-center"></div>
            <div class="form-group">
                <label for="imagename">Image</label>
                <div class="input-group">
                    <input type="file" name="imagename" value="<?php echo $row['userimage']; ?>" id="imagename" class="form-control">
                    <img src='uploads/<?php echo $row['userimage']; ?>' alt='User Image' width='50' class="ml-2">
                </div>
            </div>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="text" name="firstname" value="<?php echo $row['f_name']; ?>" id="firstname" class="form-control">
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" value="<?php echo $row['l_name']; ?>" id="lastname" class="form-control">
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" name="age" value="<?php echo $row['age']; ?>" id="age" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email-Id</label>
                <input type="email" name="email" value="<?php echo $row['emailId']; ?>" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">Phone-No</label>
                <input type="number" name="phone" value="<?php echo $row['phone']; ?>" id="phone" class="form-control">
            </div>
            <div class="form-group">
                <label class="mr-2">Gender</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?php echo ($row['gender'] == 'male') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?php echo ($row['gender'] == 'female') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="female">Female</label>
                </div>
            </div>
            <button type="submit" id="submit" class="btn btn-success">Submit</button>
        </form>
<?php
    }
}
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $("#myForm").submit(function(e) {
            e.preventDefault();
            $(".error-message").remove();
            var fd = new FormData();
            var image = $('#imagename')[0].files[0];
            var id = "<?php echo $row['id']; ?>";
            fd.append('id', id);
            fd.append('imagename', image);
            fd.append('firstname', $("#firstname").val());
            fd.append('lastname', $("#lastname").val());
            fd.append('age', $("#age").val());
            fd.append('email', $("#email").val());
            fd.append('phone', $("#phone").val());
            fd.append('gender', $("input[name='gender']:checked").val());

            $.ajax({
                url: "update-main.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log("AJAX Success:", data);
                    if (data) {
                        alert("Record updated successfully!");
                        window.location.href = 'user.php';
                    } else {
                        alert("Can't save Record.");
                    }
                }
            });
        });
        function displayError(element, message) {
            $(element).after("<div class='error-message text-danger'>" + message + "</div>");
        }
        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    });
</script>