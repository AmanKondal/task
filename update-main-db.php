<?php
$conn = mysqli_connect("localhost", "root", "", "record") or die("Connection failed:" . mysqli_connect_error());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateid = $_POST["id"];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phoneno = $_POST['phone'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $imagename = isset($_FILES['imagename']['name']) ? $_FILES['imagename']['name'] : '';
    $imagetmp = isset($_FILES['imagename']['tmp_name']) ? $_FILES['imagename']['tmp_name'] : '';
    $uploads_dir = 'uploads/';

    if (!empty($imagename) && !empty($imagetmp)) {
        move_uploaded_file($imagetmp, $uploads_dir . $imagename);
    } else {
        $imagename = $_POST['existing_image'];
    }

    $sql = "UPDATE studentrecord SET `f_name`='$firstname', `l_name`='$lastname', `age`='$age', `emailId`='$email', `phone`='$phoneno', `gender`='$gender', `userimage`='$imagename' WHERE id=$updateid";

    if (mysqli_query($conn, $sql)) {
        echo 1; // Success
    } else {
        echo 0; // Failure
    }

    mysqli_close($conn);
}
?>
