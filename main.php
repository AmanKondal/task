<?php
$conn = mysqli_connect("localhost", "root", "", "record") or die("Connection failed:" . mysqli_connect_error());
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
    $sql = "INSERT INTO studentrecord (`f_name`, `l_name`, `age`, `emailId`, `phone`, `gender`, `userimage`) VALUES ('$firstname', '$lastname', $age, '$email', $phoneno, '$gender', '$imagename')";

    if (mysqli_query($conn, $sql)) {
        $message =  'Your Record Add successfully';
        $color = 'success';
        header("location:User.php?message=" . urlencode($message) . "&color=$color");
    } else {
        $message =  'Your Record Not Add ';
        $color = 'danger';
        header("location:index.php?message=" . mysqli_error($conn) . urlencode($message) . "&color=$color");
    }
    mysqli_close($conn);
}
if (isset($_GET['message'])) : ?>
    <div class="alert alert-<?= $_GET['color'] ?> my-3" role="alert" id="feedback">
        <?= urldecode($_GET['message']); ?>
    </div>
<?php endif; ?>
<script>
    setTimeout(() => {
        document.querySelector('#feedback').style.display = 'none';
    }, 10000);
</script>
