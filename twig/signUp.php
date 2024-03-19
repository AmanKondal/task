<?php
require_once 'vendor/autoload.php';
require_once 'model/user.php';
$loader = new Twig\Loader\FilesystemLoader('view');
$twig = new Twig\Environment($loader);
$database = new Database();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $value = array();
    for ($i = 0; $i < count($_FILES['imagename']['name']); $i++) {
        $name = $_FILES['imagename']['name'][$i];
        $type = $_FILES['imagename']['type'][$i];
        $temp_name = $_FILES['imagename']['tmp_name'][$i];
        $folder = "uploads/" . $name;
var_dump($folder);
        if (move_uploaded_file($temp_name, $folder)) {
        } else {
            $error = 'Failed to upload some files.';
        }
        $value = array(
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
            'image' => $name,
        );
        var_dump($value);
        exit;
        $email = $_POST['email'];
        $existingUser = $database->getUserByEmail($email);
        if ($existingUser) {
            $error = 'Email already exists';
        } else {
            $insertId = $database->registerUser($value);
            if ($insertId) {
                $message = 'Your record was added successfully';
                header("location: controler/user/userView.php?message=" . urlencode($message) . "&color=$color");
                exit;
            } else {
                $error = "Your record couldn't be added";
            }
        }
    }
}

echo $twig->render('signUp.twig', ['error' => $error]);
