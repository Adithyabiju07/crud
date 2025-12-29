<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "employee_management_db";

$conn = new mysqli($host,$user,$password,$db);
if($conn->connect_error){
    die("Connection failed :".$conn->connect_error);
}
 
?>