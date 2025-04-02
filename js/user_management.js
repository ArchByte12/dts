function generatePassword(length = 8) {
    const characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const charactersLength = characters.length;
    let randomString = '';
    for (let i = 0; i < length; i++) {
        randomString += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return randomString;
}

function sendPasswordEmail(email, password) {
    const subject = "DTS Account Created";
    const message = `Your account has been created. Your password is: ${password}`;

    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'send_email_smtp.php',
            method: 'POST',
            data: {
                email: email,
                subject: subject,
                message: message
            },
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}

// Search and Pagination Script
let data = [];
const rowsPerPage = 5; // Number of rows per page
let currentPage = 1; // Current page

// Function to fetch data from the server
function fetchData() {
    $.ajax({
        url: 'conn/users_db.php',
        method: 'POST',
        dataType: 'json',
        data: {
            admin: true
        },
        success: function (response) {
            data = response;
            const filteredData = filterData();
            displayTable(filteredData);
            createPagination(filteredData);
        },
        error: function (error) {
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

    // Slice the data for current page
    const pageData = filteredData.slice(start, end);

    pageData.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${row.username}</td>
            <td>${row.fullname}</td>
            <td>${row.office}</td>
            <td>${row.position}</td>
            <td>
                <button class="x-btn-action" data-username="${row.username}" onclick="editUser('${row.username}')">Edit</button>
                <button class="btn-danger" data-username="${row.username}" onclick="deleteUser('${row.username}')">Delete</button>
            </td>
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
        return row.username.toLowerCase().includes(searchInput) ||
            row.office.toLowerCase().includes(searchInput) ||
            row.fullname.toLowerCase().includes(searchInput);
    });
}

// Event listener for search input
document.getElementById('searchInput').addEventListener('keyup', function () {
    currentPage = 1; // Reset to the first page on new search
    const filteredData = filterData();
    displayTable(filteredData);
    createPagination(filteredData);
});

// Event listener for username input
$('#username').on('blur', function () {
    const username = $(this).val();
    if (username) {
        checkUserExists('username', username);
    }
});

// Event listener for email input
$('#email').on('blur', function () {
    const email = $(this).val();
    if (email) {
        checkUserExists('email', email);
    }
});

function checkUserExists(field, value) {
    $.ajax({
        url: 'conn/check_user.php',
        method: 'POST',
        data: {
            [field]: value
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.status === "exists") {
                if (field === 'username') {
                    $('#CreateUserForm').addClass('is-invalid');
                    $('#CreateUserForm').next('.invalid-feedback').text("Warning: " + response.message).show();
                    $('.username').val('');
                    $('.username').focus();
                } else if (field === 'email') {
                    $('#CreateUserForm').addClass('is-invalid');
                    $('#CreateUserForm').next('.invalid-feedback').text("Warning: " + response.message).show();
                    $('#email').val('');
                    $('#email').focus();
                }
            } else {
                if (field === 'username') {
                    $('#CreateUserForm').removeClass('is-invalid');
                    $('#CreateUserForm').next('.invalid-feedback').hide();
                } else if (field === 'email') {
                    $('#CreateUserForm').removeClass('is-invalid');
                    $('#CreateUserForm').next('.invalid-feedback').hide();
                }
            }
        },
        error: function (error) {
            console.error('Error checking user data:', error);
        }
    });
}

// Event listener for save changes button in modal
document.getElementById('saveChanges').addEventListener('click', function () {
    const form = document.getElementById('CreateUserForm');
    const saveButton = document.getElementById('saveChanges');
    if (form.checkValidity()) {
        const password = generatePassword();
        const formData = {
            username: form.username.value,
            fullname: form.fullname.value,
            email: form.email.value,
            office: form.office.value,
            position: form.position.value,
            user_type: form.user_type.value,
            password: password
        };

        // Show loading indicator
        saveButton.disabled = true;
        saveButton.innerHTML = 'Saving...';

        // Send form data to the server using AJAX
        $.ajax({
            url: 'conn/create_user.php', // Change this to your server-side script
            method: 'POST',
            data: formData,
            success: function (response) {
                response = JSON.parse(response);
                console.log('Form Data Saved:', response);
                if (response.status === "success") {
                    sendPasswordEmail(formData.email, formData.password).then(() => {
                        // Hide loading indicator
                        saveButton.disabled = false;
                        saveButton.innerHTML = 'Save changes';

                        Swal.fire({
                            title: response.message,
                            icon: "success",
                            text: "Password sent to user email.",
                            timer: 2000
                        }).then(function () {
                            $('#customModal').modal('hide');
                            fetchData(); // Refresh the table data
                        });
                    }).catch(() => {
                        // Hide loading indicator
                        saveButton.disabled = false;
                        saveButton.innerHTML = 'Save changes';
                        Swal.fire({
                            icon: 'error',
                            title: 'Email Failed',
                            text: 'Failed to send password email.',
                            confirmButtonText: 'Try Again'
                        });
                    });
                } else {
                    // Hide loading indicator
                    saveButton.disabled = false;
                    saveButton.innerHTML = 'Save changes';
                    Swal.fire({
                        icon: 'error',
                        title: 'Insert Failed',
                        text: response.message,
                        confirmButtonText: 'Try Again'
                    });
                }
            },
            error: function (error) {
                console.error('Error saving form data:', error);
            }
        });
    } else {
        form.reportValidity();
    }
});

//updateChanges button in modal
document.getElementById('updateChanges').addEventListener('click', function () {
    const form = document.getElementById('UpdateUserForm');
    const saveButton = document.getElementById('updateChanges');
    if (form.checkValidity()) {
        const formData = {
            username: form.EditUsername.value,
            fullname: form.EditFullname.value,
            email: form.EditEmail.value,
            office: form.EditOffice.value,
            position: form.EditPosition.value,
            user_type: form.EditUser_type.value
        };
        // Show loading indicator
        saveButton.disabled = true;
        saveButton.innerHTML = 'Updating...';

        // Send form data to the server using AJAX
        $.ajax({
            url: 'conn/create_user.php', // Change this to your server-side script
            method: 'POST',
            data: formData,
            success: function (response) {
                response = JSON.parse(response);
                console.log('Form Data Updated:', response);
                if (response.status === "updated") {
                    // Hide loading indicator
                    saveButton.disabled = false;
                    saveButton.innerHTML = 'Save changes';

                    Swal.fire({
                        title: response.message,
                        icon: "success",
                        timer: 2000
                    }).then(function () {
                        $('#editUserModal').modal('hide');
                        fetchData(); // Refresh the table data
                    });
                } else {
                    // Hide loading indicator
                    saveButton.disabled = false;
                    saveButton.innerHTML = 'Save changes';
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: response.message,
                        confirmButtonText: 'Try Again'
                    });
                }
            },
            error: function (error) {
                console.error('Error updating form data:', error);
            }
        });
    } else {
        form.reportValidity();
    }
});

