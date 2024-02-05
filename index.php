<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script.js"></script>
  <link href="style.css" rel="stylesheet" > 
</head>
<body>
    <nav>
        <a href="user-view.php" class="btn btn-primary">User-List</a>
    </nav>
    <form method="post" action="Form-submit-db.php" enctype="multipart/form-data" class="container mt-5" id="myForm">
        <div class="text-center"></div>
        <div class="form-group">
            <label for="imagename">Image</label>
            <div class="input-group">
                <input type="file" name="imagename" id="fileToUpload" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" id="firstname" class="form-control">
        </div>
        <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" id="lastname" class="form-control">
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email-Id</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="phone">Phone-No</label>
            <input type="number" name="phone" id="phone" class="form-control">
        </div>
        <div class="form-group">
            <label class="mr-2">Gender</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male">
                <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                <label class="form-check-label" for="female">Female</label>
            </div>
        </div>

        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>