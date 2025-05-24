<?php
require 'connection.php';
session_start();
ob_end_clean();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $office = $_POST['office'];
    $position = $_POST['position'];
    $user_type = $_POST['user_type'];
    // handle null password
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate the data (you can add more validation as needed)
    if (empty($username) || empty($fullname) || empty($email) || empty($office) || empty($position)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Prepare the MongoDB query
    $database = $client->selectDatabase('dts_db');
    $collection = $database->selectCollection('users');
    $query = ['username' => $username];

    // Check if the user exists
    $existingUser = $collection->findOne($query);

    if ($existingUser) {
        // Update the user's data
        $updateData = [
            'fullname' => $fullname,
            'email_address' => $email,
            'office' => $office,
            'position' => $position,
            'user_type' => $user_type
        ];
        // Only update the password if it's provided
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $updateData['password'] = $hashedPassword;
        }
        $collection->updateOne($query, ['$set' => $updateData]);
        echo json_encode(['status' => 'updated', 'message' => 'User data updated successfully.']);
    } else {
        // Insert a new user
        $new_user = [
            'username' => $username,
            'fullname' => $fullname,
            'email_address' => $email,
            'office' => $office,
            'position' => $position,
            'user_type' => $user_type,
            'password' => $password,
            'reset_code' => null,
            'reset_code_expiration' => null
        ];
        try {
            $result = $collection->insertOne($new_user);
            if ($result->getInsertedCount() === 1) {
                echo json_encode(['status' => 'success', 'message' => 'User created successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to create user.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
