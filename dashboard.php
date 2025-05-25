<?php
session_start();
$sessionOffice = $_SESSION['office'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- default.css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- dashboard.css -->
    <link rel="stylesheet" href="css/dashboard.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div id="default-container"></div>
    <!-- Side Navigation -->
    <nav class="side-nav" id="sideNav">
        <ul>
            <!-- dashboard -->
            <li class="active"><a href="./dashboard"><i class="fa-solid fa-home"></i> Dashboard</a></li>
            <!-- create, track, incoming, outgoing, terminal docs, maintenance and user management -->
            <li><a href="./create"><i class="fa-solid fa-plus"></i> Create</a></li>
            <li><a href="./track"><i class="fa-solid fa-search"></i> Track</a></li>
            <li><a href="./incoming"><i class="fa-solid fa-inbox"></i> Incoming</a></li>
            <li><a href="./outgoing"><i class="fa-solid fa-paper-plane"></i> Outgoing</a></li>
            <li><a href="./terminal-docs"><i class="fa-solid fa-archive"></i> Terminal Docs</a></li>
            <!-- <li><a href="./maintenance"><i class="fa-solid fa-cogs"></i> Maintenance</a></li> -->
            <li><a href="./user-management"><i class="fa-solid fa-users"></i> User Management</a></li>
        </ul>
    </nav>
    <!-- modals -->
    <div id="modal-container"></div>
    <div class="content">
        <!-- Dashboard for incoming, outgoing, terminal docs and total Docs -->
        <!-- Main Content -->
        <div class="main-content">
            <h3>Dashboard</h3>
            <div class="dashboard">
                <div class="dashboard-card">
                    <div class="dashboard-content">
                        <span>No data</span>
                        <h6>Incoming</h6>
                    </div>
                    <!-- graph icon -->
                    <div class="dashboard-icon">
                        <img src="media/bar1.png" class="incoming_bar">
                    </div>
                </div>
                <div class="dashboard-card">
                    <div class="dashboard-content">
                        <span>No data</span>
                        <h6>Outgoing</h6>
                    </div>
                    <!-- graph icon -->
                    <div class="dashboard-icon">
                        <img src="media/bar2.png" class="outgoing_bar">
                    </div>
                </div>
                <?php if ($sessionOffice === 'Records Section'): ?>
                    <div class="dashboard-card">
                        <div class="dashboard-content">
                            <span>No data</span>
                            <h6>Terminal</h6>
                        </div>
                        <!-- graph icon -->
                        <div class="dashboard-icon">
                            <img src="media/bar2.png" class="terminal_bar">
                        </div>
                    </div>
                <?php endif; ?>
                <div class="dashboard-card">
                    <div class="dashboard-content">
                        <span>No data</span>
                        <h6>Pending</h6>
                    </div>
                    <div class="dashboard-icon">
                        <!-- circular graph -->
                        <canvas id="pendingCircleGraph"></canvas>
                    </div>
                </div>
            </div>
            <!-- dropdown by month year -->
            <div class="dropdown">
                <!-- select -->
                <select id="monthYearSelect" class="form-control">
                    <option value="all">All</option>
                    <!-- dynamic month year -->
                </select>
            </div>
            <!-- Chart Section -->
            <div class="chart-container">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- connection js -->
    <script src="js/connection.js"></script>
    <!-- chart js -->
    <script src="js/chart.js"></script>
    <!-- default -->
    <script src="js/default.js"></script>
    <script src="js/pendingCircleGraph.js"></script>
</body>

</html>