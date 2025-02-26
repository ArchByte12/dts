<!-- Session -->
<?php
    include 'conn/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Document</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <!-- dashboard.css -->
    <link rel="stylesheet" href="css/create.css">
    <!-- default.css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- main.css -->
    <link rel="stylesheet" href="css/main.css">
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <div id="default-container"></div>
    <div class="content">
        <!-- Create Document | input field name Tracking Number, Document Title, Document Destination, Deadline and Priority Status. Create and reset button -->
        <div class="form">
            <h2>Create Document</h2>
            <div class="form-container">
                <form action="#" method="POST" id="document-form">
                    <!-- Tracking Number Field -->
                    <div class="form-field">
                        <label for="tracking_number">Tracking Number:</label>
                        <input type="text" id="tracking_number" name="tracking_number" required>
                    </div>

                    <!-- Document Title Field -->
                    <div class="form-field">
                        <label for="document_title">Document Title:</label>
                        <input type="text" id="document_title" name="document_title" required>
                    </div>

                    <!-- Document Destination Field -->
                    <div class="form-field">
                        <label for="document_destination">Document Destination:</label>
                        <input type="text" id="document_destination" name="document_destination" required>
                    </div>

                    <!-- Deadline Field -->
                    <div class="form-field">
                        <label for="deadline">Deadline:</label>
                        <input type="date" id="deadline" name="deadline" required>
                    </div>

                    <!-- Priority Status Field -->
                    <div class="form-field">
                        <label for="priority_status">Priority Status:</label>
                        <select id="priority_status" name="priority_status" required>
                            <option value="Urgent">High</option>
                            <option value="High Priority">High Priority</option>
                            <option value="Medium Priority">Medium Priority</option>
                            <option value="Low Priority">Low Priority</option>
                        </select>
                    </div>

                    <!-- Create and Reset Buttons -->
                    <div class="form-actions">
                        <button type="submit" id="create_button">Create</button>
                        <button type="reset" id="reset_button">Reset</button>
                    </div>
                </form>
            </div>
            <!-- jquery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="js/default.js"></script>
</body>

</html>