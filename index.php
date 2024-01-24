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

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        button[type="submit"]:focus {
            outline: none;
        }
    </style>
</head>

</nav>
<form action="main.php" method="post" enctype="multipart/form-data">
    <div>
        <label> Image</label>
        <input type="file" name="imagename" id="fileToUpload">
    </div>
    <div>
        <label>First Name</label><input type="text" name="firstname">
    </div>
    <div>
        <label>last Name</label><input type="text" name="last">
    </div>
    <div>
        <label>Age</label>
        <input type="number" name="age">
    </div>
    <div>
        <label>email-Id</label>
        <input type="text" name="email">
    </div>
    <div>
        <label>Phone-No</label>
        <input type="number" name="phone">
    </div>
    <div> <label><input type="radio" name="gender" value="male"> Male</label>
        <label><input type="radio" name="gender" value="female"> Female</label>
        <button name="submit" value="submit" type="submit">Submit</button>
</form>
</body>
</body>

</html>