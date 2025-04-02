// insert js code here
$(document).ready(function () {

    $('#document-form').submit(function (event) {
        event.preventDefault(); // Prevent the default form submission

        // tracking number, document title, document destination, deadline, priority
        var tracking_number = $('#tracking_number').val();
        var document_title = $('#document_title').val();
        var document_destination = $('#document_destination').val();
        var deadline = $('#deadline').val();
        var priority_status = $('#priority_status').val();

        $.ajax({
            url: 'conn/insert',
            type: 'POST',
            data: {
                tracking_number: tracking_number,
                document_title: document_title,
                document_destination: document_destination,
                deadline: deadline,
                priority_status: priority_status
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.status === "success") {
                    Swal.fire({
                        title: response.message,
                        icon: "success",
                        timer: 2000
                    }).then(function () {
                        // reset form
                        resetForm();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Insert Failed',
                        text: response.message,
                        confirmButtonText: 'Try Again'
                    });
                }
            }
        });
    });

});

// reset form
function resetForm() {
    $('#tracking_number').val(generateTrackingNumber());

    // Clear all other fields except the tracking number
    $('#document_title').val('');
    $('#document_destination').val('');
    $('#deadline').val('');
    $('#priority_status').val('');
}

// Intercept the reset event to regenerate the tracking number
$('#document-form').on('reset', function () {
    setTimeout(() => {
        $('#tracking_number').val(generateTrackingNumber());
    }, 0); // Delay to ensure the reset happens first
});

// Reset form on button click
$('#reset_button').click(function () {
    resetForm();
});