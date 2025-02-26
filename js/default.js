$(document).ready(function() {
    const $sidebarContainer = $('#default-container');
    // Load the sidebar.html content dynamically
    $.get('default/default-bar.php', function(data) {
        $sidebarContainer.html(data);

        const $sideNav = $('#sideNav');
        $sideNav.toggleClass('active');
        $('.content').css({
            'margin-left': '250px',
            'width': 'calc(95% - 250px)',
            'transition': '0.5s'
        });
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
    } else {
        $('.content').css({
            'margin-left': '0',
            'width': '95%',
            'transition': '0.5s'
        });
    }
}

// change status design for Pending, Approved and Rejected 
$(document).ready(function() {
    // Change status design for Pending, Approved and Rejected
    function updateStatusDesign() {
    $('td:contains("Pending")').html('<span class="badge badge-warning">Pending</span>');
    $('td:contains("Approved")').html('<span class="badge badge-success">Approved</span>');
    $('td:contains("Rejected")').html('<span class="badge badge-danger">Rejected</span>');
    }

    // Initial update
    updateStatusDesign();

    // Update status design after search
    $('#searchInput').on('keyup', function() {
    updateStatusDesign();
    });

    // Update status design pagination
    $('.pagination').on('click', function() {
    updateStatusDesign();
    });
});

// sideNav active class
$(document).ready(function() {
    $('.nav-link').click(function() {
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });
});