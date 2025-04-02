<!-- //  check if tracking_number is already exist to document table -->
<?php
require 'connection.php';
session_start();
ob_end_clean();

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('documents');

if (isset($_POST['tracking_number'])) {
    $tracking_number = $_POST['tracking_number'];

    $document = $collection->findOne(['tracking_number' => $tracking_number]);

    if ($document) {
        echo json_encode(array('status' => 'error', 'message' => 'Tracking number already exists'));
    } else {
        echo json_encode(array('status' => 'success', 'message' => 'Tracking number is available'));
    }
}

// get last tracking number
if (isset($_POST['lastTrackingNumber'])) {
    $document = $collection->find([], ['sort' => ['tracking_number' => -1], 'limit' => 1]);
    $tracking_number = $document->toArray()[0]['tracking_number'];
    echo json_encode(array('status' => 'success', 'tracking_number' => $tracking_number));
}
?>