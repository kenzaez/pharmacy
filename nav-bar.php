<div class="wrapper">
        <nav id="sidebar" class="active">
        <img src="grandmedicine.png" class="app-logo" witdth="150px" height="150px" style="margin-left: 30px;">
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="dashboard.html"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li>
                    <!-- change -->
                    <a href="php/medicine/medicine.php"><i class="fas fa-tablets"></i>Medicine</a>
                </li>
                <li>
                    <a href="my_php/sales.php"><i class="fas fa-money-check-dollar"></i> Sales </a>
                </li>
                <li>
                    <a href="my_php/orders.php"><i class="fas fa-truck"></i>Orders </a>
                </li>
                <li>
                    <a href="php/staff/staff.php"><i class="fas fa-user-tie"></i> Staff </a>
                </li>
                <li><a href="logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
        <div id="body" class="active">
            <!-- navbar navigation component -->
            <nav class="navbar navbar-expand-lg navbar-white bg-white">
                <button type="button" id="sidebarCollapse" class="btn btn-light">
                    <i class="fas fa-bars"></i><span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav1" class="nav-item nav-link dropdown-toggle text-secondary"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-link"></i> <span>Quick Links</span> <i style="font-size: .8em;"
                                        class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu" aria-labelledby="nav1">
                                    <ul class="nav-list">
                                        <li><a href="php/staff/staff.php" class="dropdown-item"><i class="fas fa-user-tie"></i> staff</a>
                                        </li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="php/medicine/medicine.php" class="dropdown-item"><i class="fas fa-tablets"></i> medicine</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="my_php/orders.php" class="dropdown-item"><i class="fas fa-truck"></i>
                                               orders</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="my_php/sales.php" class="dropdown-item"><i class="fas fa-money-check-dollar"></i>
                                                sales</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span><?php echo $_SESSION['fullname'];?></span> <i
                                        style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="login.php" class="dropdown-item"><i
                                                    class="fas fa-address-card"></i> switch user </a></li>

                                        <li><a href="logout.php" class="dropdown-item"><i
                                                    class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>