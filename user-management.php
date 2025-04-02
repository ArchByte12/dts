<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- icon -->
    <link rel="icon" href="media/DepED logo.png">
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- default.css -->
    <link rel="stylesheet" href="css/default.css">
    <!-- track css -->
    <link rel="stylesheet" href="css/track.css">
    <!-- management css -->
    <link rel="stylesheet" href="css/management.css">
    <!-- swalfire.css -->
    <link rel="stylesheet" href="css/swalfire.css">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div id="default-container"></div>
    <!-- modals -->
    <div id="modal-container"></div>
    <!-- Custom Modal -->
    <div class="modal fade" id="customModal" tabindex="-1" role="dialog" aria-labelledby="customModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- <div class="modal-header"> -->
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title" id="customModalLabel">Create User</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Modal content goes here -->
                    <form id="CreateUserForm">
                        <div class="form-group flex-container">
                            <label for="username">Username</label>
                            <input type="text" class="form-control username" id="username" name="username" placeholder="Enter Unique username" required>
                        </div>
                        <div class="form-group flex-container">
                            <label for="fullname">Fullname</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Fullname" required>
                        </div>
                        <div class="form-group flex-container">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" required>
                        </div>
                        <div class="form-group flex-container">
                            <label for="getOffice">Office</label>
                            <select class="form-control" id="getOffice" name="getOffice" required>
                                <option value="" disabled selected>Select Office</option>
                                <!-- Options will be populated here -->
                            </select>
                        </div>
                        <div class="form-group flex-container">
                            <label for="type">User type</label>
                            <select class="form-control" id="user_type" name="user_type" required>
                                <option value="" disabled selected>Select User Type</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                        <div class="form-group flex-container">
                            <label for="position">Position</label>
                            <input type="text" class="form-control" id="position" name="position" placeholder="Enter Position" required>
                        </div>
                    </form>
                    <div class="invalid-feedback" id="invalid-feedback" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveChanges">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- <div class="modal-header"> -->
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title" id="customModalLabel">Create User</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Modal content goes here -->
                    <form id="UpdateUserForm">
                        <div class="form-group flex-container">
                            <label for="EditUsername">Username</label>
                            <input type="text" class="form-control EditUsername" id="EditUsername" name="EditUsername" placeholder="Enter Unique username" required>
                        </div>
                        <div class="form-group flex-container">
                            <label for="EditFullname">Fullname</label>
                            <input type="text" class="form-control" id="EditFullname" name="EditFullname" placeholder="Enter Fullname" required>
                        </div>
                        <div class="form-group flex-container">
                            <label for="EditEmail">Email Address</label>
                            <input type="email" class="form-control" id="EditEmail" name="EditEmail" placeholder="Enter Email Address" required>
                        </div>
                        <div class="form-group flex-container">
                            <label for="EditOffice">Office</label>
                            <select class="form-control" id="EditOffice" name="EditOffice" required>
                                <option value="" disabled selected>Select Office</option>
                                <!-- Options will be populated here -->
                            </select>
                        </div>
                        <div class="form-group flex-container">
                            <label for="EditUser_type">User type</label>
                            <select class="form-control" id="EditUser_type" name="EditUser_type" required>
                                <option value="" disabled selected>Select User Type</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                        <div class="form-group flex-container">
                            <label for="EditPosition">Position</label>
                            <input type="text" class="form-control" id="EditPosition" name="EditPosition" placeholder="Enter Position" required>
                        </div>
                    </form>
                    <div class="invalid-feedback" id="invalid-feedback" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="updateChanges">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="container-header">
                <h3>Users</h3>
                <i class="fa-solid fa-user-plus" data-toggle="modal" data-target="#customModal"></i>
            </div>
            <!-- Search Input -->
            <div class="search-container">
                <!-- label -->
                <label for="searchInput">Search:</label>
                <div class="input-group">
                    <input class="searchInput" id="searchInput" type="text" placeholder="&#xf002;">
                </div>
            </div>
            <div class="table-container">
                <!-- h5 title -->
                <dv class="x-title">
                    <h5>List of users</h5>
                </dv>
                <!-- Table -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Fullname</ht>
                            <th>Office</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Table rows will go here -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="nav-pagination">
                <ul class="pagination" id="paginationLinks">
                    <!-- Pagination links will go here -->
                </ul>
            </nav>
        </div>
    </div>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/default.js"></script>
    <!-- connection js -->
    <script src="js/connection.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/table.js"></script>
    <script src="js/user_management.js"></script>
    <script>
        fetchData();
    </script>
</body>

</html>