<?php
require_once 'vendor/autoload.php';
require_once 'model/user.php';
$loader = new Twig\Loader\FilesystemLoader('view');
$twig = new Twig\Environment($loader);
$database = new dataBase();
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $result = $database->loginUser($email, $password);

    if (!empty($result)) {
        $_SESSION['email'] = $result['email'];
        $_SESSION['type'] = $result['type'];
        $_SESSION['uid'] = $result['uid'];

        if ($result['type'] == 1) {
            $_SESSION = [
                'email' => $result['email'],
                'type' => $result['type'],
                'uid' =>  $result['uid']
            ];
            var_dump($_SESSION);
            header("Location: controler/admin/adminView.php");
            exit();
        } elseif ($result['type'] == 0) {
            $_SESSION['email'] = $result['email'];
            $_SESSION['type'] = $result['type'];
            $_SESSION['f_name'];
            $_SESSION['uid'] = $result['uid'];
            header("Location: controler/user/userView.php");
            exit();
        }
    } else {
        $error = "Invalid email or password. Please try again.";
    }
}

echo $twig->render('login.twig', ['error' => $error]);
?>
