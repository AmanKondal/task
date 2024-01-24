
<?php
$conn = mysqli_connect("localhost", "root", "", "record") or die("Connection failed: " . mysqli_connect_error());
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['last'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phoneno = $_POST['phone'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $imagename = $_FILES['imagename']['name'];
    $imagetmp = $_FILES['imagename']['tmp_name'];
    $uploads_dir = 'uploads/';
    move_uploaded_file($imagetmp, $uploads_dir . $imagename);
   
    $sql = "INSERT INTO studentrecord(f_name, l_name, age, emailId, phone, gender, userimage) VALUES ('$firstname', '$lastname', $age, '$email', $phoneno, '$gender', '$imagename')";
    if (mysqli_query($conn, $sql)) {
        echo "Record added successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>