// modals
$(document).ready(function () {
    // Load the modal.html content dynamically
    const $modalContainer = $('#modal-container');
    $.get('default/modal.php', function (data) {
        $modalContainer.html(data);
    });
}
);

$(document).ready(function () {
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
        var $data = JSON.parse(localStorage.getItem('loginDetails'));
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

                // get and set fullname and email_address localStorage
                var $data = JSON.parse(localStorage.getItem('loginDetails'));
                var $fullname = $data.fullname;
                var $email_address = $data.email_address;
                $('#fullname').text($fullname);
                $('#email_address').text($email_address);

                // show modal
                $('#logoutModal-x').css({ 'display': 'block' });

                // Open Manage Account Modal
                $('#manageAccount').on('click', function () {

                    $(document).ready(function () {
                        // localStorage
                        var $data = JSON.parse(localStorage.getItem('loginDetails'));
                        // get and set from localStorage
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
    });
});

// active nav
$(document).ready(function () {
    const $navItems = $('li');
    $navItems.click(function () {
        alert('clicked');
        $navItems.removeClass('active');
        $(this).addClass('active');
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
    var name = fullname.split(' ');
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

// dateformatter DD-MMM-YY
function dateFormatter(date) {
    const dateObj = new Date(date);
    const day = String(dateObj.getDate()).padStart(2, '0');
    const month = dateObj.toLocaleString('en-US', { month: 'short' }).toUpperCase();
    const year = String(dateObj.getFullYear()).slice(-2); // Get the last two digits of the year
    return `${day}-${month}-${year}`;
}
