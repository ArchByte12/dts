<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Document</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <!-- connection js -->
    <script src="js/connection.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- default css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- track css -->
    <link rel="stylesheet" href="css/track.css">
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
            <li class="active"><a href="./track"><i class="fa-solid fa-search"></i> Track</a></li>
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
                    <h5>Search Result</h5>
                </dv>
                <!-- Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <!-- Origination Office, Title, Doc. No., Status, Office Destination and Category -->
                            <th>Origination Office</th>
                            <th>Title</th>
                            <th>Doc. No.</th>
                            <th>Status</th>
                            <th>Office Destination</th>
                            <th>Category</th>
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
                                <div class="col font-weight-bold">Created Date:</div>
                                <div class="col" id="modalCreatedDate"></div>
                            </div>
                            <div class="row">
                                <div class="col font-weight-bold">Updated Date:</div>
                                <div class="col" id="modalUpdatedDate"></div>
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
                                    <div class="col-md-6 font-weight-bold">Deadline:</div>
                                    <div class="col-md-6" id="modalDeadline"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 font-weight-bold">Priority Status:</div>
                                    <div class="col-md-6" id="modalPriorityStatus"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 font-weight-bold">Status:</div>
                                    <div class="col-md-6" id="modalStatus"></div>
                                </div>
                            </div>
                            <div class="collapse" id="officeDetails">
                                <div class="tracking-timeline">
                                    <ul id="trackingTimeline">
                                        <!-- Timeline entries will be dynamically populated here -->
                                    </ul>
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
                        <div class="modal-footer"></div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="js/default.js"></script>
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
                        track: true,
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
            // Function to display the table rows
            function displayTable(filteredData) {
                const start = (currentPage - 1) * rowsPerPage;
                const end = currentPage * rowsPerPage;
                const tableBody = document.getElementById('tableBody');
                tableBody.innerHTML = '';

                // Slice the data for the current page
                const pageData = filteredData.slice(start, end);

                pageData.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
            <td>${row.document_origin}</td>
            <td>${row.document_title}</td>
            <td>
                <a href="#" onclick="openModal(${JSON.stringify(row).replace(/"/g, '&quot;')})">
                    ${row.tracking_number}
                </a>
            </td>
            <td>${row.status}</td>
            <td>${row.document_destination}</td>
            <td>${row.priority_status}</td>
        `;
                    tableBody.appendChild(tr);
                });
                updateStatusDesign();
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
                    $('#modalCreatedDate').text(dateFormatterWithTimeStamp(record.created_date));
                    //set default if null
                    if (record.updated_date == null) {
                        $('#modalUpdatedDate').text('N/A');
                    } else {
                        $('#modalUpdatedDate').text(dateFormatterWithTimeStamp(record.updated_date));
                    }

                    // Populate modal with sample data
                    $('#modalTrackingNumber').text("Tracking No. " + row.tracking_number);
                    $('#modalDocumentTitle').html('<i class="fa-solid fa-file-alt"></i> ' + record.document_title);
                    $('#rejected_reason').text(record.remarks);
                    $('#notes').text(record.notes == null ? 'N/A' : record.notes);
                    // if status is rejected, show rejected reason if null display none or dont show rejected reason
                    if (record.status == 'Rejected') {
                        $('#rejected_reason').parent().removeClass('d-none');
                    } else {
                        $('#rejected_reason').parent().addClass('d-none');
                    }
                    $('#attached_link').html(record.attached_link == null ? 'N/A' : '<a href="' + record.attached_link + '" target="_blank">' + record.attached_link + '</a>');
                });

                fetch_tracking(row.tracking_number, function(response) {
                    if (response.length === 0) {
                        $('#trackingTimeline').html('No tracking history available');
                    } else {
                        populateTrackingTimeline(response);
                    }
                });
                $('#detailsModal').modal('show');
            }

            // Function to create the pagination links
            function createPagination(filteredData) {
                const paginationLinks = document.getElementById('paginationLinks');
                paginationLinks.innerHTML = '';

                const totalPages = Math.ceil(filteredData.length / rowsPerPage);

                // Create Previous page button
                const prevButton = document.createElement('li');
                prevButton.classList.add('page-item');
                prevButton.innerHTML = `<a class="page-link" href="#" aria-label="Previous">&laquo;</a>`;
                prevButton.onclick = () => changePage(currentPage - 1);
                paginationLinks.appendChild(prevButton);

                // Create page number buttons
                for (let i = 1; i <= totalPages; i++) {
                    const pageButton = document.createElement('li');
                    pageButton.classList.add('page-item');
                    pageButton.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    pageButton.onclick = () => changePage(i);
                    paginationLinks.appendChild(pageButton);
                }

                // Create Next page button
                const nextButton = document.createElement('li');
                nextButton.classList.add('page-item');
                nextButton.innerHTML = `<a class="page-link" href="#" aria-label="Next">&raquo;</a>`;
                nextButton.onclick = () => changePage(currentPage + 1);
                paginationLinks.appendChild(nextButton);
            }

            // Function to change the page
            function changePage(pageNumber) {
                const filteredData = filterData(); // Get filtered data
                const totalPages = Math.ceil(filteredData.length / rowsPerPage);

                if (pageNumber < 1 || pageNumber > totalPages) return;

                currentPage = pageNumber;
                displayTable(filteredData);
                createPagination(filteredData);
            }

            // Function to filter data based on search input
            function filterData() {
                const searchInput = document.getElementById('searchInput').value.toLowerCase();
                return data.filter(row => {
                    return row.tracking_number.toLowerCase().includes(searchInput) ||
                        row.status.toLowerCase().includes(searchInput) ||
                        row.priority_status.toLowerCase().includes(searchInput) ||
                        row.document_title.toLowerCase().includes(searchInput);
                });
            }

            // Event listener for search input
            document.getElementById('searchInput').addEventListener('keyup', function() {
                currentPage = 1; // Reset to the first page on new search
                const filteredData = filterData();
                displayTable(filteredData);
                createPagination(filteredData);
            });

            // Initial setup
            fetchData();
        </script>
</body>

</html>