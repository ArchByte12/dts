<?php
require 'connection.php';
session_start();
ob_end_clean();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
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

    // Check if the email exists in the database
    $user = $collection->findOne(['email_address' => $email]);
    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Email not found.']);
        exit;
    }

    // Generate a reset code
    $resetCode = rand(100000, 999999);

    // Save the reset code and its expiration time in the database
    $expirationTime = new MongoDB\BSON\UTCDateTime((time() + 3600) * 1000); // 1 hour from now
    $updateResult = $collection->updateOne(
        ['email_address' => $email],
        ['$set' => ['reset_code' => $resetCode, 'reset_code_expiration' => $expirationTime]]
    );

    if ($updateResult->getModifiedCount() === 0) {
        echo json_encode(['success' => false, 'message' => 'Failed to save reset code.']);
        exit;
    }

    // Dynamically construct the URL for the SMTP script
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    $smtpUrl = "$protocol://$host$basePath/../send_reset_code_smtp.php";

    // Send the reset code via the new SMTP script
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $smtpUrl); // Use dynamically constructed URL
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'email' => $email,
        'reset_code' => $resetCode
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 200) {
        $response = json_decode($response, true);
        if ($response['status'] === 'success') {
            echo json_encode(['success' => true]);
        } else {
            error_log("SMTP script error: " . ($response['message'] ?? 'Unknown error'));
            echo json_encode(['success' => false, 'message' => $response['message'] ?? 'Failed to send email.']);
        }
    } else {
        error_log("cURL error: $curlError");
        echo json_encode(['success' => false, 'message' => 'Failed to communicate with SMTP script.']);
    }
}
