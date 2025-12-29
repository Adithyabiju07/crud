<?php
include 'db.php';

// Fetch all details
$result = $conn->query("SELECT * FROM departments ORDER BY id DESC");
?>

<html>
<head>
    <title>View Departments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>

<body>

<div class="container mt-5">
    <h3>Departments List</h3>
    <a href="add_departments.php" class="btn btn-success mb-3 float-end">+ Add Departments</a>
    <a href="index.php" class="btn btn-success mb-3 float-end me-3">Back</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th width="10%">Id</th>
            <th width="20%">Photos</th>
            <th width="20%">Name</th>
            <th width="15%">code</th>
            <th width="15%">Status</th>
            <th width="20%">Actions</th>
        </tr>
        </thead>

        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td> <img src="<?= $row['image']; ?>" width="80px"></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['code']; ?></td>
                    <td>
                        <?php if($row['status'] == 1): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_departments.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                            Edit
                        </a>
                        <a href="delete_departments.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center text-danger">No departments found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>