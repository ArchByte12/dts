<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepED Document Tracking System</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <!-- default.css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- index.css -->
    <link rel="stylesheet" href="css/index.css">
    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- swalfire -->
    <link rel="stylesheet" href="css/swalfire.css">
    <!-- default css -->
    <link rel="stylesheet" href="css/default.css">
</head>

<body>
    <div class="form-container">
        <div class="form-header">
            <div class="tab" id="login-tab">Login</div>
            <div class="tab" id="guest-tab">Guest</div>
        </div>

        <!-- Login Form -->
        <div id="logo">
            <img src="media/DepED logo.png" class="logo">
        </div>
        <div id="login-form" class="form">
            <h2>Login</h2>
            <form id="loginForm" name="loginForm" method="POST">
                <input type="username" name="username" id="username" placeholder="Username" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <button type="submit" class="login" id="login">Log In</button>
            </form>
        </div>

        <!-- Guest View -->
        <div id="guest-view" class="form" style="display:none;">
            <h2>Track Document</h2>
            <form>
                <input type="text" placeholder="Tracking Number" required>
                </select>
                <button type="submit">Find</button>
            </form>

        </div>
    </div>

    <script>
    // Toggle between login and guest forms
    document.getElementById('login-tab').addEventListener('click', () => {
        document.getElementById('login-form').style.display = 'block';
        document.getElementById('guest-view').style.display = 'none';
        document.getElementById('login-tab').classList.add('active');
        document.getElementById('guest-tab').classList.remove('active');
    });

    document.getElementById('guest-tab').addEventListener('click', () => {
        document.getElementById('guest-view').style.display = 'block';
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('guest-tab').classList.add('active');
        document.getElementById('login-tab').classList.remove('active');
    });

    // tab.active
    document.getElementById('login-tab').classList.add('active');
    </script>

    <footer>
        <p>&copy; <span id="year"></span> DepED Document Tracking System. All rights reserved. </p>
    </footer>
    <script>
    //footer
    document.getElementById('year').textContent = new Date().getFullYear();
    </script>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jquery login -->
    <script src="js/login.js"></script>
</body>

</html>