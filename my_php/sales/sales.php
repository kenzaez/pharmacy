<?php

require_once '../../php/connect.php';
session_start();
$saleDetails = '';

// Handle the form submission for viewing details
if (isset($_POST['viewDetails'])) {

    $saleId = (int)$_POST['saleId']; // Get the sale ID from the form submission

    $sqlSaleDetails = "SELECT * FROM sales WHERE saleID = ?";
    $stmt1 = $conn->prepare($sqlSaleDetails);

    if ($stmt1) {
        $stmt1->bind_param("i", $saleId);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        // Check if the sale exists
        if ($result1->num_rows > 0) {
            $sale = $result1->fetch_assoc(); // Fetch sale data

            // Safely fetch the sale details
            $saleID = isset($sale['saleID']) ? $sale['saleID'] : 'N/A';
            $saleDate = isset($sale['saleDate']) ? $sale['saleDate'] : 'N/A';
            $quantity = isset($sale['quantity']) ? $sale['quantity'] : 'N/A';
            $totalAmount = isset($sale['totalAmount']) ? $sale['totalAmount'] : 'N/A';

            // Fetch cart details
            $transactionDetails = '';
            $transactionStmt = $conn->prepare("SELECT * FROM transactions WHERE saleID = ?");
            $transactionStmt->bind_param("i", $saleId);
            $transactionStmt->execute();
            $transactionResult = $transactionStmt->get_result();

            if ($transactionResult->num_rows > 0) {
                while ($transaction = $transactionResult->fetch_assoc()) {
                    $transactionDetails .= "
                <tr>
                    <td>" . htmlspecialchars($transaction['productName']) . "</td>
                    <td>" . htmlspecialchars($transaction['productPrice']) . "</td>
                    <td>" . htmlspecialchars($transaction['productQuantity']) . "</td>
                    <td>" . htmlspecialchars($transaction['totalAmount']) . "</td>
                </tr>";
                }
            } else {
                $transactionDetails = "<tr><td colspan='4'>No products found in the transaction.</td></tr>";
            }

            // Close statements
            $stmt1->close();
            $transactionStmt->close();

            // Prepare sale details and cart table
            $saleDetails = "
        <p><strong>sale ID:</strong> " . htmlspecialchars($saleID) . "</p>
        <p><strong>sale Date:</strong> " . htmlspecialchars($saleDate) . "</p>
        <p><strong>Quantity:</strong> " . htmlspecialchars($quantity) . "</p>
        <p><strong>Total Amount:</strong> MAD " . htmlspecialchars($totalAmount) . "</p>

        <table bsale='1' style='margin-top: 20px;'>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            $transactionDetails
        </table>
    ";
        } else {
            $saleDetails = "<p>No sale found with the ID: $saleId</p>";
        }
    } else {
        echo "Failed to prepare sale query.";
    }
}


//COOKIES
if (isset($_COOKIE['sales'])) {
    $visitorCount = $_COOKIE['sales'] + 1;
} else {
    $visitorCount = 1;
}
setcookie("sales", $visitorCount, time() + 365 * 24 * 60 * 60, "/");

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sales</title>
    <link href="../../assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="../../assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="../../assets/css/master.css" rel="stylesheet">
    <!--  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="../css/sales.css" rel="stylesheet">

</head>

