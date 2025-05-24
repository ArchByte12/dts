<?php
require 'connection.php';

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('tracking');

try {
    if (isset($_POST['tracking_number'])) {
        $tracking_number = $_POST['tracking_number'];

        $trackingHistory = $collection->find(['tracking_number' => $tracking_number], [
            'sort' => ['date' => -1] // Sort by date in descending order
        ])->toArray();

        if (!empty($trackingHistory)) {
            echo json_encode(['status' => 'success', 'data' => $trackingHistory]);
        } else {
            echo json_encode(['status' => 'success', 'data' => []]); // Return an empty array if no data is found
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tracking number is required.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
