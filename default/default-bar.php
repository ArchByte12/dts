<header class="top-header">
    <div class="hamburger-menu">
        <div class="toggle" onclick="toggleNav()">
            <i class="fa-solid fa-bars"></i>
        </div>
        <span>DepED</span>
    </div>
    <div class="user-settings">
        <!-- Notification, UserName(icon) and dropdown icon -->
        <i class="fa-solid fa-bell"></i>
        <span>John Doe</span>
        <!-- <i class="fa-solid fa-user"></i> -->
        <img src="media/user.png" alt="User">
        <i class="fa-solid fa-chevron-down" id="dropdown"></i>
        <!-- logout form -->
        <div id="logoutModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Are you sure you want to logout?</h2>
            <button id="confirmLogout">Yes, Logout</button>
            <button id="cancelLogout">Cancel</button>
        </div>
    </div>
    </div>
</header>
<!-- Side Navigation -->
<nav class="side-nav" id="sideNav">
    <ul>
        <!-- dashboard -->
        <li><a href="./dashboard"><i class="fa-solid fa-home"></i> Dashboard</a></li>
        <!-- create, track, incoming, outgoing, terminal docs, maintenance and user management -->
        <li><a href="./create"><i class="fa-solid fa-plus"></i> Create</a></li>
        <li><a href="./track"><i class="fa-solid fa-search"></i> Track</a></li>
        <li><a href="./incoming"><i class="fa-solid fa-inbox"></i> Incoming</a></li>
        <li><a href="./outgoing"><i class="fa-solid fa-paper-plane"></i> Outgoing</a></li>
        <li><a href="./terminal-docs"><i class="fa-solid fa-archive"></i> Terminal Docs</a></li>
        <li><a href="./maintenance"><i class="fa-solid fa-cogs"></i> Maintenance</a></li>
        <li><a href="./user-management"><i class="fa-solid fa-users"></i> User Management</a></li>
    </ul>
</nav>