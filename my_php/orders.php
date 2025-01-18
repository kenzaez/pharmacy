<?php

    require_once '../php/connect.php';

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tables | Bootstrap Simple Admin Template</title>
    <link href="../assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="../assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="../assets/css/master.css" rel="stylesheet">
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
            background: #1F82C7;
            padding: 5px 7px;
            margin: 5px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include('../php/nav-bar.php'); ?>
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