<body>
    <!-- Including the navigation bar -->
    <?php include '../../php/nav-bar.php'; ?>
    <!-- end of navbar navigation -->
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
                        <!-- START : POPUP FORM ADD BUTTON -->
                        <div id="Buttons">
                            <button id="addSaleBtn" class="allButtons" id="addSaleBtn">+ Add a new sale</button>
                            <script>
                                document.getElementById('addSaleBtn').addEventListener('click', function() {
                                    const popup = document.getElementById('addSalePopup');
                                    if (popup) {
                                        popup.style.display = 'block';
                                    }
                                });
                                
                            </script>
                        </div>
                        <div class="popup" id="addSalePopup">
                            <!-- FORM TO ADD A NEW sale -->
                            <form action="add_sale.php" method="post" id="salesForm">
                                <h2 id="popupTitle">Add a new sale</h2>
                                <div class="other">
                                    <!-- ADDING THE ID -->
                                    <label for="saleID">sale ID :
                                        <input type="text" name="saleID" id="saleID" value="<?php echo date('ymds') ?>" readonly>
                                    </label>
                                    <label for="transactionID" hidden>transaction ID :
                                        <input type="text" name="transactionID" id="transactionID" value="<?php echo date('ymdHm') ?>" hidden>
                                    </label>

                                    <label for="saleDate">
                                        Sale Date
                                        <input type="date" name="saleDate" id="saleDate" value="<?php echo date('Y-m-d'); ?>" required>
                                    </label>
                                </div>

                                <!-- add the medicine sale : medecine + quantity -->
                                <div class="products">

                                    <label for="product">Select the products :</label>
                                    <div class="addProducts">
                                        <table name="productsList" id="productsList">
                                            <tr>
                                                <th></th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total Amount</th>
                                            </tr>
                                            <?php // Displaying the products in the table
                                            $query = "SELECT productName, price FROM products";
                                            $stmt1 = $conn->prepare($query);
                                            if ($stmt1) {
                                                $stmt1->execute();
                                                $res1 = $stmt1->get_result();
                                                if ($res1->num_rows > 0) {
                                                    while ($row = $res1->fetch_assoc()) {
                                                        echo "<tr>
                                                                <td><input type='checkbox' name='addToTransaction[]' class='addBox'></td>
                                                                <td class='productName'>" . $row['productName'] . "</td>
                                                                <td class='price'>" . $row['price'] . "</td>
                                                                <td><input type='number' name='quantity' id='quantity' class='quantity' placeholder='Quantity' min='0'></td>
                                                                <td class='total'></td>
                                                            </tr>";
                                                    }
                                                }
                                                $stmt1->close();
                                            } else {
                                                echo "Failed to prepare the statement.";
                                            }
                                            ?>
                                        </table>
                                        <script>
                                            // Handle quantity input for products
                                            const quantityInputs = document.querySelectorAll(".quantity");
                                            quantityInputs.forEach((qty) => {
                                                qty.addEventListener("input", (e) => {
                                                    const cartRow = e.target.closest("tr");
                                                    const quant = cartRow.querySelector(".quantity").value;
                                                    const price = cartRow.querySelector(".price").textContent;
                                                    const total = quant * price;

                                                    const productName = cartRow.querySelector(".productName").textContent;
                                                    const checkBox = cartRow.querySelector(".addBox");

                                                    if (quant > 0) {
                                                        checkBox.checked = true;
                                                        checkBox.setAttribute("value", `${productName},${price},${quant},${total}`);
                                                    } else {
                                                        checkBox.checked = false;
                                                    }
                                                    cartRow.querySelector(".total").innerHTML = total;
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                                <button class="allButtons" type="submit" name="submit" id="addsale">Save</button>
                            </form>
                            <button type="button" class="allButtons" id="closeAddSaleBtn" >Close</button>
                            <script>
                                document.getElementById('closeAddSaleBtn').addEventListener('click', function() {
                                    const popup = document.getElementById('addSalePopup');
                                    if (popup) {
                                        popup.style.display = 'none';
                                    }
                                });
                            </script>
                        </div>

                    </div>
                    <!-- END : POPUP FORM -->
                    <p class="card-title"></p>
                    <table class="table table-hover" id="dataTables-example" width="100%">
                        <thead>
                            <tr>
                                <th>Sales ID</th>
                                <th>Quantity</th>
                                <th>Sale Date</th>
                                <th>Total Price</th>
                                <th>See Details</th><!-- Contains a button to see more details -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "SELECT * FROM sales";

                            $result = mysqli_query($conn, $sql);

                            if ($conn) {
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['saleID']) ?></td>
                                            <td><?php echo htmlspecialchars($row['quantity']) ?></td>
                                            <td><?php echo htmlspecialchars($row['saleDate']) ?></td>
                                            <td><?php echo htmlspecialchars($row['totalAmount'])  ?></td>
                                            <td>
                                                <form method='POST' action='sales.php'>
                                                    <input type='hidden' name='saleId' value="<?php echo htmlspecialchars($row['saleID']); ?>">
                                                    <button type='submit' name='viewDetails' class='btn btn-outline-primary'>
                                                        View Details
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                            <?php endwhile;
                                } else {
                                    echo "No sales found.";
                                }
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Popup for sale details -->
        <?php if (isset($saleDetails) && isset($_POST['viewDetails']) && !empty($_POST['saleId'])) : ?>
            <div id="detailsPopup" class="popup" style="display: block;">
                <h4>Sale Details</h4>
                <?php echo $saleDetails; ?>
                <button type="button" class="allButtons" id="closeDetailsBtn">Close</button>
            </div>
            <script>
                document.getElementById('closeDetailsBtn').addEventListener('click', function() {
                    const popup = document.getElementById('detailsPopup');
                    if (popup) {
                        popup.style.display = 'none';
                    }
                });
            </script>
        <?php endif; ?>

        <!-- END SEE DETAILS PART -->
    </div>
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/datatables/datatables.min.js"></script>
    <script src="../../assets/js/initiate-datatables.js"></script>
    <script src="../../assets/js/script.js"></script>
<!--     <script src="../js/sales.js"></script>
 --></body>

</html>