<?php
require 'connection.php';
session_start();
ob_end_clean();

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('documents');

// Tracking page
if (isset($_POST['track']) && isset($_POST['office'])) {
    $filter = [];
    // if office = Records Section, then show all documents
    if ($_POST['office'] == 'Records Section') {
        $filter = []; // No filter, show all documents
    } else {
        // if office is not Records Section, filter by document_origin
        $filter['document_origin'] = $_POST['office'];
    }
    $cursor = $collection->find($filter);
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

//Incoming page
if (isset($_POST['incoming']) && isset($_POST['office'])) {
    $filter = [];
    // if office is Records Section, then show all documents
    if ($_POST['office'] == 'Records Section') {
        $filter['incoming_flag'] = 1;
    } else {
        // if office is not Records Section, filter by document_destination
        $filter['document_destination'] = $_POST['office'];
        $filter['incoming_flag'] = 1; // Ensure incoming_flag is set
    }
    $cursor = $collection->find($filter);
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

//outgoing page
if (isset($_POST['outgoing']) && isset($_POST['office'])) {
    $filter = [];
    // if office is Records Section, then show all documents
    if ($_POST['office'] == 'Records Section') {
        $filter['outgoing_flag'] = 1;
    } else {
        // if office is not Records Section, filter by document_origin
        $filter['outgoing_flag'] = 1;
        $filter['document_origin'] = $_POST['office'];
    }
    $cursor = $collection->find($filter);
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

//terminal page
if (isset($_POST['terminal']) && isset($_POST['office'])) {
    $filter = [];
    // if office is Records Section, then show all documents
    if ($_POST['office'] == 'Records Section') {
        $filter['terminal_flag'] = 1;
    } else {
        // if office is not Records Section, filter by document_destination
        $filter['terminal_flag'] = 1;
        $filter['document_destination'] = $_POST['office'];
    }
    $cursor = $collection->find($filter);
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

//search by tracking number
if (isset($_POST['search']) && isset($_POST['tracking_number'])) {
    $filter = [];
    $filter['tracking_number'] = $_POST['tracking_number'];
    $cursor = $collection->find($filter);
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

//delete by tracking number
if (isset($_POST['delete']) && isset($_POST['tracking_number'])) {
    $filter = [];
    $filter['tracking_number'] = $_POST['tracking_number'];
    $cursor = $collection->deleteOne($filter);

    echo json_encode($cursor);
}
