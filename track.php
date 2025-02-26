<!-- Session -->
<?php
    include 'conn/session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Document</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- default css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- track css -->
    <link rel="stylesheet" href="css/track.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> -->
</head>

<body>
    <div id="default-container"></div>
    <div class="content">
        <div class="container">
            <h3>Track Document</h3>
            <!-- Search Input -->
            <div class="search-container">
                <!-- label -->
                <label for="searchInput">Tracking Number:</label>
                <div class="input-group">
                    <input class="searchInput" id="searchInput" type="text" placeholder="&#xf002;">
                </div>
            </div>
            <div class="table-container">
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
    </div>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/default.js"></script>

    <!-- Search and Pagination Script -->
    <script>
    const data = [
            // <!-- Origination Office, Title, Doc. No., Status, Office Destination and Category -->
        {   originationOffice: 'Office A',
            title: 'Document 1',
            docNo: '001',
            status: 'Pending',
            officeDestination: 'Office B',
            category: 'Category 1'
        },
        {
            originationOffice: 'Office C',
            title: 'Document 2',
            docNo: '002',
            status: 'Approved',
            officeDestination: 'Office D',
            category: 'Category 2'
        },
        {
            originationOffice: 'Office E',
            title: 'Document 3',
            docNo: '003',
            status: 'Rejected',
            officeDestination: 'Office F',
            category: 'Category 3'
        },
        {
            originationOffice: 'Office G',
            title: 'Document 4',
            docNo: '004',
            status: 'Pending',
            officeDestination: 'Office H',
            category: 'Category 4'
        },
        {
            originationOffice: 'Office I',
            title: 'Document 5',
            docNo: '005',
            status: 'Approved',
            officeDestination: 'Office J',
            category: 'Category 5'
        },
        {
            originationOffice: 'Office K',
            title: 'Document 6',
            docNo: '006',
            status: 'Rejected',
            officeDestination: 'Office L',
            category: 'Category 6'
        },
        {
            originationOffice: 'Office M',
            title: 'Document 7',
            docNo: '007',
            status: 'Pending',
            officeDestination: 'Office N',
            category: 'Category 7'
        },
        {
            originationOffice: 'Office O',
            title: 'Document 8',
            docNo: '008',
            status: 'Approved',
            officeDestination: 'Office P',
            category: 'Category 8'
        },
        {
            originationOffice: 'Office Q',
            title: 'Document 9',
            docNo: '009',
            status: 'Rejected',
            officeDestination: 'Office R',
            category: 'Category 9'
        },
        {
            originationOffice: 'Office S',
            title: 'Document 10',
            docNo: '010',
            status: 'Pending',
            officeDestination: 'Office T',
            category: 'Category 10'
        },
        {
            originationOffice: 'Office U',
            title: 'Document 11',
            docNo: '011',
            status: 'Approved',
            officeDestination: 'Office V',
            category: 'Category 11'
        },
        {
            originationOffice: 'Office W',
            title: 'Document 12',
            docNo: '012',
            status: 'Rejected',
            officeDestination: 'Office X',
            category: 'Category 12'
        },
        {
            originationOffice: 'Office Y',
            title: 'Document 13',
            docNo: '013',
            status: 'Pending',
            officeDestination: 'Office Z',
            category: 'Category 13'
        }
    ];

    const rowsPerPage = 5; // Number of rows per page
    let currentPage = 1; // Current page

    // Function to display the table rows
    function displayTable(filteredData) {
        const start = (currentPage - 1) * rowsPerPage;
        const end = currentPage * rowsPerPage;
        const tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = '';

        // Slice the data for current page
        const pageData = filteredData.slice(start, end);

        pageData.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.originationOffice}</td>
                <td>${row.title}</td>
                <td>${row.docNo}</td>
                <td>${row.status}</td>
                <td>${row.officeDestination}</td>
                <td>${row.category}</td>
            `;
            tableBody.appendChild(tr);
        });
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
            return row.docNo.toLowerCase().includes(searchInput) ||
                row.status.toLowerCase().includes(searchInput);
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
    const filteredData = filterData();
    displayTable(filteredData);
    createPagination(filteredData);
    </script>
</body>

</html>