<?php
require 'connection.php';
session_start();
ob_end_clean();

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('users');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    if (!empty($username)) {
        $userCount = $collection->countDocuments(); // Count total users

        if ($userCount > 1 && $username !== 'admin') {
            $result = $collection->deleteOne(['username' => $username]);

            if ($result->getDeletedCount() === 1) {
                echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete user.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Cannot delete user. Either only one user exists or the username is "admin".']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>