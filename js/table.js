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
        <td>${row.document_origin}</td>
        <td>${row.document_title}</td>
        <td>${row.tracking_number}</td>
        <td>${row.status}</td>
        <td>${row.document_destination}</td>
        <td><button class="x-btn-action" onclick="openModal(${JSON.stringify(row).replace(/"/g, '&quot;')})">View</button></td>
    `;
        tableBody.appendChild(tr);
    });
    updateStatusDesign();
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
document.getElementById('searchInput').addEventListener('keyup', function () {
    currentPage = 1; // Reset to the first page on new search
    const filteredData = filterData();
    displayTable(filteredData);
    createPagination(filteredData);
});

// change status design for Pending, Approved and Rejected 
$(document).ready(function () {
    // Initial update
    updateStatusDesign();

    // Update status design after search
    $('#searchInput').on('keyup', function () {
        updateStatusDesign();
    });

    // Update status design pagination
    $('.pagination').on('click', function () {
        updateStatusDesign();
    });
});

// Change status design for Pending, Approved and Rejected
function updateStatusDesign() {
    $('td:contains("Pending")').html('<span class="badge badge-warning">Pending</span>');
    $('td:contains("Approved")').html('<span class="badge badge-success">Approved</span>');
    $('td:contains("Rejected")').html('<span class="badge badge-danger">Rejected</span>');
    $('td:contains("Received")').html('<span class="badge badge-success">Received</span>');

}