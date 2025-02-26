<!-- Session -->
<?php
    include 'connection.php';
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index");
    }
?>