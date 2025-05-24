<!-- insert to document table -->
<?php
require 'connection.php';
session_start();
ob_end_clean();

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('documents');

// tracking number, document title, document destination, deadline, priority status,
//  incoming flag, outgoing flag, terminal flag, status, created date, updated date.

try {
    if (
        isset($_POST['tracking_number']) &&
        isset($_POST['document_title']) &&
        isset($_POST['document_destination']) &&
        isset($_POST['deadline']) &&
        isset($_POST['priority_status'])
    ) {
        $tracking_number = $_POST['tracking_number'];
        $document_title = $_POST['document_title'];
        $document_destination = $_POST['document_destination'];
        $document_origin = $_SESSION['office'];
        $deadline = $_POST['deadline'];
        $priority_status = $_POST['priority_status'];
        $incoming_flag = 1;
        $outgoing_flag = 1;
        $terminal_flag = 0;
        $status = 'Pending';
        $created_date = date('Y-m-d H:i:s');
        $updated_date = null;
        $remarks = null;
        $notes = $_POST['notes'] ?? null;
        $attached_link = $_POST['attached_link'] ?? null;

        $document = $collection->insertOne([
            'tracking_number' => $tracking_number,
            'document_title' => $document_title,
            'document_destination' => $document_destination,
            'document_origin' => $document_origin,
            'deadline' => $deadline,
            'priority_status' => $priority_status,
            'incoming_flag' => $incoming_flag,
            'outgoing_flag' => $outgoing_flag,
            'terminal_flag' => $terminal_flag,
            'status' => $status,
            'created_date' => $created_date,
            'updated_date' => $updated_date,
            'remarks' => $remarks,
            'notes' => $notes,
            'attached_link' => $attached_link
        ]);

        if ($document) {
            echo json_encode(array('status' => 'success', 'message' => 'Document created successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Something went wrong'));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Missing required fields'));
    }
} catch (Exception $e) {
    echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
}
?>