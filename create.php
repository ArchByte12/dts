<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Document</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- default.css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- dashboard.css -->
    <link rel="stylesheet" href="css/create.css">
    <!-- swalfire.css -->
    <link rel="stylesheet" href="css/swalfire.css">
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <li><a href="./dashboard"><i class="fa-solid fa-home"></i> Dashboard</a></li>
            <!-- create, track, incoming, outgoing, terminal docs, maintenance and user management -->
            <li class="active"><a href="./create"><i class="fa-solid fa-plus"></i> Create</a></li>
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
        <!-- Create Document | input field name Tracking Number, Document Title, Document Destination, Deadline and Priority Status. Create and reset button -->
        <div class="form">
            <h2>Create Document</h2>
            <div class="container">
                <form method="POST" id="document-form">
                    <!-- Tracking Number Field -->
                    <div class="form-field">
                        <label for="tracking_number"><i class="fas fa-hashtag"></i> Tracking Number:</label>
                        <input type="text" id="tracking_number" name="tracking_number" disabled>
                    </div>

                    <!-- Document Title Field -->
                    <div class="form-field">
                        <label for="document_title"><i class="fas fa-file-alt"></i> Document Title:</label>
                        <input type="text" id="document_title" name="document_title" placeholder="Document Title" required>
                    </div>

                    <!-- Document Destination Field -->
                    <div class="form-field">
                        <label for="document_destination"><i class="fas fa-map-marker-alt"></i> Document Destination:</label>
                        <select id="document_destination" name="document_destination" required>
                            <option value="" disabled selected>Select an Office</option>
                            <!-- Options will be populated here -->
                        </select>
                    </div>

                    <!-- Deadline Field -->
                    <div class="form-field">
                        <label for="deadline"><i class="fas fa-calendar-alt"></i> Deadline:</label>
                        <input type="date" id="deadline" name="deadline" required>
                    </div>

                    <!-- Priority Status Field -->
                    <div class="form-field">
                        <label for="priority_status"><i class="fas fa-exclamation-circle"></i> Priority Status:</label>
                        <select id="priority_status" name="priority_status" required>
                            <option value="Urgent">Urgent</option>
                            <option value="High Priority">High Priority</option>
                            <option value="Medium Priority">Medium Priority</option>
                            <option value="Low Priority">Low Priority</option>
                        </select>
                    </div>

                    <!-- Notes Field -->
                    <div class="form-field">
                        <label for="notes"><i class="fas fa-comment-alt"></i> Notes:</label>
                        <input type="text" id="notes" name="notes" placeholder="Enter notes here...">
                    </div>

                    <!-- Attached Link Field -->
                    <div class="form-field">
                        <label for="attached_link"><i class="fas fa-link"></i> Attached Link:</label>
                        <input type="url" id="attached_link" name="attached_link" placeholder="https://example.com">
                    </div>
                    <!-- errorMessage -->
                    <div class="error-message" id="error_message"></div>
                    <!-- Create and Reset Buttons -->
                    <div class="form-actions">
                        <button type="submit" id="create_button"><i class="fas fa-plus"></i> Create</button>
                        <button type="reset" id="reset_button"><i class="fas fa-redo"></i> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/default.js"></script>
    <!-- connection js -->
    <script src="js/connection.js"></script>
    <!-- validation js -->
    <script src="js/validation.js"></script>
    <!-- insert js -->
    <script src="js/insert.js"></script>
    <!-- destination js -->
    <script src="js/destination.js"></script>
</body>

</html>