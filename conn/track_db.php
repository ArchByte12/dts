<?php
require 'connection.php';
session_start();
ob_end_clean();

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('documents');

// Tracking page
if (isset($_POST['track']) && isset($_POST['office'])){
    $filter = [];
    $filter['document_origin'] = $_POST['office'];
    $cursor = $collection->find($filter);
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

//Incoming page
if (isset($_POST['incoming']) && isset($_POST['office'])){
    $filter = [];
    // $filter['terminal_flag'] = 0;
    // $filter['outgoing_flag'] = 0;
    $filter['incoming_flag'] = 1;
    $filter['document_destination'] = $_POST['office'];
    $cursor = $collection->find($filter);
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

//outgoing page
if (isset($_POST['outgoing']) && isset($_POST['office'])){
    $filter = [];
    // $filter['terminal_flag'] = 0;
    $filter['outgoing_flag'] = 1;
    // $filter['incoming_flag'] = 0;
    $filter['document_origin'] = $_POST['office'];
    $cursor = $collection->find($filter);
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

//terminal page
if (isset($_POST['terminal']) && isset($_POST['office'])){
    $filter = [];
    $filter['terminal_flag'] = 1;
    // $filter['outgoing_flag'] = 0;
    // $filter['incoming_flag'] = 0;
    $filter['document_destination'] = $_POST['office'];
    $cursor = $collection->find($filter);
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

//search by tracking number
if (isset($_POST['search']) && isset($_POST['tracking_number'])){
    $filter = [];
    $filter['tracking_number'] = $_POST['tracking_number'];
    $cursor = $collection->find($filter);
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

//delete by tracking number
if (isset($_POST['delete']) && isset($_POST['tracking_number'])){
    $filter = [];
    $filter['tracking_number'] = $_POST['tracking_number'];
    $cursor = $collection->deleteOne($filter);

    echo json_encode($cursor);
}
?>