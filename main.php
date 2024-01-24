<?php
$conn = mysqli_connect("localhost", "root", "", "record") or die("Connection failed: " . mysqli_connect_error());

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    $image = $_FILES["image"]["name"];
    $image_tmp = $_FILES["image"]["tmp_name"];

    // Check if the file was uploaded successfully
    if (!is_uploaded_file($image_tmp)) {
        echo "File upload failed.";
    } else {
        // Assuming you have a folder named "uploads" to store images
        move_uploaded_file($image_tmp, 'uploads/' . $image);

        $sql = "INSERT INTO studentrecord(f_name, l_name, age, emailId, phone, gender, userimage) VALUES ('$firstname', '$lastname', $age, '$email', $phoneno, '$gender', '$image')";

        var_dump($sql);
        exit;

        if (mysqli_query($conn, $sql)) {
            echo "Record added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>
