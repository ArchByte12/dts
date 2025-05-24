// Fetch record by tracking number
function fetchByTrackingNumber(trackingNumber, callback) {
    $.ajax({
        url: 'conn/track_db.php',
        method: 'POST',
        dataType: 'json',
        data: {
            search: true,
            tracking_number: trackingNumber
        },
        success: function (response) {
            if (response) {
                console.log('Record fetched successfully:', response[0]);
                callback(response[0]); // Pass the data to the callback function
            } else {
                console.error('Error: No data found or invalid response:', response);
            }
        },
        error: function (error) {
            console.error('Error fetching data:', error);
        }
    });
}

// Delete record by tracking number
function deleteByTrackingNumber(trackingNumber, callback) {
    $.ajax({
        url: 'conn/track_db.php',
        method: 'POST',
        data: {
            delete: true,
            tracking_number: trackingNumber
        },
        success: function (response) {
            if (response) {
                console.log('Record deleted successfully:', response);
                Swal.fire({
                    title: 'Success!',
                    icon: 'success',
                    text: `Document with Tracking Number: ${trackingNumber} has been deleted.`,
                    timer: 2000,
                    showConfirmButton: false
                }).then(function () {
                    callback(response); // Pass the data to the callback function
                });
            } else {
                console.error('Error: No data found or invalid response:', response);
            }
        },
        error: function (error) {
            console.error('Error deleting data:', error);
        }
    });
}

// Update record by tracking number
function updateByTrackingNumber(trackingNumber, documentDestination, documentTitle, deadline, priorityStatus,
    notes_update, attachedLink, callback) {
    $.ajax({
        url: 'conn/update.php',
        method: 'POST',
        data: {
            tracking_number: trackingNumber,
            document_destination: documentDestination,
            document_title: documentTitle,
            deadline: deadline,
            priority_status: priorityStatus,
            notes: notes_update,
            attached_link: attachedLink
        },
        success: function (response) {
            if (response) {
                console.log('Record updated successfully:', response);
                Swal.fire({
                    title: 'Success!',
                    icon: 'success',
                    text: `Document with Tracking Number: ${trackingNumber} has been updated.`,
                    timer: 1000,
                    showConfirmButton: false
                }).then(function () {
                    callback(response[0]); // Pass the data to the callback function
                });
            } else {
                console.error('Error updating data:', response[0]);
                Swal.fire({
                    title: 'Error!',
                    icon: 'error',
                    text: 'Failed to update the document. Please try again.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        }
    });
}