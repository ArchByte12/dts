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
        var notes = $('#notes').val();
        var attached_link = $('#attached_link').val();

        console.log("inserting : " + tracking_number, document_title, document_destination, deadline, priority_status, notes, attached_link);

        const deadlineInput = document.getElementById('deadline');
        const deadlineDate = new Date(deadlineInput.value);
        const currentDate = new Date();

        // Remove time from current date for comparison
        currentDate.setHours(0, 0, 0, 0);

        const errorMessage = document.getElementById('error_message');

        if (deadlineDate <= currentDate) {
            event.preventDefault(); // Prevent form submission
            // alert('The deadline must be a date greater than today.');
            deadlineInput.style.border = '2px solid red'; // Highlight the input box with a red border

            // Show error message
            errorMessage.textContent = 'Invalid date, must be greater than current date.';
            errorMessage.style.color = 'red';
        } else {
            // Reset the border color if the date is valid
            deadlineInput.style.border = ''; // Reset the border color
            // Hide error message
            errorMessage.textContent = ''; // Clear the error message
            errorMessage.style.color = ''; // Reset the color
            // Proceed with form submission
            $.ajax({
                url: 'conn/insert',
                type: 'POST',
                data: {
                    tracking_number: tracking_number,
                    document_title: document_title,
                    document_destination: document_destination,
                    deadline: deadline,
                    priority_status: priority_status,
                    notes: notes,
                    attached_link: attached_link
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status === "success") {
                        Swal.fire({
                            title: response.message,
                            icon: "success",
                            timer: 2000
                        }).then(function () {
                            // localStorage
                            var $data = JSON.parse(localStorage.getItem('loginDetails'));
                            var office = $data.office;
                            insert_tracking(tracking_number, office, 'Document Created', 'Initial submission');

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
        }
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
    $('#notes').val('');
    $('#attached_link').val('');
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