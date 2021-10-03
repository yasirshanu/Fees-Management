<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="../dashboard" class="nav-link <?php if($page == "Dashboard")echo "active"; ?>">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="../profile" class="nav-link <?php if($page == "Profile")echo "active"; ?>">Profile</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="../logout" class="btn btn-danger">Logout <i class="fas fa-sign-out-alt"></i></a>
        </li>
    </ul>
</nav>