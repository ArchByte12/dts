<?php
require 'connection.php';
session_start();
ob_end_clean();

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('documents');

// update document status
if (
    isset($_POST['tracking_number']) &&
    isset($_POST['status'])
) {
    $tracking_number = $_POST['tracking_number'];
    $status = $_POST['status'];
    $updated_date = date('Y-m-d H:i:s');

    $document = $collection->updateOne(
        ['tracking_number' => $tracking_number],
        ['$set' => ['status' => $status, 'updated_date' => $updated_date]]
    );

    if ($document) {
        echo json_encode(array('status' => 'success', 'message' => 'Document updated successfully'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Something went wrong'));
    }
}

//update document destination
if (
    isset($_POST['tracking_number']) &&
    isset($_POST['document_destination'])
) {
    $tracking_number = $_POST['tracking_number'];
    $document_destination = $_POST['document_destination'];
    $updated_date = date('Y-m-d H:i:s');

    $document = $collection->updateOne(
        ['tracking_number' => $tracking_number],
        ['$set' => ['document_destination' => $document_destination, 'updated_date' => $updated_date]]
    );

    if ($document) {
        echo json_encode(array('status' => 'success', 'message' => 'Document updated successfully'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Something went wrong'));
    }
}


//mark as terminal -> terminal_flag
if (
    isset($_POST['tracking_number']) &&
    isset($_POST['terminal_flag'])
) {
    $tracking_number = $_POST['tracking_number'];
    $terminal_flag = 1;
    $incoming_flag = 0;
    $updated_date = date('Y-m-d H:i:s');

    $document = $collection->updateOne(
        ['tracking_number' => $tracking_number],
        ['$set' => ['terminal_flag' => $terminal_flag, 'incoming_flag' => $incoming_flag,  'updated_date' => $updated_date]]
    );

    if ($document) {
        echo json_encode(array('status' => 'success', 'message' => 'Document updated successfully'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Something went wrong'));
    }
}

// Check if required POST data is set
if (
    isset($_POST['tracking_number']) &&
    isset($_POST['document_title']) &&
    isset($_POST['document_destination']) &&
    isset($_POST['deadline']) &&
    isset($_POST['priority_status'])
) {
    // Retrieve POST data
    $trackingNumber = $_POST['tracking_number'];
    $documentTitle = $_POST['document_title'];
    $documentDestination = $_POST['document_destination'];
    $deadline = $_POST['deadline'];
    $priorityStatus = $_POST['priority_status'];
    $updatedDate = date('Y-m-d H:i:s'); // Current timestamp

    // Select the database and collection
    $database = $client->selectDatabase('dts_db');
    $collection = $database->selectCollection('documents');

    // Update the document in the database
    $updateResult = $collection->updateOne(
        ['tracking_number' => $trackingNumber], // Filter by tracking number
        ['$set' => [
            'document_title' => $documentTitle,
            'document_destination' => $documentDestination,
            'deadline' => $deadline,
            'priority_status' => $priorityStatus,
            'updated_date' => $updatedDate
        ]]
    );

    // Check if the document was updated
    if ($updateResult) {
        echo json_encode(['status' => 'success', 'message' => 'Document updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No changes were made to the document.']);
    }
}
