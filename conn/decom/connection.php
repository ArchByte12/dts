<!-- Connection -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dts_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>