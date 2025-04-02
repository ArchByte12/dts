<?php
require 'connection.php';
session_start();
ob_end_clean();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prepare the MongoDB query
    $database = $client->selectDatabase('dts_db');
    $collection = $database->selectCollection('documents');

    $trackingNumber = $_POST['trackingNumber'];

    $document = $collection->findOne(['tracking_number' => $trackingNumber]);

    if ($document) {
        echo json_encode([
            'exists' => true,
            'tracking_number' => $document['tracking_number'],
            'document_title' => $document['document_title'],
            'deadline' => $document['deadline'],
            'priority_status' => $document['priority_status'],
            'document_origin' => $document['document_origin']
        ]);
    } else {
        echo json_encode(['exists' => false]);
    }
}