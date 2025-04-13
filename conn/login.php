<?php
// Include the MongoDB connection file
require 'connection.php';
session_start();
ob_end_clean();

// Use the MongoDB client from the connection file
$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('users');

// Check if the form is submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Assign the form data to variables
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database for the user
    $user = $collection->findOne(['username' => $username]);

    // If the user exists, verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, set session variables
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['position'] = $user['position'];
        $_SESSION['office'] = $user['office'];
        $_SESSION['email_address'] = $user['email_address'];

        echo json_encode(array('status' => 'success', 'message' => 'Login successful'));
    } else {
        // Invalid username or password
        echo json_encode(array('status' => 'error', 'message' => 'Invalid username or password'));
    }
} else {
    // Username and password are required
    echo json_encode(array('status' => 'error', 'message' => 'Username and password are required'));
}
?>