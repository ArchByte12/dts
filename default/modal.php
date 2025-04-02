<!-- logout modal -->
<div class="show" id="logoutModal-x">
    <div class="modal-content-x">
        <!-- head -->
        <div class="modal-head-x">
            <h5 class="x-h2" id="fullname"></h5>
            <!-- email -->
            <p class="x-p" id="email_address"></p>
        </div>
        <div class="modal-body-x">
            <!-- Manage Account -->
            <div class="first-row" id="manageAccount">
                <!-- arrow right -->
                <i class="fa-solid fa-user"></i>
                <p class="x-p">Manage Account</p>
            </div>
            <div class="second-row" id="logout_action">
                <!-- arrow right -->
                <i class="fa-solid fa-right-from-bracket"></i>
                <p class="x-p">Sign out</p>
            </div>
        </div>
    </div>
</div>
<!-- end of logout modal -->

<!-- Manage Account Modal -->
<div class="modal fade" id="manageAccountModal" tabindex="-1" aria-labelledby="manageAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title" id="manageAccountModalLabel">Manage Account</h6>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-md-1">
                            <i class="fa-solid fa-user"></i> <!-- Icon for Username -->
                        </div>
                        <div class="col-md-3 font-weight-bold">Username:</div>
                        <div class="col-md-6" id="username"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-1">
                            <i class="fa-solid fa-id-card"></i> <!-- Icon for Full Name -->
                        </div>
                        <div class="col-md-3 font-weight-bold">Full Name:</div>
                        <div class="col-md-6" id="fullName"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-1">
                            <i class="fa-solid fa-envelope"></i> <!-- Icon for Email -->
                        </div>
                        <div class="col-md-3 font-weight-bold">Email:</div>
                        <div class="col-md-6" id="manageEmail"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-1">
                            <i class="fa-solid fa-building"></i> <!-- Icon for Office -->
                        </div>
                        <div class="col-md-3 font-weight-bold">Office:</div>
                        <div class="col-md-6" id="office"></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-1">
                            <i class="fa-solid fa-briefcase"></i> <!-- Icon for Position -->
                        </div>
                        <div class="col-md-3 font-weight-bold">Position:</div>
                        <div class="col-md-6" id="position"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnUpdate">Update</button>
            </div>
        </div>
    </div>
</div>
<!-- end of Manage Account Modal -->