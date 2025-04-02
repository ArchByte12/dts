<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepED Document Tracking System</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- default.css -->
    <!-- <link rel="stylesheet" href="css/default.css"> -->
    <!-- index.css -->
    <link rel="stylesheet" href="css/index.css">
    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- swalfire -->
    <link rel="stylesheet" href="css/swalfire.css">
    <!-- default css -->
    <link rel="stylesheet" href="css/default.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="form-container">
        <div class="form-header">
            <div class="tab" id="login-tab">Login</div>
            <div class="tab" id="guest-tab">Guest</div>
        </div>

        <!-- Login Form -->
        <div id="logo">
            <img src="media/DepED.png" class="logo">
        </div>
        <!-- Login Form -->
        <div id="login-form" class="form">
            <h2>Login</h2>
            <form id="loginForm" name="loginForm" method="POST">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="login btn btn-primary" id="login">Log In</button>
                <a href="#" class="forgot-password">Forgot Password?</a>
            </form>
        </div>

        <!-- Guest View -->
        <div id="guest-view" class="form" style="display:none;">
            <h2>Track Document</h2>
            <form id="guestForm">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" id="trackingInput" class="form-control" placeholder="Tracking Number" required>
                </div>
                <button type="submit" id="findButton" class="btn btn-primary">Find</button>
            </form>
        </div>
    </div>

    <!-- Track Modal -->
    <div class="modal fade" id="trackModal" tabindex="-1" role="dialog" aria-labelledby="trackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="trackModalLabel">Track Document Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-3">
                            <div class="col-md-6 font-weight-bold">Tracking Number:</div>
                            <div class="col-md-6" id="modalTrackingNumber"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 font-weight-bold">Document Title:</div>
                            <div class="col-md-6" id="modalDocumentTitle"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 font-weight-bold">Deadline:</div>
                            <div class="col-md-6" id="modalDeadline"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 font-weight-bold">Priority Status:</div>
                            <div class="col-md-6" id="modalPriorityStatus"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 font-weight-bold">Originating Office:</div>
                            <div class="col-md-6" id="modalOriginatingOffice"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- connection js -->
    <script src="js/connection.js"></script>

    <script>
        // Toggle between login and guest forms
        document.getElementById('login-tab').addEventListener('click', () => {
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('guest-view').style.display = 'none';
            document.getElementById('login-tab').classList.add('active');
            document.getElementById('guest-tab').classList.remove('active');
        });

        document.getElementById('guest-tab').addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default behavior
            document.getElementById('guest-view').style.display = 'block';
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('guest-tab').classList.add('active');
            document.getElementById('login-tab').classList.remove('active');
        });

        // tab.active
        document.getElementById('login-tab').classList.add('active');

        const findButton = document.getElementById('findButton');

        // Modal functionality
        $('#guestForm').on('submit', function(event) {
            event.preventDefault();

            const trackingNumber = $('#trackingInput').val();

            // Show loading indicator
            findButton.disabled = true;
            findButton.innerHTML = 'Searching...';

            // Check tracking number in MongoDB
            $.ajax({
                url: 'conn/check_tracking.php',
                type: 'POST',
                data: {
                    trackingNumber: trackingNumber
                },
                success: function(response) {
                    response = JSON.parse(response);
                    // alert(response.tracking_number);
                    // alert(data);
                    if (response.exists) {
                        $('#modalTrackingNumber').text(response.tracking_number);
                        $('#modalDocumentTitle').text(response.document_title);
                        $('#modalDeadline').text(response.deadline);
                        $('#modalPriorityStatus').text(response.priority_status);
                        $('#modalOriginatingOffice').text(response.document_origin);

                        // Hide loading indicator
                        findButton.disabled = false;
                        findButton.innerHTML = 'Find';

                        $('#trackModal').modal('show');
                    } else {
                        // Hide loading indicator
                        findButton.disabled = false;
                        findButton.innerHTML = 'Find';

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Tracking number not found!'
                        });
                    }
                }
            });
        });

        // Prevent default behavior for guest tab click
        document.getElementById('guest-tab').addEventListener('click', function(event) {
            event.preventDefault();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const yearElement = document.getElementById('year');
            if (yearElement) {
                yearElement.textContent = new Date().getFullYear();
            }
        });
    </script>

    <footer>
        <p>&copy; <span id="year"></span> DepED Document Tracking System. All rights reserved. </p>
    </footer>
</body>

</html>