<?php
$conn = mysqli_connect("localhost", "root", "", "record") or die("Connection failed:" . mysqli_connect_error());
$updateid =$_POST["id"]; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phoneno = $_POST['phone'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $imagename = $_FILES['imagename']['name'];
    $imagetmp = $_FILES['imagename']['tmp_name'];
    $uploads_dir = 'uploads/';
    move_uploaded_file($imagetmp, $uploads_dir . $imagename);
    $sql = "UPDATE studentrecord SET `f_name`='$firstname', `l_name`='$lastname', `age`='$age', `emailId`='$email', `phone`='$phoneno', `gender`='$gender', `userimage`='$imagename' WHERE id=$updateid";
    if (mysqli_query($conn, $sql)) {
       echo 1;
    } else {
       echo 0;
    }
    mysqli_close($conn);
}