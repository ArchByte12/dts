<!-- Session -->
<?php
include 'connection.php';
session_start();
ob_end_clean();

if (!isset($_SESSION['username'])) {
    // json response
    echo json_encode(array('status' => 'error', 'message' => 'Session expired'));
    exit();
} else {
    echo json_encode(array(
        'status' => 'success',
        'message' => 'Session active',
        'username' => $_SESSION['username'],
        'fullname' => $_SESSION['fullname'],
        'office' => $_SESSION['office'],
        'position' => $_SESSION['position'],
        'email_address' => $_SESSION['email_address']
    ));
}
?>