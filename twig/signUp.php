 <?php
require_once 'vendor/autoload.php';
require_once 'model/user.php';

$loader = new Twig\Loader\FilesystemLoader('view');
$twig = new Twig\Environment($loader);
$database = new Database();
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imageNames = array();
    foreach ($_FILES['imagename']['name'] as $key => $value) {
        $name = $_FILES['imagename']['name'][$key];
        $temp_name = $_FILES['imagename']['tmp_name'][$key];
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $unique_name = uniqid() . '_' . time() . '.' . $extension;
        $folder = "uploads/" . $unique_name;
        if (move_uploaded_file($temp_name, $folder)) {
            $imageNames[] = $unique_name;
        } else {
            $error = 'Failed to upload some files.';
            break;
        }
    }
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
            'image' => implode(",", $imageNames),
        );
        $email = $_POST['email'];
        $existingUser = $database->getUserByEmail($email);
        if ($existingUser) {
            $error = 'Email already exists';
        } else {
            $insertId = $database->registerUser($userData);
            if ($insertId) {
                $message = 'Your record was added successfully';
                header("location: controler/user/userView.php?message");
                exit;
            } else {
                $error = "Your record couldn't be added";
            }
        }
    }
}

echo $twig->render('signUp.twig', ['error' => $error]);
