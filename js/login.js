$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        var username = $('#username').val();
        var password = $('#password').val();
        $.ajax({
            url: 'conn/login',
            type: 'POST',
            data: {
                username: username,
                password: password
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.status === "success") {
                    swal.fire({
                        title: "Login Successful",
                        // text: "Redirecting to Dashboard",
                        icon: "success",
                        timer: 2000
                        // showConfirmButton: false
                    }
                    ).then(function() {
                        window.location = "dashboard";
                    });
                } else {
                    // swal.fire("Login Failed", "", "error");
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: 'Invalid username or password.',
                        confirmButtonText: 'Try Again'
                    });
                }
            }
        });
    });
});