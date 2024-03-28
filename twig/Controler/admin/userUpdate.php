<?php
require_once '../../vendor/autoload.php';
require_once '../../model/user.php';
$loader = new Twig\Loader\FilesystemLoader('../../view/admin');
$twig = new Twig\Environment($loader);
$database = new Database();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $gender = $_POST['gender'];
    $existing_image = $_POST['existing_image'];
    $father_name = $_POST['fathername'];
    $mother_name = $_POST['mothername'];
    $street_no = $_POST['street'];
    $additional_info = $_POST['additional_info'];
    $zip_code = $_POST['zip_code'];
    $place = $_POST['place'];
    $country = $_POST['country'];
    $code = $_POST['code'];
    $imageNames = array();
    foreach ($_FILES['imagename']['name'] as $key => $value) {
        $name = $_FILES['imagename']['name'][$key];
        $temp_name = $_FILES['imagename']['tmp_name'][$key];
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $unique_name = uniqid() . '_' . time() . '.' . $extension;
        $folder = "../../uploads/" . $unique_name;
        if (move_uploaded_file($temp_name, $folder)) {
            $imageNames[] = $unique_name;
        } else {
            $error = 'Failed to upload some files.';
            break;
        }
    }
    $update_data = array(
        'f_name' => $firstname,
        'l_name' => $lastname,
        'email' => $email,
        'phone' => $phone,
        'gender' => $gender,
        'father_name' => $father_name,
        'mother_name' => $mother_name,
        'street_no' => $street_no,
        'additional_info' => $additional_info,
        'zip_code' => $zip_code,
        'place' => $place,
        'country' => $country,
        'code' => $code,
        'image' => implode(",", $imageNames),
    );
    $result = $database->updateUser($update_data, "uid = '$id'");
    if ($result && $existing_image && file_exists('uploads/' . $existing_image)) {
        unlink('uploads/' . $existing_image);
    }

    if ($result) {
        echo 1;
        exit();
    } else {
        echo 0;
        exit();
    }
}
