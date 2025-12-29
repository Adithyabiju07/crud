<?php
include 'db.php';

$id = $_GET['id'];

// If no ID, stop
if($id == 0){
    die("Invalid department ID");
}

// Get existing student data
$result = $conn->query("SELECT * FROM departments WHERE id=$id")->fetch_assoc();


if(!$result){
    die("Department not found!");
}

// Put existing data into variables
$photo  = $result['image'];
$name   = $result['name'];
$code  = $result['code'];
$status = $result['status'];

// When form is submitted
if(isset($_POST['update'])){

    $name   = $_POST['name'];
    $code  = $_POST['code'];
    $status = $_POST['status'];

    if (empty($name) || empty($code)){
        echo "All fields are required";
        exit;
    }
    
    if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
        $file_name = time() . "_" .$_FILES['photo']['name'];
        $photo_path = "photos/departments/" .$file_name;

        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    }
    else{
        $photo_path = $photo;
    }
    

    $conn->query("UPDATE departments SET image='$photo_path', name='$name', code='$code', status='$status' WHERE id=$id");

    header("Location: list_departments.php");

}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit employees</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h3>Edit employees</h3>
    <a href="list_departments.php" class="btn btn-secondary mb-3">Back</a>

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
        </div>

        <div class="mb-3">
            <label class="form-label">Code<i class="text-danger">*</i></label>
            <input type="text" class="form-control" name="code" id="code"
                    value="<?= htmlspecialchars($code) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Status<i class="text-danger">*</i></label>
            <select class="form-select" name="status" id="status">
                <option value="">-- Select Status --</option>
                <option value="1" <?= $status == "1" ? "selected" : "" ?>>Active</option>
                <option value="0" <?= $status == "0" ? "selected" : "" ?>>Inactive</option>
            </select>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update</button>

    </form>
</div>

</body>
</html>