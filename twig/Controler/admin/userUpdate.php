<?php
require_once '../../vendor/autoload.php';
require_once '../../model/user.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader('../../view/admin');
$twig = new Environment($loader);

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

    // Check if new images are uploaded
    if (!empty($_FILES['imagename']['name'][0])) {
        foreach ($_FILES['imagename']['name'] as $key => $value) {
            $name = $_FILES['imagename']['name'][$key];
            $temp_name = $_FILES['imagename']['tmp_name'][$key];
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $unique_name = uniqid() . '_' . time() . '.' . $extension;
            $folder = "../../uploads/" . $unique_name;

            // Check if file upload was successful
            if (move_uploaded_file($temp_name, $folder)) {
                $imageNames[] = $unique_name;
            } else {
                $error = 'Failed to upload some files.';
                break;
            }
        }
    } else {
        // If no new images are uploaded, use the existing image
        $imageNames[] = $existing_image;
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

    // Update user data
    $result = $database->updateUser($update_data, "uid = '$id'");

    // Delete existing image if necessary
    if ($result && $existing_image && file_exists('../../uploads/' . $existing_image)) {
        unlink('../../uploads/' . $existing_image);
    }

    // Check if update was successful
    if ($result) {
        echo 1;
    } else {
        echo 0;
    }
    exit();
}
