<?php
$servername = "localhost";
$username = "personal";
$password = "Master@2773";
$dbname = "personal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
