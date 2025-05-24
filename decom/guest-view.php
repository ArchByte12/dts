<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DepED Document Tracking System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
<div id="logo">
            <img src="IMG/DepED logo.png" class="logo">
         </div>
        <div id="login-form" class="form">
            <h2>Track Document</h2>
            <form>
                <input type="tracknum" placeholder="Type the Document Tracking number here" required>
                <button type="submit" onclick="findDocument()">Find</button>
            </form>
            <a href="index.php" class="forgot-password">Login/Sign Up</a>
        </div>

    <div class="container table-container" id="tableContainer">
        <h2>Document Details</h2>
        <table>
            <tr>
                <th>Tracking Number</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <tr>
                <td id="docNumber"></td>
                <td id="docStatus"></td>
                <td id="docDate"></td>
            </tr>
        </table>
        <button class="btn btn-secondary" onclick="resetSearch()">Reset</button>
    </div>
    </div>
    <script>
        function findDocument() {
            let trackNumber = document.getElementById('trackNumber').value;
            if (trackNumber.trim() === "") {
                alert("Please enter a tracking number.");
                return;
            } else{
                document.getElementById('table-container').classList.add('active');
            document.getElementById('docNumber').innerText = trackNumber;
            document.getElementById('docStatus').innerText = "In Process";
            document.getElementById('docDate').innerText = "2025-02-16";
            document.getElementById('searchContainer').style.display = 'none';

        }
    }
        function resetSearch() {
            document.getElementById('trackNumber').value = "";
            document.getElementById('searchContainer').style.display = 'block';
            document.getElementById('tableContainer').classList.remove('active');d
        }
    </script>


    <footer>
        <p>&copy; <span id="year"></span> DepED Document Tracking System. All rights reserved. </p>
    </footer>
    <script>
        //footer
            document.getElementById('year').textContent =new Date().getFullYear();
    </script>
</body>
</html>
