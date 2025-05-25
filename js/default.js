// Reusable function to get login details from localStorage
function getLoginDetails() {
    const loginDetails = localStorage.getItem('loginDetails');
    return loginDetails ? JSON.parse(loginDetails) : null;
}

var $data = getLoginDetails();
var sessionOffice = $data ? $data.office : null;

// If sessionOffice is null or not found, fetch details from session.php
if (!sessionOffice) {
    console.warn("sessionOffice is null or not found. Fetching details from session.php...");
    fetch('conn/session.php')
        .then(response => response.json())
        .then(loginDetails => {
            if (loginDetails.status === 'success') {
                localStorage.setItem('loginDetails', JSON.stringify(loginDetails));
                sessionOffice = loginDetails.office;
                console.log("sessionOffice updated:", sessionOffice);

                // Re-run logic dependent on sessionOffice
                if (sessionOffice !== "Records Section") {
                    const terminalDocsNav = document.querySelector('a[href="./terminal-docs"]');
                    if (terminalDocsNav) {
                        terminalDocsNav.parentElement.remove();
                    }
                }
            } else {
                console.error("Failed to fetch session details. Redirecting to index...");
                window.location.href = 'index';
            }
        })
        .catch(error => {
            console.error("Error fetching session details:", error);
        });
}

// modals
$(document).ready(function () {
    // Load the modal.html content dynamically
    const $modalContainer = $('#modal-container');
    $.get('default/modal.php', function (data) {
        $modalContainer.html(data);
    });

    const $sidebarContainer = $('#default-container');
    // Load the sidebar.html content dynamically
    $.get('default/default-bar.php', function (data) {
        $sidebarContainer.html(data);

        const $sideNav = $('#sideNav');
        $sideNav.toggleClass('active');
        $('.content').css({
            'margin-left': '250px',
            'width': 'calc(95% - 250px)',
            'transition': '0.5s'
        });
        // change hamburger-menu icon
        $('.hamburger-menu i').removeClass('fa-bars').addClass('fa-ellipsis-vertical');

        const $logoutDropdown = $('#user-settings');
        // set dropdown text
        var $userFullname = $data.fullname;
        const $thumbnail = getThumbnail($userFullname);
        $('#dropdown').html($thumbnail);
        // Load the dropdown.html content dynamically
        $logoutDropdown.click(function () {
            if ($logoutDropdown.hasClass('show')) {
                $logoutDropdown.removeClass('show');
                $('#logoutModal-x').css({ 'display': 'none' });
            } else {
                $logoutDropdown.addClass('show');

                // get and set fullname and email_address from loginDetails
                var $data = getLoginDetails();
                var $fullname = $data.fullname;
                var $email_address = $data.email_address;
                $('#fullname').text($fullname);
                $('#email_address').text($email_address);

                // show modal
                $('#logoutModal-x').css({ 'display': 'block' });

                // Open Manage Account Modal
                $('#manageAccount').on('click', function () {
                    $(document).ready(function () {
                        // get and set from loginDetails
                        var $data = getLoginDetails();
                        var $username = $data.username;
                        var $fullname = $data.fullname;
                        var $office = $data.office;
                        var $position = $data.position;
                        var $email_address = $data.email_address;

                        $('#username').text($username);
                        $('#fullName').text($fullname);
                        $('#office').text($office);
                        $('#position').text($position);
                        $('#manageEmail').text($email_address);
                    });

                    // Show the modal
                    $('#manageAccountModal').modal('show');
                });

                // logout conn/logout.php
                $('#logout_action').click(function () {
                    $.get('conn/logout.php', function (data) {
                        location.reload();
                    });
                });
            }
            // close modal if clicked outside
            $(window).click(function (event) {
                if (!$(event.target).closest('#logoutModal-x').length && !$(event.target).is('#dropdown')) {
                    $logoutDropdown.removeClass('show');
                    $('#logoutModal-x').css({ 'display': 'none' });
                }
            });
        });

        // Check session office and remove terminal-docs side-nav if not Records Section
        if (sessionOffice !== "Records Section") {
            const terminalDocsNav = document.querySelector('a[href="./terminal-docs"]');
            if (terminalDocsNav) {
                terminalDocsNav.parentElement.remove();
            }
        }
    });
});

function toggleNav() {
    const $sideNav = $('#sideNav');
    $sideNav.toggleClass('active');
    if ($sideNav.hasClass('active')) {
        $('.content').css({
            'margin-left': '250px',
            'width': 'calc(95% - 250px)',
            'transition': '0.5s'
        });
        // change hamburger-menu icon
        $('.hamburger-menu i').removeClass('fa-bars').addClass('fa-ellipsis-vertical');
    } else {
        $('.content').css({
            'margin-left': '0',
            'width': '95%',
            'transition': '0.5s'
        });
        // change hamburger-menu icon
        $('.hamburger-menu i').removeClass('fa-ellipsis-vertical').addClass('fa-bars');
    }
}

// User fullname tumbnail for replace dropdown : Ex: Kent Abulag -> KA
function getThumbnail(fullname) {
    // var name = fullname.split(' ');
    //if name has more than 2 parts, take the first two and has only one
    var name = fullname.split(' ');
    if (name.length > 2) {
        name = [name[0], name[1]]; // Take only the first two parts
    }else{
        name = [name[0], '']; // If only one part, use the first part and an empty string
    }
    var thumbnail = name[0].charAt(0) + name[1].charAt(0);
    return thumbnail.toUpperCase();
}

