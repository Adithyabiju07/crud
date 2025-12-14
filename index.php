<?php
include 'db.php';

// Fetch all students
$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h3>Students List</h3>
    <a href="create.php" class="btn btn-success mb-3 float-end">+ Add Student</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th width="5%">ID</th>
            <th width="25%">Photos</th>
            <th width="20%">Name</th>
            <th width="15%">Email</th>
            <th width="10%">Mobile</th>
            <th width="10%">Status</th>
            <th width="20%">Actions</th>
        </tr>
        </thead>

        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td> <img src="<?= $row['photo']; ?>" width="80px"></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['mobile']; ?></td>
                    <td>
                        <?php if($row['status'] == 1): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                            Edit
                        </a>
                        <a href="delete.php?id=<?= $row['id'] ?>"
                           class="btn btn-sm btn-danger"
                           onclick="confirmation(event)">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center text-danger">No students found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    function confirmation(event){
        event.preventDefault();
        var url = event.currentTarget.getAttribute('href');

        swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this imaginary file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
    if(willDelete){
        window.location.href = url;
    } else{
        swal("Account record is safe!");
    }
})};
   
</script>
</body>
</html>