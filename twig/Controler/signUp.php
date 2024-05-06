<?php
session_start();

// Check if the 'f_name' key is set in the session
if (isset($_SESSION['f_name'])) {
    // Retrieve the value of 'f_name'
    $f_name = $_SESSION['f_name'];
} else {
    // 'f_name' is not set in the session
    // You can handle this case accordingly
    $f_name = ''; // Set a default value or handle the absence of 'f_name'
}

require_once '../vendor/autoload.php';
require_once '../service/fileuplode.php';
$loader = new Twig\Loader\FilesystemLoader('../view');
$twig = new Twig\Environment($loader);
$database = new Database();
$fileuploade = new file();
$error = '';

if (isset($_SESSION['email'])) {
    header("Location: user/userView.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imageNames = $fileuploade->uploadImages($_FILES);

    if (empty($error)) {
        $userData = array(
            'f_name' => $_POST['firstname'],
            'l_name' => $_POST['lastname'],
            'father_name' => $_POST['fathername'],
            'mother_name' => $_POST['mothername'],
            'gender' => $_POST['gender'],
            'email' => $_POST['email'],
            'password' => md5($_POST['password']),
            'street_no' => $_POST['street'],
            'additional_info' => $_POST['additional_info'],
            'zip_code' => $_POST['zip_code'],
            'place' => $_POST['place'],
            'country' => $_POST['country'],
            'code' => $_POST['code'],
            'phone' => $_POST['phone_number'],
            'type' => $_POST['role'],
            'image' => implode(",", $imageNames),
        );
        $email = $_POST['email'];
        $role = $_POST['role'];
        $existingUser = $database->getUserByEmail($email);

        if ($existingUser) {
            $error = 'Email already exists';
        } else {
            $insertId = $database->registerUser($userData);
            if ($insertId) {
                $_SESSION['email'] = $email;
                $_SESSION['uid'] = $insertId;
                $_SESSION['f_name'] = $_POST['firstname']; // Assuming you want to set f_name from the form data
                if ($role == 1) {
                    header("Location: admin/adminView.php");
                } else {
                    header("Location: user/userView.php");
                    exit();
                }
            } else {
                $error = "Your record couldn't be added";
            }
        }
    }
}

// Render the Twig template and pass the error and f_name variable to it
echo $twig->render('signUp.twig', ['error' => $error, 'f_name' => $f_name]);
