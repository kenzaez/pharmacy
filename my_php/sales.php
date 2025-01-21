<?php

    require_once '../php/connect.php';
    session_start();
    if (isset($_COOKIE['sales'])) {
        $visitorCount = $_COOKIE['sales'] + 1;
    } else {
        $visitorCount = 1;
    }
    setcookie("sales", $visitorCount, time() + 365 * 24 * 60 * 60, "/");

?>

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
    <link href="../assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/master.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
         <?php include('nav-bar.php'); ?>
        <!-- end of sidebar component -->
            <div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Sales</h3>
                    </div>

                    <!-- _____ -->
                    <div class="col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">Sales records</div>
                            <div class="card-body">
                                <p class="card-title"></p>
                                <table class="table table-hover" id="dataTables-example" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sales ID</th>
                                            <th>Bill ID</th>
                                            <th>Product ID</th>
                                            <th>Quantity</th>
                                            <th>Sale Date</th>
                                            <th>Total Price</th>
                                            <th>See Details</th><!-- Contains a button -->
                                            <th>Invoice</th><!-- also a button -->

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        try{
                                            $conn = mysqli_connect("localhost", "root", "", "pharmacy");
                                        }
                                        catch(mysqli_sql_exception) {
                                            echo "COULDN'T CONNECT";
                                        }
                                        

                                        $sql = "SELECT * FROM sales";

                                        $result = mysqli_query($conn, $sql);

                                        if ($conn) {
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>
                                                        <td>" . htmlspecialchars($row['saleID']) . "</td>
                                                        <td>" . htmlspecialchars($row['billID']) . "</td>
                                                        <td>" . htmlspecialchars($row['productID']) . "</td>
                                                        <td>" . htmlspecialchars($row['quantity']) . "</td>
                                                        <td>" . htmlspecialchars($row['saleDate']) . "</td>
                                                        <td>" . htmlspecialchars($row['totalPrice']) . "</td>
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


    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/chartsjs/Chart.min.js"></script>
    <script src="../../assets/js/dashboard-charts.js"></script>
    <script src="../../assets/js/script.js"></script>
</body>

</html>