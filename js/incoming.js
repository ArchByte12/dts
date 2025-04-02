$(document).ready(function () {
    // Handle "Receive" button click
    $('#btnReceive').click(function () {
        const trackingNumber = $('#modalTrackingNumber').text();

        // Show confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to mark the document with Tracking Number: ${trackingNumber} as received?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Receive it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                const status = 'Received';
                // change button text to "Processing..."
                $('#btnReceive').html('Processing...');
                updateStatus(trackingNumber, status);
            }
        });
    });

    // Handle "Reject/Return" button click
    $('#btnReject').click(function () {
        const trackingNumber = $('#modalTrackingNumber').text();

        // Show confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to reject/return the document with Tracking Number: ${trackingNumber}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Reject it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                const status = 'Rejected';
                // change button text to "Processing..."
                $('#btnReject').html('Processing...');
                updateStatus(trackingNumber, status);
            }
        });
    });

    // receive or reject/return document ajax request
    // Function to send the AJAX request for receiving the document
    function updateStatus(trackingNumber, status) {
        $.ajax({
            url: 'conn/update.php',
            method: 'POST',
            data: {
                tracking_number: trackingNumber,
                status: status
            },
            success: function (response) {
                const data = JSON.parse(response); // Parse the JSON response
                if (data.status === 'success') {
                    Swal.fire({
                        title: data.message,
                        icon: "success",
                        text: data.message,
                        timer: 1000,
                        showConfirmButton: false
                    }).then(function () {
                        // reset button text to "Receive"
                        $('#btnReceive').html('Receive');
                        // reset button text to "Reject/Return"
                        $('#btnReject').html('Reject/Return');

                        $('#detailsModal').modal('hide');
                        fetchData(); // Refresh the table data
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        icon: "error",
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    icon: "error",
                    text: 'Failed to update the document. Please try again.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Handle "Forward" button click
    $('#btnForward').click(function () {
        const trackingNumber = $('#modalTrackingNumber').text();

        // Fetch input options dynamically from the server
        $.ajax({
            url: 'conn/manage_db.php',
            method: 'POST',
            dataType: 'json',
            data: {
                admin: true
            },
            success: function (response) {
                const inputOptions = {};

                // Populate inputOptions with office_name data
                response.forEach((office) => {
                    inputOptions[office.office_name] = office.office_name;
                });

                // Show confirmation dialog with dynamic select input
                Swal.fire({
                    title: 'Forward Document',
                    text: `Select the destination to forward the document with Tracking Number: ${trackingNumber}:`,
                    icon: 'info',
                    input: 'select',
                    inputOptions: inputOptions,
                    inputPlaceholder: 'Select an office',
                    showCancelButton: true,
                    confirmButtonText: 'Forward',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'You need to select a destination!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const destination = result.value; // Get the selected destination
                        forwardDocument(trackingNumber, destination);
                    }
                });
            }
        });
    });

    // Function to send the AJAX request for forwarding the document
    function forwardDocument(trackingNumber, destination) {
        $.ajax({
            url: 'conn/update.php',
            method: 'POST',
            data: {
                tracking_number: trackingNumber,
                document_destination: destination
            },
            success: function (response) {
                const data = JSON.parse(response); // Parse the JSON response
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        icon: 'success',
                        text: `Document forwarded to ${destination} successfully.`,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        $('#detailsModal').modal('hide');
                        fetchData(); // Refresh the table data
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        icon: 'error',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    icon: 'error',
                    text: 'Failed to forward the document. Please try again.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }
    // Handle "Mark as Terminal" button click
    $('#btnMarkTerminal').click(function () {
        const trackingNumber = $('#modalTrackingNumber').text();

        // Show confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to mark the document with Tracking Number: ${trackingNumber} as terminal?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Mark it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                const terminal_flag = true;
                // change button text to "Processing..."
                $('#btnMarkTerminal').html('Processing...');
                updateTerminal(trackingNumber, terminal_flag);
            }
        });
    });

    // Function to send the AJAX request for marking the document as terminal
    function updateTerminal(trackingNumber, terminal_flag) {
        $.ajax({
            url: 'conn/update.php',
            method: 'POST',
            data: {
                tracking_number: trackingNumber,
                terminal_flag: terminal_flag
            },
            success: function (response) {
                const data = JSON.parse(response); // Parse the JSON response
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        icon: 'success',
                        text: `Document with Tracking Number: ${trackingNumber} has been marked as terminal.`,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(function () {
                        // reset button text to "Mark as Terminal"
                        $('#btnMarkTerminal').html('Mark as Terminal');
                        $('#detailsModal').modal('hide');
                        fetchData(); // Refresh the table data
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        icon: 'error',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function () {
                Swal.fire({
                    title: 'Error!',
                    icon: 'error',
                    text: 'Failed to mark the document as terminal. Please try again.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }
});