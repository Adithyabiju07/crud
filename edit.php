<?php
include 'db.php';

$id = $_GET['id'] ?? 0;

// If no ID, stop
if($id == 0){
    die("Invalid student ID");
}

// Get existing student data
$student = $conn->query("SELECT * FROM students WHERE id=$id")->fetch_assoc();


if(!$student){
    die("Student not found!");
}

// Put existing data into variables
$photo  = $student['photo'];
$name   = $student['name'];
$email  = $student['email'];
$mobile = $student['mobile'];
$status = $student['status'];

$name_error = $email_error = $mobile_error = $status_error = $photo_error = "";
$update_success = "";

// When form is submitted
if(isset($_POST['update'])){

    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $mobile = $_POST['mobile'];
    $status = $_POST['status'];

    if (empty($name) || empty($email) || empty($mobile)){
        echo "All fields are required";
        exit;
    }
    
    if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
        $file_name = time() . "_" .$_FILES['photo']['name'];
        $photo_path = "photos/" .$file_name;

        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    }
    else{
        $photo_path = $photo;
    }
    

    $conn->query("UPDATE students SET photo='$photo_path', name='$name', email='$email', mobile='$mobile', status='$status' WHERE id=$id");

    header("Location: index.php");

}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h3>Edit Student</h3>
    <a href="index.php" class="btn btn-secondary mb-3">Back</a>

    <?php if($update_success): ?>
        <small class="text-success d-block mb-3"><?= $update_success ?></small>
    <?php endif; ?>

    <form method="POST" id="editForm" enctype="multipart/form-data">

        <div class="mb-3">
               <label class="form-label">Photo<i class="text-danger">*</i></label>
               <input type="file" class="form-control" name="photo" id="photo">
               <img src="<?= $photo ?>"width="200px" height="200px">
            </div>

        <div class="mb-3">
            <label class="form-label">Name<i class="text-danger">*</i></label>
            <input type="text" class="form-control" name="name" id="name"
                   value="<?= htmlspecialchars($name) ?>">
            <small class="text-danger" id="name_error"><?= $name_error ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Email<i class="text-danger">*</i></label>
            <input type="text" class="form-control" name="email" id="email"
                   value="<?= htmlspecialchars($email) ?>">
            <small class="text-danger" id="email_error"><?= $email_error ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Mobile<i class="text-danger">*</i></label>
            <input type="text" class="form-control" name="mobile" id="mobile"
                   value="<?= htmlspecialchars($mobile) ?>">
            <small class="text-danger" id="mobile_error"><?= $mobile_error ?></small>
        </div>

        <div class="mb-3">
            <label class="form-label">Status<i class="text-danger">*</i></label>
            <select class="form-select" name="status" id="status">
                <option value="">-- Select Status --</option>
                <option value="1" <?= $status == "1" ? "selected" : "" ?>>Active</option>
                <option value="0" <?= $status == "0" ? "selected" : "" ?>>Inactive</option>
            </select>
            <small class="text-danger" id="status_error"><?= $status_error ?></small>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update</button>

    </form>
</div>

</body>
</html>