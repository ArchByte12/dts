<?php
require 'connection.php';
session_start();
ob_end_clean();

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('users');

// Users page
if (isset($_POST['admin'])) {
    $sessionOffice = $_SESSION['office']; // Get the session office
    $sessionUserType = $_SESSION['user_type']; // Get the session user type
    $sessionUsername = $_SESSION['username']; // Get the session username

    if ($sessionUserType === 'Admin') {
        if ($sessionOffice === 'ICT') {
            $cursor = $collection->find(); // Get all users if office is ICT
        } else {
            $cursor = $collection->find(['office' => $sessionOffice]); // Filter by session office
        }
    } else {
        $cursor = $collection->find(['username' => $sessionUsername]); // View only self if not admin
    }

    $data = iterator_to_array($cursor);
    echo json_encode($data);
}

//find by username
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $cursor = $collection->findOne(['username' => $username]);

    if ($cursor) {
        // Extract only the necessary fields
        $user = [
            'username' => $cursor['username'],
            'fullname' => $cursor['fullname'],
            'email_address' => $cursor['email_address'],
            'office' => $cursor['office'],
            'user_type' => $cursor['user_type'],
            'position' => $cursor['position']
        ];
        echo json_encode(['status' => 'success', 'data' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
}
?>