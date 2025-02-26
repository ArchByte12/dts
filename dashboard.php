<!-- Session -->
<?php
    include 'conn/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <!-- dashboard.css -->
    <link rel="stylesheet" href="css/dashboard.css">
    <!-- default.css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <div id="default-container"></div>
    <div class="content">
        <!-- Dashboard for incoming, outgoing, terminal docs and total Docs -->
        <!-- Main Content -->
        <div class="main-content">
            <h2>Dashboard</h2>
            <div class="dashboard">
                <div class="card">
                    <span>1</span>
                    <h6>Incoming</h6>
                </div>
                <div class="card">
                    <span>2</span>
                    <h6>Outgoing</h6>
                </div>
                <div class="card">
                    <span>3</span>
                    <h6>Terminal Docs</h6>
                </div>
                <div class="card">
                    <span>4</span>
                    <h6>Total Docs</h6>
                </div>
            </div>
        </div>
    </div>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/default.js"></script>
</body>

</html>