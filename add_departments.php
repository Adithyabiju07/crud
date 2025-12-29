<?php
include 'db.php';

if (isset($_POST['save'])){
   
   $name = $_POST['name'];
   $code = $_POST['code'];
   $status = $_POST['status'];

   //PHP Validation

   if (empty($name) || empty($code) || empty($_FILES['photo']['name'])){
      echo "All fields are required";
      exit;
   }
      
   $file_name = $_FILES['photo']['name'];
   $photo_path = "photos/departments/" .$file_name;

   if(move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)){
      $conn->query("INSERT INTO departments (name, code, image, status)
      VALUES ('$name', '$code', '$photo_path', '$status')");

      echo("File Uploaded Succesfully");
      header("refresh:2, url=list_departments.php");
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
      <title>Add Departments</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css" rel="stylesheet">
   </head>
   <body>
      <div class="container mt-5">
         <div class="row">
            <div class="d-flex justify-content-between">
               <h3>Add New Department</h3>
               <a href="list_departments.php" class="btn btn-warning">View Departments</a>
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
               <label class="form-label">code<i class="text-danger">*</i></label>
               <input type="text" class="form-control" name="code" id="code">
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
            <a href="list_departments.php" class="btn btn-secondary">Back</a>
         </form>
      </div>
   </body>
</html>