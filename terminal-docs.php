<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Document</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- default.css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- track css -->
    <link rel="stylesheet" href="css/track.css">
    <!-- swalfire.css -->
    <link rel="stylesheet" href="css/swalfire.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div id="default-container"></div>
    <!-- Authorization Check -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const loginDetails = localStorage.getItem('loginDetails');
            const sessionOffice = loginDetails ? JSON.parse(loginDetails).office : null;

            if (!sessionOffice || sessionOffice !== "Records Section") {
                document.body.innerHTML = `
                    <div style="text-align: center; margin-top: 20%;">
                        <h1>403 - Not Authorized</h1>
                        <p>You are not authorized to access this page.</p>
                        <a href="dashboard" style="text-decoration: none; color: blue; font-size:14px; padding:20px;">Go back to Dashboard</a>
                    </div>
                `;
                console.warn("User is not authorized to access this page.");
            }
        });
    </script>
    <!-- Side Navigation -->
    <nav class="side-nav" id="sideNav">
        <ul>
            <!-- dashboard -->
            <li><a href="./dashboard"><i class="fa-solid fa-home"></i> Dashboard</a></li>
            <!-- create, track, incoming, outgoing, terminal docs, maintenance and user management -->
            <li><a href="./create"><i class="fa-solid fa-plus"></i> Create</a></li>
            <li><a href="./track"><i class="fa-solid fa-search"></i> Track</a></li>
            <li><a href="./incoming"><i class="fa-solid fa-inbox"></i> Incoming</a></li>
            <li><a href="./outgoing"><i class="fa-solid fa-paper-plane"></i> Outgoing</a></li>
            <li class="active"><a href="./terminal-docs"><i class="fa-solid fa-archive"></i> Terminal Docs</a></li>
            <!-- <li><a href="./maintenance"><i class="fa-solid fa-cogs"></i> Maintenance</a></li> -->
            <li><a href="./user-management"><i class="fa-solid fa-users"></i> User Management</a></li>
        </ul>
    </nav>
    <!-- modals -->
    <div id="modal-container"></div>
    <div class="content">
        <div class="container">
            <h3>Track Document</h3>
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
                    <h5>Received Docs</h5>
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
                    <div class="modal-body">
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
                                <!-- Dropdown for Originating and Destination Office -->
                                <a class="btn btn-link" data-toggle="collapse" data-target="#officeDetails" aria-expanded="false" aria-controls="officeDetails">
                                    <i class="fa-solid fa-map-marker-alt"></i> Track Details
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
                            <div class="collapse" id="officeDetails">
                                <div class="tracking-timeline">
                                    <ul id="trackingTimeline">
                                        <!-- Timeline entries will be dynamically populated here -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="terminalModalFooter">
                        <button type="button" class="btn btn-danger" id="btnDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/default.js"></script>
    <!-- connection js -->
    <script src="js/connection.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/table.js"></script>
    <!-- fetchRecord js -->
    <script src="js/fetchRecord.js"></script>

    <!-- Search and Pagination Script -->
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
                    terminal: true,
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

            fetch_tracking(row.tracking_number, function(response) {
                if (response.length === 0) {
                    $('#trackingTimeline').html('No tracking history available');
                } else {
                    populateTrackingTimeline(response);
                }
            });

            // Show the modal
            $('#detailsModal').modal('show');
        }

        // Initial setup
        fetchData();
    </script>
</body>

</html>