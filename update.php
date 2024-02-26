<?php
include 'main_db.php';
$database = new Database();
$updateid = isset($_POST["id"]) ? $_POST["id"] : null;
$table = 'studentrecord';
$result = $database->UpdateSelect($table, '*', null, "id = '$updateid'");
if ($updateid) {
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <form method="post" enctype="multipart/form-data" action="update-db.php" class="container mt-5" id="myForm">
            <div class="text-center"></div>
            <div class="form-group">
                <label for="imagename">Image</label>
                <div class="input-group">
                    <input type="file" name="imagename" id="imagename" class="form-control">
                    <?php if (isset($row['userimage'])) : ?>
                        <img src='uploads/<?php echo $row['userimage']; ?>' id="previewImage" alt='User Image' width='50' class="ml-2" data-existing-image="<?php echo $row['userimage']; ?>">
                    <?php else : ?>
                        <span>User image not found</span>
                    <?php endif; ?>
                    <input type="hidden" name="existing_image" id="existing_image" value="<?php echo $row['userimage']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="text" name="firstname" value="<?php echo isset($row['f_name']) ? $row['f_name'] : ''; ?>" id="firstname" class="form-control">
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" value="<?php echo isset($row['l_name']) ? $row['l_name'] : ''; ?>" id="lastname" class="form-control">
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" name="age" value="<?php echo isset($row['age']) ? $row['age'] : ''; ?>" id="age" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email-Id</label>
                <input type="email" name="email" value="<?php echo isset($row['emailId']) ? $row['emailId'] : ''; ?>" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">Phone-No</label>
                <input type="number" name="phone" value="<?php echo isset($row['phone']) ? $row['phone'] : ''; ?>" id="phone" class="form-control">
            </div>
            <div class="form-group">
                <label class="mr-2">Gender</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" <?php echo (isset($row['gender']) && $row['gender'] == 'male') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" <?php echo (isset($row['gender']) && $row['gender'] == 'female') ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="female">Female</label>
                </div>
            </div>
            <button type="submit" id="submit" class="btn btn-success">Submit</button>
        </form>
        <?php
    }
}
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
