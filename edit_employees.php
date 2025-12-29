<?php
include 'db.php';

$id = $_GET['id'] ?? 0;

// If no ID, stop
if($id == 0){
    die("Invalid employee ID");
}

// Get existing student data
$result = $conn->query("SELECT * FROM employees WHERE id=$id")->fetch_assoc();


if(!$result){
    die("Employee not found!");
}

// Put existing data into variables
$photo  = $result['photo'];
$emp_no = $result['employee_no'];
$name   = $result['name'];
$department = $result['department'];
$email  = $result['email'];
$phone = $result['phone'];
$status = $result['status'];

// When form is submitted
if(isset($_POST['update'])){

    $emp_no = $_POST['employee_no'];
    $name   = $_POST['name'];
    $department = $_POST['department'];
    $email  = $_POST['email'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];

    if (empty($emp_no) || empty($name) || empty($department) || empty($email) || empty($phone)){
        echo "All fields are required";
        exit;
    }
    
    if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
        $file_name = time() . "_" .$_FILES['photo']['name'];
        $photo_path = "photos/employees/" .$file_name;

        move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
    }
    else{
        $photo_path = $photo;
    }
    

    $conn->query("UPDATE employees SET photo='$photo_path', employee_no='$emp_no', name='$name', email='$email', department='$department', phone='$phone', status='$status' WHERE id=$id");

    header("Location: list_employees.php");

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
    <a href="list_employees.php" class="btn btn-secondary mb-3">Back</a>

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
            <label class="form-label">Department<i class="text-danger">*</i></label>
            <input type="text" class="form-control" name="department" id="department"
                    value="<?= htmlspecialchars($department) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Email<i class="text-danger">*</i></label>
            <input type="text" class="form-control" name="email" id="email"
                   value="<?= htmlspecialchars($email) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">phone<i class="text-danger">*</i></label>
            <input type="text" class="form-control" name="phone" id="phone"
                   value="<?= htmlspecialchars($phone) ?>">
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