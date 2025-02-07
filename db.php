<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$servername = "localhost";
$username = "fanadb";
$password = "fana@db";
$dbname = "onlinecourse";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>