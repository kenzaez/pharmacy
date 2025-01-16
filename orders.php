<!doctype html>
<!-- 
* Bootstrap Simple Admin Template
* Version: 2.1
* Author: Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tables | Bootstrap Simple Admin Template</title>
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="assets/css/master.css" rel="stylesheet">
    <style>
        .popup {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background: white;
            border: 1px solid black;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        /* Overlay to dim background */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 500;
        }

        #buttons {
            display: flex;
            justify-content: left;
            gap: 15px;
            padding: 10px;


        }

        .allButtons {
            border: none;
            color: #eee;
            background: #666;
            padding: 5px 7px;
            margin: 5px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- sidebar navigation component -->
        <nav id="sidebar" class="active">
            <div class="sidebar-header">
                <img src="assets/img/bootstraper-logo.png" alt="bootraper logo" class="app-logo">
            </div>
            <ul class="list-unstyled components text-secondary">
                <li>
                    <a href="dashboard.html"><i class="fas fa-home"></i>Dashboard</a>
                </li>
                <li>
                    <a href="forms.html"><i class="fas fa-file-alt"></i>Forms</a>
                </li>
                <li>
                    <a href="tables.html"><i class="fas fa-table"></i>Tables</a>
                </li>
                <li>
                    <a href="charts.html"><i class="fas fa-chart-bar"></i>Charts</a>
                </li>
                <li>
                    <a href="icons.html"><i class="fas fa-icons"></i>Icons</a>
                </li>
                <li>
                    <a href="#uielementsmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-layer-group"></i>UI Elements</a>
                    <ul class="collapse list-unstyled" id="uielementsmenu">
                        <li>
                            <a href="ui-buttons.html"><i class="fas fa-angle-right"></i>Buttons</a>
                        </li>
                        <li>
                            <a href="ui-badges.html"><i class="fas fa-angle-right"></i>Badges</a>
                        </li>
                        <li>
                            <a href="ui-cards.html"><i class="fas fa-angle-right"></i>Cards</a>
                        </li>
                        <li>
                            <a href="ui-alerts.html"><i class="fas fa-angle-right"></i>Alerts</a>
                        </li>
                        <li>
                            <a href="ui-tabs.html"><i class="fas fa-angle-right"></i>Tabs</a>
                        </li>
                        <li>
                            <a href="ui-date-time-picker.html"><i class="fas fa-angle-right"></i>Date & Time Picker</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#authmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-user-shield"></i>Authentication</a>
                    <ul class="collapse list-unstyled" id="authmenu">
                        <li>
                            <a href="login.html"><i class="fas fa-lock"></i>Login</a>
                        </li>
                        <li>
                            <a href="signup.html"><i class="fas fa-user-plus"></i>Signup</a>
                        </li>
                        <li>
                            <a href="forgot-password.html"><i class="fas fa-user-lock"></i>Forgot password</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#pagesmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-copy"></i>Pages</a>
                    <ul class="collapse list-unstyled" id="pagesmenu">
                        <li>
                            <a href="blank.html"><i class="fas fa-file"></i>Blank page</a>
                        </li>
                        <li>
                            <a href="404.html"><i class="fas fa-info-circle"></i>404 Error page</a>
                        </li>
                        <li>
                            <a href="500.html"><i class="fas fa-info-circle"></i>500 Error page</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="users.html"><i class="fas fa-user-friends"></i>Users</a>
                </li>
                <li>
                    <a href="settings.html"><i class="fas fa-cog"></i>Settings</a>
                </li>
            </ul>
        </nav>
        <!-- end of sidebar component -->
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
                                <a href="#" id="nav1" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-link"></i> <span>Quick Links</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu" aria-labelledby="nav1">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-list"></i> Access Logs</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-database"></i> Back ups</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cloud-download-alt"></i> Updates</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-user-shield"></i> Roles</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <div class="nav-dropdown">
                                <a href="#" id="nav2" class="nav-item nav-link dropdown-toggle text-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> <span>John Doe</span> <i style="font-size: .8em;" class="fas fa-caret-down"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end nav-link-menu">
                                    <ul class="nav-list">
                                        <li><a href="" class="dropdown-item"><i class="fas fa-address-card"></i> Profile</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-envelope"></i> Messages</a></li>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a></li>
                                        <div class="dropdown-divider"></div>
                                        <li><a href="" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end of navbar navigation -->
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Orders</h3>
                    </div>

                    <!-- _____ -->
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">Orders records</div>

                            <div class="card-body">
                                <!-- START : POPUP FORM  -->
                                
                                <div id="Buttons">
                                    <!-- START ADD BUTTON -->
                                    <button id="addOrder" class="allButtons" onclick="openPopup()">+ Add a new Order</button>
                                    <div class="popup" id="popup">
                                        <h2>Popup Window</h2>
                                        <p>This is a simple popup!</p>
                                        <button class="allButtons" onclick="closePopup()">Close</button>
                                    </div>
                                    <!-- END ADD BUTTON -->
                                     <!-- START MODIFY BUTTON -->
                                    <button id="modifyOrder" class="allButtons" onclick="openPopup()">~ Modify an Order</button>
                                    <div class="popup" id="popup">
                                        <h2>Popup Window</h2>
                                        <p>This is a simple popup!</p>
                                        <button class="allButtons" onclick="closePopup()">Close</button>
                                    </div>
                                    <!-- END MODIFY BUTTON -->
                                    <!-- START DELETE BUTTON -->
                                    <button id="deleteOrder" class="allButtons" onclick="openPopup()">- Delete an Order</button>
                                    <div class="popup" id="popup">
                                        <h2>Popup Window</h2>
                                        <p>This is a simple popup!</p>
                                        <button class="allButtons" onclick="closePopup()">Close</button>
                                    </div>
                                    <!-- END DELETE BUTTON -->
                                    <!-- START SEE DETAILS BUTTON -->
                                    <button id="seeDetails" class="allButtons" onclick="openPopup()">See Details</button>
                                    <div class="popup" id="popup">
                                        <h2>Popup Window</h2>
                                        <p>This is a simple popup!</p>
                                        <button class="allButtons" onclick="closePopup()">Close</button>
                                    </div>
                                    <!-- END SEE DETAILS BUTTON -->
                                    <!-- START PRINT AS PDF BUTTON -->
                                    <button id="printPDF" class="allButtons" onclick="openPopup()">Print Order(s)</button>
                                    <div class="popup" id="popup">
                                        <h2>Popup Window</h2>
                                        <p>This is a simple popup!</p>
                                        <button class="allButtons" onclick="closePopup()">Close</button>
                                    </div>
                                </div>
                                <!-- END PRINT AS PDF BUTTON -->
                                <!-- END : POPUP FORM -->
                                <p class="card-title"></p>
                                <table class="table table-hover" id="dataTables-example" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Supplier ID</th>
                                            <th>Order Date</th>
                                            <th>Delivery Date</th>
                                            <th>Status</th>
                                            <th>Total Amount</th>
                                            <th>See Details</th><!-- Contains a button -->
                                            <th>Invoice</th><!-- also a button -->

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        try {
                                            $conn = mysqli_connect("localhost", "root", "", "pharmacy");
                                        } catch (mysqli_sql_exception) {
                                            echo "COULDN'T CONNECT";
                                        }


                                        $sql = "SELECT * FROM orders";

                                        $result = mysqli_query($conn, $sql);

                                        if ($conn) {
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>
                                                        <td>" . htmlspecialchars($row['orderID']) . "</td>
                                                        <td>" . htmlspecialchars($row['supplierID']) . "</td>
                                                        <td>" . htmlspecialchars($row['orderDate']) . "</td>
                                                        <td>" . htmlspecialchars($row['deliveryDate']) . "</td>
                                                        <td>" . htmlspecialchars($row['status']) . "</td>
                                                        <td>" . htmlspecialchars($row['totalAmount']) . "</td>
                                                    </tr>";
                                                }
                                            }
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- __ -->

                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        // JavaScript for controlling the popup
        function openPopup() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</body>

</html>