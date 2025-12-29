<?php
include 'db.php';

$id = $_GET['id'] ?? 0;

if($id == 0){
    die("Invalid ID");
}

// Delete student
$conn->query("DELETE FROM departments WHERE id=$id");

echo("File Deleted Succesfully");
header("refresh:2, url=list_departments.php");
exit;
?>