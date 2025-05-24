<?php
require 'connection.php';
session_start();

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('tracking');

// Insert tracking data
try {
    if (
        isset($_POST['tracking_number']) &&
        isset($_POST['office']) &&
        isset($_POST['action']) &&
        isset($_POST['remarks'])
    ) {
        $tracking_number = $_POST['tracking_number'];
        $office = $_POST['office'];
        $action = $_POST['action'];
        $remarks = $_POST['remarks'];
        $date = date('Y-m-d H:i:s');

        $trackingData = [
            'tracking_number' => $tracking_number,
            'office' => $office,
            'action' => $action,
            'remarks' => $remarks,
            'date' => $date
        ];

        $result = $collection->insertOne($trackingData);

        if ($result->getInsertedCount() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Tracking data inserted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert tracking data']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
