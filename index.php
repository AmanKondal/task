<?php
include'main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" action="" >
        First Name <input name="firstname" type="text">
        Last Name <input name="lastname" type="text">
        Age <input name="age" type="number">
        Email ID <input name="email" type="text">
        Phone No <input name="phoneno" type="number">
        Gender:
        <label><input type="radio" name="gender" value="male"> Male</label>
        <label><input type="radio" name="gender" value="female"> Female</label>
        Image <input type="file" name="image">
        <button name="submit" value="submit" type="submit">Submit</button>
    </form>
</body>
</html>
