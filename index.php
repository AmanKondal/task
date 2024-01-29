<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 5px;
        }

        textarea,
        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            $('.error-message').remove();
            var fileInput = $('#fileToUpload');
            var allowedExtensions = ['jpg', 'jpeg', 'png'];
            var fileName = fileInput.val();
            var fileExtension = fileName.split('.').pop().toLowerCase();
            if (fileName === '') {
                fileInput.after('<div class="error-message">Please select an image file.</div>');
                event.preventDefault();
            } else if ($.inArray(fileExtension, allowedExtensions) === -1) {
                fileInput.after('<div class="error-message">Please select a valid image file (jpg, jpeg, or png).</div>');
                event.preventDefault();
            }
            var requiredFields = ['firstname', 'lastname', 'age', 'email', 'phone', 'gender'];
            $.each(requiredFields, function(index, fieldName) {
                var inputField = $('input[name="' + fieldName + '"]');
                if (inputField.val().trim() === '') {
                    inputField.after('<div class="error-message">Please enter ' + fieldName.charAt(0).toUpperCase() + fieldName.slice(1) + '.</div>');
                    event.preventDefault();
                }
            });
            var emailInput = $('input[name="email"]');
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput.val().trim())) {
                emailInput.after('<div class="error-message">Please enter a valid email address.</div>');
                event.preventDefault();
            }
            var ageInput = $('input[name="age"]');
            if (isNaN(ageInput.val()) || ageInput.val() <= 0) {
                ageInput.after('<div class="error-message">Please enter a valid age.</div>');
                event.preventDefault();
            }
            var phoneInput = $('input[name="phone"]');
            var phoneRegex = /^\d{10}$/;
            if (!phoneRegex.test(phoneInput.val())) {
                phoneInput.after('<div class="error-message">Please enter a valid phone number.</div>');
                event.preventDefault();
            }
            var genderInputs = $('input[name="gender"]:checked');
            if (genderInputs.length === 0) {
                $('input[name="gender"]').last().after('<div class="error-message">Please select a gender.</div>');
                event.preventDefault(); 
            }
        });
    });
</script>
<nav>
    <a href="user.php" class="btn btn-success">User-List</a>
</nav>
</head>
<form action="main.php" method="post" enctype="multipart/form-data">
    <center><?php include 'main.php'; ?></center>
    <div>
        <label>Image</label>
        <input type="file" name="imagename" id="fileToUpload">
    </div>
    <div>
        <label>First Name</label>
        <input type="text" name="firstname">
    </div>
    <div>
        <label>Last Name</label>
        <input type="text" name="lastname">
    </div>
    <div>
        <label>Age</label>
        <input type="number" name="age">
    </div>
    <div>
        <label>Email-Id</label>
        <input type="email" name="email">
    </div>
    <div>
        <label>Phone-No</label>
        <input type="number" name="phone">
    </div>
    <div>
        <label><input type="radio" name="gender" value="male"> Male</label>
        <label><input type="radio" name="gender" value="female"> Female</label>
    </div>
    <input type="submit" value="Submit" name="submit">
</form>
</body>

</html>