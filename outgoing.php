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
    <!-- Side Navigation -->
    <nav class="side-nav" id="sideNav">
        <ul>
            <!-- dashboard -->
            <li><a href="./dashboard"><i class="fa-solid fa-home"></i> Dashboard</a></li>
            <!-- create, track, incoming, outgoing, terminal docs, maintenance and user management -->
            <li><a href="./create"><i class="fa-solid fa-plus"></i> Create</a></li>
            <li><a href="./track"><i class="fa-solid fa-search"></i> Track</a></li>
            <li><a href="./incoming"><i class="fa-solid fa-inbox"></i> Incoming</a></li>
            <li class="active"><a href="./outgoing"><i class="fa-solid fa-paper-plane"></i> Outgoing</a></li>
            <li><a href="./terminal-docs"><i class="fa-solid fa-archive"></i> Terminal Docs</a></li>
            <!-- <li><a href="./maintenance"><i class="fa-solid fa-cogs"></i> Maintenance</a></li> -->
            <li><a href="./user-management"><i class="fa-solid fa-users"></i> User Management</a></li>
        </ul>
    </nav>
    <!-- modals -->
    <div id="modal-container"></div>
    <div class="content">
        <div class="container">
            <h3>Track Outgoing Document</h3>
            <!-- Search Input -->
            <div class="search-container">
                <!-- label -->
                <label for="searchInput">Search info:</label>
                <div class="input-group">
                    <input class="searchInput" id="searchInput" type="text" placeholder="Search">
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
                        <h5 class="modal-title" id="modalTrackingNumber">Document Details</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="viewModalBody">
                        <!-- Existing view modal body -->
                        <div class="container">
                            <div class="row mb-3">
                                <div class="col" id="modalDocumentTitle"></div>
                            </div>
                            <div class="row">
                                <div class="col font-weight-bold">Deadline:</div>
                                <div class="col" id="modalDeadline"></div>
                            </div>
                            <div class="row">
                                <div class="col font-weight-bold">Priority Status:</div>
                                <div class="col" id="modalPriorityStatus"></div>
                            </div>
                            <!-- Dropdown for Additional Details -->
                            <div class="row">
                                <a class="btn btn-link" data-toggle="collapse" data-target="#additionalDetails" aria-expanded="false" aria-controls="additionalDetails">
                                    <i class="fa-solid fa-info-circle"></i> Additional Details
                                </a>
                                <!-- Dropdown for remarks, notes, attached_link -->
                                <a class="btn btn-link" data-toggle="collapse" data-target="#remarksDetails" aria-expanded="false" aria-controls="remarksDetails">
                                    <i class="fa-solid fa-comment-alt"></i> Remarks
                                </a>
                            </div>
                            <div class="collapse" id="additionalDetails">
                                <div class="row mb-3">
                                    <div class="col-md-6 font-weight-bold">Status:</div>
                                    <div class="col-md-6" id="modalStatus"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 font-weight-bold">Originating Office:</div>
                                    <div class="col-md-6" id="modalOriginatingOffice"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 font-weight-bold">Destination Office:</div>
                                    <div class="col-md-6" id="modalDestinationOffice"></div>
                                </div>
                            </div>
                            <!-- remarksDetails -->
                            <div class="collapse" id="remarksDetails">
                                <div class="row mb-3">
                                    <div class="col-md-6 font-weight-bold">Notes:</div>
                                    <div class="col-md-6" id="notes"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 font-weight-bold">Rejected Reason:</div>
                                    <div class="col-md-6" id="rejected_reason"></div>
                                </div>
                                <!-- attached link -->
                                <div class="row mb-3">
                                    <div class="col-md-6 font-weight-bold">Attached Link:</div>
                                    <div id="attached_link"></div>
                                </div>
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
                        <!-- notes -->
                         <div class="form-field">
                            <label for="editNotes">Notes:</label>
                            <input type="text" id="editNotes" name="notes" class="form-control">
                         </div>
                         <!-- attached_link -->
                        <div class="form-field">
                            <label for="EditAttached_link">Attached Link:</label>
                            <input type="text" id="EditAttached_link" name="attached_link" class="form-control">
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

        // Function to open the modal
        function openModal(row) {
            // Populate edit modal with data using fetchByTrackingNumber
            fetchByTrackingNumber(row.tracking_number, function(record) {
                console.log('Record data:', record);
                $('#modalTrackingNumber').text(record.tracking_number);
                $('#modalDocumentTitle').text(record.document_title);
                $('#modalDeadline').text(dateFormatter(record.deadline));
                $('#modalPriorityStatus').text(record.priority_status);
                $('#modalStatus').text(record.status);
                $('#modalOriginatingOffice').text(record.document_origin);
                $('#modalDestinationOffice').text(record.document_destination);

                $('#modalDocumentTitle').html('<i class="fa-solid fa-file-alt"></i> ' + record.document_title);

                $('#rejected_reason').text(record.remarks);
                $('#notes').text(record.notes == null ? 'N/A' : record.notes);
                // if status is rejected, show rejected reason if null display none or dont show rejected reason
                if (record.status == 'Rejected') {
                    $('#rejected_reason').parent().removeClass('d-none');
                } else {
                    $('#rejected_reason').parent().addClass('d-none');
                }
                $('#attached_link').html(record.attached_link == '' ? 'N/A' : '<a href="' + record.attached_link + '" target="_blank">' + record.attached_link + '</a>');
            });

            // Show the modal
            $('#detailsModal').modal('show');
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
                $('#editNotes').val(record.notes);
                $('#EditAttached_link').val(record.attached_link);
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
            const notes = $('#editNotes').val();
            const attachedLink = $('#EditAttached_link').val();

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
                    updateByTrackingNumber(trackingNumber, documentDestination, documentTitle, deadline,
                        priorityStatus, notes, attachedLink);

                    // Insert tracking record
                    insert_tracking(trackingNumber, office, 'Updated document details', 'Document Updated');
                    $('#detailsModal').modal('hide');
                    viewOnly();
                }

                fetchData(); // Refresh the table data

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