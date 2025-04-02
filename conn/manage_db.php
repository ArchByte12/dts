<?php
require 'connection.php';
session_start();
ob_end_clean();

$database = $client->selectDatabase('dts_db');
$collection = $database->selectCollection('offices');

//Manage offices
if (isset($_POST['admin'])){
    $cursor = $collection->find();
    $data = iterator_to_array($cursor);

    echo json_encode($data);
}

?>