<?php
include 'db.php';

// Fetch all details
$result = $conn->query("SELECT * FROM employees ORDER BY id DESC");
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
    <h3>Employees List</h3>
    <a href="add_employees.php" class="btn btn-success mb-3 float-end">+ Add Employee</a>
    <a href="index.php" class="btn btn-success mb-3 float-end me-3">Back</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th width="5%">ID</th>
            <th width="15%">Photos</th>
            <th width="10%">Employee_no</th>
            <th width="15%">Name</th>
            <th width="15%">Department</th>
            <th width="10%">Email</th>
            <th width="10%">phone</th>
            <th width="5%">Status</th>
            <th width="15%">Actions</th>
        </tr>
        </thead>

        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td> <img src="<?= $row['photo']; ?>" width="80px"></td>
                    <td><?= $row['employee_no']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['department']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['phone']; ?></td>
                    <td>
                        <?php if($row['status'] == 1): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_employees.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                            Edit
                        </a>
                        <a href="delete_employees.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center text-danger">No employees found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>