<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outgoing</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- default css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- track css -->
    <link rel="stylesheet" href="css/track.css">
    <!-- outgoing css -->
    <link rel="stylesheet" href="css/outgoing.css">
    <!-- swalfire.css -->
    <link rel="stylesheet" href="css/swalfire.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div id="default-container"></div>
    <!-- modals -->
    <div id="modal-container"></div>
    <div class="content">
        <div class="container">
            <h3>Track Outgoing Document</h3>
            <!-- Search Input -->
            <div class="search-container">
                <!-- label -->
                <label for="searchInput">Tracking Number:</label>
                <div class="input-group">
                    <input class="searchInput" id="searchInput" type="text" placeholder="&#xf002;">
                </div>
            </div>
            <div class="table-container">
                <!-- h5 title -->
                <dv class="x-title">
                    <h5>Sent Docs</h5>
                </dv>
                <!-- Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <!-- Origination Office, Title, Doc. No., Status, Office Destination and Action -->
                            <th>Origination Office</th>
                            <th>Title</th>
                            <th>Doc. No.</th>
                            <th>Status</th>
                            <th>Office Destination</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Table rows will go here -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="nav-pagination">
                <ul class="pagination" id="paginationLinks">
                    <!-- Pagination links will go here -->
                </ul>
            </nav>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="detailsModalLabel">Document Details</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="viewModalBody">
                        <!-- Existing view modal body -->
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
                    <div class="modal-body d-none" id="editModalBody">
                        <!-- Hidden edit modal body -->
                        <div class="form-field">
                            <label for="editTrackingNumber">Tracking Number:</label>
                            <input type="text" class="form-control" id="editTrackingNumber">
                        </div>
                        <div class="form-field">
                            <label for="editDocumentTitle">Document Title:</label>
                            <input type="text" class="form-control" id="editDocumentTitle">
                        </div>
                        <div class="form-field">
                            <label for="document_destination">Document Destination:</label>
                            <select type="text" class="form-control" id="document_destination">
                                <!-- Options will be populated here -->
                            </select>
                        </div>
                        <div class="form-field">
                            <label for="editDeadline">Deadline:</label>
                            <input type="date" class="form-control" id="editDeadline">
                        </div>
                        <div class="form-field">
                            <label for="editPriorityStatus">Priority Status:</label>
                            <select class="form-control" id="editPriorityStatus">
                                <option value="Urgent">Urgent</option>
                                <option value="High Priority">High Priority</option>
                                <option value="Medium Priority">Medium Priority</option>
                                <option value="Low Priority">Low Priority</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer" id="outgoingModalFooter">
                        <button type="button" class="btn btn-primary" id="btnEdit">Edit</button>
                        <button type="button" class="btn btn-danger" id="btnDelete">Delete</button>
                        <button type="button" class="btn btn-success d-none" id="btnSave">Save</button>
                        <button type="button" class="btn btn-secondary d-none" id="btnCancel">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/default.js"></script>
    <!-- connection js -->
    <script src="js/connection.js"></script>
    <script src="js/table.js"></script>
    <!-- destination js -->
    <script src="js/destination.js"></script>
    <!-- fetchRecord js -->
    <script src="js/fetchRecord.js"></script>
    <script>
        let data = [];
        const rowsPerPage = 5; // Number of rows per page
        let currentPage = 1; // Current page

        // localStorage
        var $data = JSON.parse(localStorage.getItem('loginDetails'));
        // get and set from localStorage
        var office = $data.office;

        // Function to fetch data from the server
        function fetchData() {
            $.ajax({
                url: 'conn/track_db.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    outgoing: true,
                    office: office
                },
                success: function(response) {
                    data = response;
                    const filteredData = filterData();
                    displayTable(filteredData);
                    createPagination(filteredData);
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Toggle between view and edit modal bodies
        $('#btnEdit').on('click', function() {
            $('#viewModalBody').addClass('d-none');
            $('#editModalBody').removeClass('d-none');
            $('#btnEdit').addClass('d-none');
            $('#btnDelete').addClass('d-none');
            $('#btnSave').removeClass('d-none');
            $('#btnCancel').removeClass('d-none');

            const trackingNumber = $('#modalTrackingNumber').text().trim();
            console.log('Fetching record for tracking number:', trackingNumber);

            // Populate edit modal with data using fetchByTrackingNumber
            fetchByTrackingNumber(trackingNumber, function(record) {
                console.log('Record data:', record);
                $('#editTrackingNumber').val(record.tracking_number).prop('readonly', true);
                $('#editDocumentTitle').val(record.document_title);
                $('#document_destination').val(record.document_destination);
                $('#editDeadline').val(record.deadline);
                $('#editPriorityStatus').val(record.priority_status);
            });
        });

        $('#btnCancel').on('click', function() {
            viewOnly();
        });

        $('#btnSave').on('click', function() {
            const trackingNumber = $('#editTrackingNumber').val();
            const documentTitle = $('#editDocumentTitle').val();
            const documentDestination = $('#document_destination').val();
            const deadline = $('#editDeadline').val();
            const priorityStatus = $('#editPriorityStatus').val();

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to save the changes for Tracking Number: ${trackingNumber}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Save it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with saving the changes
                    updateByTrackingNumber(trackingNumber, documentDestination, documentTitle, deadline, priorityStatus);
                    $('#detailsModal').modal('hide');
                    fetchData(); // Refresh the table data
                    viewOnly();
                }
            });
        });

        //click close button modal
        $('#detailsModal').on('hidden.bs.modal', function() {
            viewOnly();
        });

        function viewOnly() {
            $('#editModalBody').addClass('d-none');
            $('#viewModalBody').removeClass('d-none');
            $('#btnSave').addClass('d-none');
            $('#btnCancel').addClass('d-none');
            $('#btnEdit').removeClass('d-none');
            $('#btnDelete').removeClass('d-none');
        }
        
        // Initial setup
        fetchData();
    </script>
</body>

</html>