// Function to edit user
function editUser(username) {
    // Implement the logic to edit the user with the given username
    console.log('Edit user with username:', username);
    // alert('Edit user with username: ' + username);
    $.ajax({
        url: 'conn/users_db.php', // Backend script to fetch user data
        type: 'POST',
        data: { username: username },
        success: function (response) {
            const result = JSON.parse(response);

            if (result.status === 'success') {
                // Populate the modal fields with the user data
                openEditUserModal(result.data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message,
                });
            }
        },
        error: function (error) {
            console.error('Error fetching user data:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch user data.',
            });
        },
    });
}

// Open Edit User Modal and Populate Fields
function openEditUserModal(userData) {
    // Populate modal fields with user data
    $('#EditUsername').val(userData.username).prop('readonly', true);;
    $('#EditFullname').val(userData.fullname);
    $('#EditEmail').val(userData.email_address);
    $('#EditOffice').val(userData.office);
    $('#EditUser_type').val(userData.user_type);
    $('#EditPosition').val(userData.position);

    // Show the modal
    $('#editUserModal').modal('show');
}

// Function to delete user
function deleteUser(username) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'conn/delete_user.php',
                method: 'POST',
                data: { username: username },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status === "success") {
                        Swal.fire(
                            'Deleted!',
                            'User has been deleted.',
                            'success'
                        );
                        fetchData(); // Refresh the table data
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function (error) {
                    console.error('Error deleting user:', error);
                    Swal.fire(
                        'Error!',
                        'Failed to delete user.',
                        'error'
                    );
                }
            });
        }
    });
}

$(document).ready(function () {
    // Fetch document destinations from the server
    $.ajax({
        url: 'conn/manage_db.php',
        method: 'POST',
        dataType: 'json',
        data: {
            admin: true
        },
        success: function (response) {
            const destinationSelect = $('#getOffice');
            response.forEach(off => {
                const option = $('<option></option>').attr('value', off.office_name).text(off.office_name);
                destinationSelect.append(option);
            });

            const editDestinationSelect = $('#EditOffice');
            response.forEach(off => {
                const option = $('<option></option>').attr('value', off.office_name).text(off.office_name);
                editDestinationSelect.append(option);
            });
        },
        error: function (error) {
            console.error('Error fetching destinations:', error);
        }
    });
});