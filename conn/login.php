<?php
    // Include the MongoDB connection file
    require 'connection.php';
    session_start();
    ob_end_clean();
    
    // Use the MongoDB client from the connection file
    // $collection = $client->users;
    $database = $client->selectDatabase('dts_db');
    $collection = $database->selectCollection('users');

    // Check if the form is submitted
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Assign the form data to variables
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query the database for the user
        $user = $collection->findOne(['username' => $username, 'password' => $password]);

        // If the user exists, redirect to the dashboard
        if ($user) {
            $_SESSION['username'] = $username;
            echo json_encode(array('status' => 'success', 'message' => 'Login successful'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid username or password'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Username and password are required'));
    }
?>