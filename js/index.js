// Toggle between login and guest forms
document.getElementById('login-tab').addEventListener('click', () => {
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('guest-view').style.display = 'none';
    document.getElementById('login-tab').classList.add('active');
    document.getElementById('guest-tab').classList.remove('active');

    // hide reset password form
    document.getElementById('reset-password-form').style.display = 'none';
    document.getElementById('verify-reset-form').style.display = 'none';
});

document.getElementById('guest-tab').addEventListener('click', (event) => {
    event.preventDefault(); // Prevent default behavior
    document.getElementById('guest-view').style.display = 'block';
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('guest-tab').classList.add('active');
    document.getElementById('login-tab').classList.remove('active');

    // hide reset password form
    document.getElementById('reset-password-form').style.display = 'none';
    document.getElementById('verify-reset-form').style.display = 'none';
});

// tab.active
document.getElementById('login-tab').classList.add('active');

const findButton = document.getElementById('findButton');

// Modal functionality
$('#guestForm').on('submit', function (event) {
    event.preventDefault();

    const trackingNumber = $('#trackingInput').val();
    const errorMessage = document.getElementById('errorMessage');
    const captchaResponse = grecaptcha.getResponse(); // Get the CAPTCHA response

    //conn/verify_captcha.php
    // Verify CAPTCHA response
    $.ajax({
        url: 'conn/verify_captcha.php',
        type: 'POST',
        data: {
            captchaResponse: captchaResponse
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.success) {
                // Show loading indicator
                findButton.disabled = true;
                findButton.innerHTML = 'Searching...';

                // CAPTCHA verified successfully
                console.log('CAPTCHA verified successfully');
                $.ajax({
                    url: 'conn/check_tracking.php',
                    type: 'POST',
                    data: {
                        trackingNumber: trackingNumber
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        // alert(response.tracking_number);
                        // alert(data);
                        if (response.exists) {
                            $('#modalTrackingNumber').text(response.tracking_number);
                            $('#modalDocumentTitle').html('<i class="fa-solid fa-file-alt"></i> ' + response.document_title);
                            $('#modalDeadline').text(response.deadline);
                            $('#modalPriorityStatus').text(response.priority_status);
                            $('#modalStatus').text(response.status);
                            $('#modalOriginatingOffice').text(response.document_origin);
                            $('#modalDestinationOffice').text(response.document_destination);

                            //if remarks is null 
                            if (response.status == 'Rejected') {
                                $('#modalRemarks').text(response.remarks);
                            } else {
                                $('#rejected_rsn').html('No remarks.');
                            }

                            fetch_tracking(response.tracking_number, function (response) {
                                if (response.length === 0) {
                                    $('#trackingTimeline').html('No tracking history available');
                                } else {
                                    populateTrackingTimeline(response);
                                }
                            });

                            // Hide loading indicator
                            findButton.disabled = false;
                            findButton.innerHTML = 'Find';

                            $('#trackModal').modal('show');

                            //errorMessage
                            errorMessage.textContent = ''; // Clear any previous error message
                        } else {
                            // Hide loading indicator
                            findButton.disabled = false;
                            findButton.innerHTML = 'Find';
                            // Display the error message
                            errorMessage.textContent = 'Tracking number not found!';
                        }
                    }
                });
            }else{
                // CAPTCHA verification failed
                errorMessage.textContent = 'CAPTCHA verification failed. Please try again.';
                errorMessage.style.color = 'red';
                findButton.disabled = false;
                findButton.innerHTML = 'Find';
                grecaptcha.reset(); // Reset the CAPTCHA
                return; // Stop form submission
            }
        },
        error: function () {
            // Handle AJAX error
            errorMessage.textContent = 'An error occurred while verifying CAPTCHA. Please try again.';
            errorMessage.style.color = 'red';
            findButton.disabled = false;
            findButton.innerHTML = 'Find';
            return; // Stop form submission
        }
    });
});

// Toggle Reset Password Form
document.getElementById('reset-password-link').addEventListener('click', (event) => {
    event.preventDefault();
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('reset-password-form').style.display = 'block';

    // Add #recovery to the URL
    window.location.hash = 'recovery';
});

// Back to Login Form
document.getElementById('back-to-login').addEventListener('click', (event) => {
    event.preventDefault();
    document.getElementById('reset-password-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';

    // Remove #recovery from the URL
    window.location.hash = '';
});

// Check URL hash on page load
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.hash === '#recovery') {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('reset-password-form').style.display = 'block';
    }
});

// Handle Reset Password Form Submission
$('#resetPasswordForm').on('submit', function (event) {
    event.preventDefault();

    const email = $('#email').val();
    const resetPasswordButton = $('#resetPasswordButton');

    // Show loading indicator
    resetPasswordButton.prop('disabled', true).text('Sending...');

    // Send reset code to email
    $.ajax({
        url: 'conn/send_reset_code.php',
        type: 'POST',
        data: {
            email: email
        },
        success: function (response) {
            response = JSON.parse(response);
            console.log(response);
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Reset code sent to your email!'
                });
                // Toggle Reset Password Verification Form
                document.getElementById('reset-password-form').style.display = 'none';
                document.getElementById('verify-reset-form').style.display = 'block';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to send reset code.'
                });
            }
            resetPasswordButton.prop('disabled', false).text('Send Reset Code');
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred. Please try again.'
            });
            resetPasswordButton.prop('disabled', false).text('Send Reset Code');
        }
    });
});

// Back to Reset Password Form
document.getElementById('back-to-reset').addEventListener('click', (event) => {
    event.preventDefault();
    document.getElementById('verify-reset-form').style.display = 'none';
    document.getElementById('reset-password-form').style.display = 'block';
});

// Handle Reset Password Verification Form Submission
$('#verifyResetForm').on('submit', function (event) {
    event.preventDefault();

    const resetCode = $('#reset_code').val();
    const newPassword = $('#new_password').val();
    const verifyResetButton = $('#verifyResetButton');

    // Show loading indicator
    verifyResetButton.prop('disabled', true).text('Verifying...');

    // Verify reset code and update password
    $.ajax({
        url: 'conn/verify_reset_code.php',
        type: 'POST',
        data: {
            reset_code: resetCode,
            new_password: newPassword
        },
        success: function (response) {
            response = JSON.parse(response);
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Password reset successfully!'
                }).then(() => {
                    window.location.hash = '';
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to reset password.'
                });
            }
            verifyResetButton.prop('disabled', false).text('Reset Password');
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred. Please try again.'
            });
            verifyResetButton.prop('disabled', false).text('Reset Password');
        }
    });
});

// Prevent default behavior for guest tab click
document.getElementById('guest-tab').addEventListener('click', function (event) {
    event.preventDefault();
});

document.addEventListener('DOMContentLoaded', function () {
    const yearElement = document.getElementById('year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }
});

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