<?php
require 'connection.php';
session_start();
ob_end_clean();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resetCode = $_POST['reset_code'];
    $newPassword = $_POST['new_password'];

    // Validate inputs
    if (empty($resetCode) || empty($newPassword)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Connect to MongoDB
    try {
        $database = $client->selectDatabase('dts_db');
        $collection = $database->selectCollection('users');
    } catch (Exception $e) {
        error_log("Database connection failed: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit;
    }

    // Check if the reset code exists and is valid
    $user = $collection->findOne([
        'reset_code' => (int)$resetCode,
        'reset_code_expiration' => ['$gte' => new MongoDB\BSON\UTCDateTime()]
    ]);

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Invalid or expired reset code.']);
        exit;
    }

    // Hash the new password
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the user's password and remove the reset code
    $updateResult = $collection->updateOne(
        ['_id' => $user['_id']],
        ['$set' => ['password' => $hashedPassword], '$unset' => ['reset_code' => '', 'reset_code_expiration' => '']]
    );

    if ($updateResult->getModifiedCount() === 0) {
        echo json_encode(['success' => false, 'message' => 'Failed to update password.']);
        exit;
    }

    echo json_encode(['success' => true]);
}
?>
