<header class="top-header">
    <div class="hamburger-menu">
        <div class="toggle" onclick="toggleNav()">
            <i class="fa-solid"></i>
        </div>
        <span><img src="media/DepED.png" class="header_logo"></span>
    </div>
    <div class="user-settings" id="user-settings">
        <!-- Notification, UserName(icon) and dropdown icon -->
        <i class="fa-solid fa-bell"></i>
        <div class="tumbnail-display">
            <p id="dropdown"></p>
        </div>
    </div>
</header>
<!-- Side Navigation -->
<nav class="side-nav" id="sideNav">
    <ul>
        <!-- dashboard -->
        <li class="active"><a href="./dashboard"><i class="fa-solid fa-home"></i> Dashboard</a></li>
        <!-- create, track, incoming, outgoing, terminal docs, maintenance and user management -->
        <li><a href="./create"><i class="fa-solid fa-plus"></i> Create</a></li>
        <li><a href="./track"><i class="fa-solid fa-search"></i> Track</a></li>
        <li><a href="./incoming"><i class="fa-solid fa-inbox"></i> Incoming</a></li>
        <li><a href="./outgoing"><i class="fa-solid fa-paper-plane"></i> Outgoing</a></li>
        <li><a href="./terminal-docs"><i class="fa-solid fa-archive"></i> Terminal Docs</a></li>
        <!-- <li><a href="./maintenance"><i class="fa-solid fa-cogs"></i> Maintenance</a></li> -->
        <li><a href="./user-management"><i class="fa-solid fa-users"></i> User Management</a></li>
    </ul>
</nav>

<!-- Popup container -->
<div id="popup" class="popup">
    <div class="popup-content">
        <p></p>
    </div>
</div>