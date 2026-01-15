<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EVC_DB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error: database". $conn->connect_error);
}
?>