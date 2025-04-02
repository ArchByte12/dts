$(document).ready(function() {
    // Fetch document destinations from the server
    $.ajax({
        url: 'conn/manage_db.php',
        method: 'POST',
        dataType: 'json',
        data: {
            admin: true
        },
        success: function(response) {
            const destinationSelect = $('#document_destination');
            response.forEach(off => {
                const option = $('<option></option>').attr('value', off
                    .office_name).text(off.office_name);
                destinationSelect.append(option);
            });
        },
        error: function(error) {
            // alert(error);
            console.error('Error fetching destinations:', error);
        }
    });
});