// Toggle btn delete
$('#btnDelete').on('click', function () {
    const trackingNumber = $('#modalTrackingNumber').text().trim();
    console.log('Deleting record for tracking number:', trackingNumber);

    // Show confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to delete the document with Tracking Number: ${trackingNumber}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it!',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
    }).then((result) => {
        if (result.isConfirmed) {
            deleteByTrackingNumber(trackingNumber);
            $('#detailsModal').modal('hide');
            $('#editModalBody').addClass('d-none');
            fetchData(); // Refresh the table data
        }
    });
});

// dateformatter DD-MMM-YYYY
function dateFormatter(date) {
    const dateObj = new Date(date);
    const day = String(dateObj.getDate()).padStart(2, '0'); // Get day with leading zero
    const month = dateObj.toLocaleString('en-US', { month: 'short' }).toUpperCase(); // Get short month name in uppercase
    const year = dateObj.getFullYear(); // Get full year (YYYY)
    return `${day}-${month}-${year}`;
}

// dateformatter DD-MMM-YYYY HH:mm:ss
function dateFormatterWithTimeStamp(dateString) {
    const dateObj = new Date(dateString);

    // Format date
    const day = String(dateObj.getDate()).padStart(2, '0'); // Get day with leading zero
    const month = dateObj.toLocaleString('en-US', { month: 'short' }).toUpperCase(); // Get short month name in uppercase
    const year = dateObj.getFullYear(); // Get full year (YYYY)

    // Format time
    const hours = String(dateObj.getHours()).padStart(2, '0'); // Get hours with leading zero
    const minutes = String(dateObj.getMinutes()).padStart(2, '0'); // Get minutes with leading zero
    const seconds = String(dateObj.getSeconds()).padStart(2, '0'); // Get seconds with leading zero

    return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
}

// insert_tracking function
/**
 * Function to insert tracking data
 * @param {string} trackingNumber - The tracking number of the document
 * @param {string} office - The office performing the action
 * @param {string} action - The action performed (e.g., "Document Created")
 * @param {string} remarks - Additional remarks or comments
 */
function insert_tracking(trackingNumber, office, action, remarks) {
    $.ajax({
        url: 'conn/insert_tracking.php',
        method: 'POST',
        data: {
            tracking_number: trackingNumber,
            office: office,
            action: action,
            remarks: remarks
        },
        success: function (response) {
            console.log('Raw response from insert_tracking.php:', response); // Debugging
            try {
                const result = JSON.parse(response);
                if (result.status === 'success') {
                    console.log('Tracking data inserted successfully:', result.message);
                } else {
                    console.error('Error inserting tracking data:', result.message);
                }
            } catch (error) {
                console.error('Error parsing JSON response:', error);
            }
        },
        error: function (error) {
            console.error('AJAX error:', error);
        }
    });
}

/**
 * Function to fetch tracking data
 * @param {string} trackingNumber - The tracking number of the document
 * @param {function} callback - A callback function to handle the fetched data
 */
function fetch_tracking(trackingNumber, callback) {
    console.log('Fetching tracking data for:', trackingNumber); // Debugging
    $.ajax({
        url: 'conn/fetch_tracking.php',
        method: 'POST',
        data: {
            tracking_number: trackingNumber
        },
        success: function (response) {
            console.log('Response from fetch_tracking.php:', response); // Debugging
            try {
                const result = JSON.parse(response);
                if (result.status === 'success') {
                    console.log('Tracking data fetched successfully:', result.data); // Debugging
                    callback(result.data); // Pass the fetched data to the callback function
                } else {
                    console.error('Error fetching tracking data:', result.message);
                    callback([]); // Pass an empty array if there's an error
                }
            } catch (error) {
                console.error('Error parsing JSON response:', error);
                callback([]); // Pass an empty array if JSON parsing fails
            }
        },
        error: function (error) {
            console.error('AJAX error:', error);
            callback([]); // Pass an empty array if AJAX fails
        }
    });
}

/**
 * Function to populate the tracking timeline
 * @param {Array} trackingHistory - Array of tracking history objects
 */
function populateTrackingTimeline(trackingHistory) {
    console.log('Populating tracking timeline with data:', trackingHistory); // Debugging
    const timeline = document.getElementById('trackingTimeline');
    timeline.innerHTML = ''; // Clear existing entries

    // Check if trackingHistory is valid
    if (!Array.isArray(trackingHistory)) {
        console.error('Invalid trackingHistory:', trackingHistory); // Debugging
        timeline.innerHTML = '<p>No tracking history available.</p>';
        return;
    }

    trackingHistory.forEach(entry => {
        const li = document.createElement('li');
        li.innerHTML = `
            <div class="timeline-content">
                <span class="dot"></span>
                <div class="details">
                    <h6>${entry.date}</h6>
                    <p><strong>Office:</strong> ${entry.office}</p>
                    <p><strong>Action:</strong> ${entry.action}</p>
                    <p><strong>Remarks:</strong> ${entry.remarks || 'N/A'}</p>
                </div>
            </div>
        `;
        timeline.appendChild(li);
    });
}

// Ensure only one dropdown is open at a time
document.querySelectorAll('[data-toggle="collapse"]').forEach(button => {
    button.addEventListener('click', function () {
        const target = this.getAttribute('data-target');
        document.querySelectorAll('.collapse').forEach(collapse => {
            if (collapse.id !== target.replace('#', '') && collapse.classList.contains('show')) {
                $(collapse).collapse('hide');
            }
        });
    });
});