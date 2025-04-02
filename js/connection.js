document.addEventListener("DOMContentLoaded", function () {
    const preloader = document.getElementById("preloader");

    // Show the preloader
    if (preloader) {
        preloader.style.display = "flex";
    }

    // Load fetch connection response
    fetch('conn/session.php')
        .then(response => response.json())
        .then(loginDetails => {
            if (preloader) {
                preloader.style.display = "none";
            }

            console.log('Login Details:', loginDetails);
            console.log('Current Path:', window.location.pathname);
            var page = window.location.pathname.split('/').pop();

            // Check login status
            if (loginDetails.status === 'success') {
                localStorage.setItem('loginDetails', JSON.stringify(loginDetails));
                if (page == 'index') {
                    window.location.href = 'dashboard';
                }
            } else {
                localStorage.removeItem('loginDetails');
                if (page != 'index') {
                    window.location.href = 'index';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (preloader) {
                preloader.style.display = "none";
            }
        });
});