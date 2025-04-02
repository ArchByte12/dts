<?php
require 'connection.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;

    // Check if username or email is provided
    if (empty($username) && empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Username or email is required.']);
        exit;
    }

    // Prepare the MongoDB query
    $database = $client->selectDatabase('dts_db');
    $collection = $database->selectCollection('users');
    $query = [];

    if ($username) {
        $query['username'] = $username;
    }

    if ($email) {
        $query['email_address'] = $email;
    }

    // Check if the user exists
    $existingUser = $collection->findOne($query);

    if ($existingUser) {
        if ($existingUser['username'] === $username) {
            echo json_encode(['status' => 'exists', 'message' => 'Username already exists.']);
        } elseif ($existingUser['email_address'] === $email) {
            echo json_encode(['status' => 'exists', 'message' => 'Email already exists.']);
        }
    } else {
        echo json_encode(['status' => 'available']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>