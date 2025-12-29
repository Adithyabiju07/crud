<?php
include 'db.php';
include 'function.php';

$depts = $conn->query("SELECT * FROM departments ORDER BY id DESC");

if (isset($_POST['save'])){

   $emp_no = generateEmployeeNo();
   $name = $_POST['name'];
   $department = $_POST['department'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $status = $_POST['status'];

   //PHP Validation

   if (empty($name) || empty($department) || empty($email) || empty($phone) || empty($_FILES['photo']['name'])){
      echo "All fields are required";
      exit;
   }
      
   $file_name = $_FILES['photo']['name'];
   $photo_path = "photos/employees/" .$file_name;

   if(move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)){
         $insert = $conn->query("INSERT INTO employees (photo, employee_no, name, department, email, phone, status)
         VALUES ('$photo_path', '$emp_no', '$name', '$department', '$email', '$phone', '$status')");

         echo("File Uploaded Succesfully");
         header("refresh:2, url=list_employees.php");
    }
    else{
        echo "File upload failed";
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Add Student</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css" rel="stylesheet">
   </head>
   <body>
      <div class="container mt-5">
         <div class="row">
            <div class="d-flex justify-content-between">
               <h3>Add New Employee</h3>
               <a href="list_employees.php" class="btn btn-warning">View Employees</a>
            </div>
         </div>
         <form id="studentForm" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
               <label class="form-label">Photo<i class="text-danger">*</i></label>
               <input type="file" class="form-control" name="photo" id="photo">
            </div>

            <div class="mb-3">
               <label class="form-label">Name<i class="text-danger">*</i></label>
               <input type="text" class="form-control" name="name" id="name">
            </div>

            <div class="mb-3">
               <label class="form-label">Department<i class="text-danger">*</i></label>
               <select name="department" class="form-control mb-3">
                  <option value="">Select Department</option>
                  <?php while($d = $depts->fetch_assoc()): ?>
                     <?php if($d['status']==1): ?>
                        <option value="<?= $d['name']; ?>"><?= $d['name']; ?></option>
                     <?php endif ?>
                  <?php endwhile; ?>
               </select>
            </div>

            <div class="mb-3">
               <label class="form-label">Email<i class="text-danger">*</i></label>
               <input type="text" class="form-control" name="email" id="email">
            </div>

            <div class="mb-3">
               <label class="form-label">phone<i class="text-danger">*</i></label>
               <input type="text" class="form-control" name="phone" id="phone">
            </div>

            <div class="mb-3">
               <label class="form-label">Status<i class="text-danger">*</i></label>
               <select class="form-select" name="status" id="status">
                  <option value="">-- Select Status --</option>
                  <option value="1" >Active</option>
                  <option value="0" >Inactive</option>
               </select>
            </div>

            <button type="submit" name="save" class="btn btn-primary">Submit</button>
            <a href="list_employees.php" class="btn btn-secondary">Back</a>
         </form>
      </div>
   </body>
</html>