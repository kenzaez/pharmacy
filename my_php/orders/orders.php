<?php

require_once '../../php/connect.php';
session_start();
$orderDetails = '';

// Handle the form submission for viewing details
if (isset($_POST['viewDetails'])) {

    $orderId = (int)$_POST['orderId']; // Get the order ID from the form submission

    $sqlOrderDetails = "SELECT * FROM orders WHERE orderID = ?";
    $stmt1 = $conn->prepare($sqlOrderDetails);

    if ($stmt1) {
        $stmt1->bind_param("i", $orderId);
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        // Check if the order exists
        if ($result1->num_rows > 0) {
            $order = $result1->fetch_assoc(); // Fetch order data

            // Safely fetch the order details
            $orderID = isset($order['orderID']) ? $order['orderID'] : 'N/A';
            $orderDate = isset($order['orderDate']) ? $order['orderDate'] : 'N/A';
            $deliveryDate = isset($order['deliveryDate']) ? $order['deliveryDate'] : 'N/A';
            $totalAmount = isset($order['totalAmount']) ? $order['totalAmount'] : 'N/A';
            $currentStatus = isset($order['currentStatus']) ? $order['currentStatus'] : 'N/A';

            // Fetch supplier details
            $stmt2 = $conn->prepare("SELECT name FROM suppliers WHERE supplierID = ?");
            $stmt2->bind_param("i", $order['supplierID']);
            $stmt2->execute();
            $supplierResult = $stmt2->get_result();
            $supplier = $supplierResult->num_rows > 0 ? $order['supplierID'] . '-' . $supplierResult->fetch_assoc()['name'] : 'N/A';

            // Fetch cart details
            $cartDetails = '';
            $cartStmt = $conn->prepare("SELECT * FROM cart WHERE orderID = ?");
            $cartStmt->bind_param("i", $orderId);
            $cartStmt->execute();
            $cartResult = $cartStmt->get_result();

            if ($cartResult->num_rows > 0) {
                while ($cart = $cartResult->fetch_assoc()) {
                    $cartDetails .= "
                <tr>
                    <td>" . htmlspecialchars($cart['productName']) . "</td>
                    <td>" . htmlspecialchars($cart['productPrice']) . "</td>
                    <td>" . htmlspecialchars($cart['productQuantity']) . "</td>
                    <td>" . htmlspecialchars($cart['totalAmount']) . "</td>
                </tr>";
                }
            } else {
                $cartDetails = "<tr><td colspan='4'>No products found in the cart.</td></tr>";
            }

            // Close statements
            $stmt1->close();
            $stmt2->close();
            $cartStmt->close();

            // Prepare order details and cart table
            $orderDetails = "
        <p><strong>Order ID:</strong> " . htmlspecialchars($orderID) . "</p>
        <p><strong>Supplier:</strong> " . htmlspecialchars($supplier) . "</p>
        <p><strong>Order Date:</strong> " . htmlspecialchars($orderDate) . "</p>
        <p><strong>Delivery Date:</strong> " . htmlspecialchars($deliveryDate) . "</p>
        <p><strong>Total Amount:</strong> MAD " . htmlspecialchars($totalAmount) . "</p>
        <p><strong>Status:</strong> " . htmlspecialchars($currentStatus) . "</p>

        <table border='1' style='margin-top: 20px;'>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            $cartDetails
        </table>
    ";
        } else {
            $orderDetails = "<p>No order found with the ID: $orderId</p>";
        }
    } else {
        echo "Failed to prepare order query.";
    }
}



//COOLIES
if (isset($_COOKIE['orders'])) {
    $visitorCount = $_COOKIE['orders'] + 1;
} else {
    $visitorCount = 1;
}
setcookie("orders", $visitorCount, time() + 365 * 24 * 60 * 60, "/");



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Orders</title>
    <link href="../../assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="../../assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/datatables/datatables.min.css" rel="stylesheet">
    <link href="../../assets/css/master.css" rel="stylesheet">
    <!--  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/orders.css">

</head>

<body>

    <!-- Including the navigation bar -->
    <?php include '../nav-bar.php'; ?>
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
                        <!-- START : POPUP FORM ADD BUTTON -->
                        <div id="Buttons">
                            <button type="button" id="addOrderBtn" class="allButtons">+ Add a new Order</button>
                            <script>
                                document.getElementById('addOrderBtn').addEventListener('click', function() {
                                    const popup = document.getElementById('popup');
                                    if (popup) {
                                        popup.style.display = 'block';
                                    }
                                });
                            </script>
                        </div>
                        <div class="popup" id="popup">
                            <!-- FORM TO ADD A NEW ORDER -->
                            <form action="add_order.php" method="post" id="orderForm">
                                <h2 id="popupTitle">Add a new order</h2>
                                <div class="other">
                                    <!-- ADDING THE ID -->
                                    <label for="orderID">Order ID :
                                        <input type="text" name="orderID" id="orderID" value="<?php echo date('ymdHms'); ?>" readonly>
                                    </label>
                                    <!-- ADDING A THE SUPPLIER -->
                                    <label for="supplier">Supplier :
                                        <select name="supplier" id="supplier" required>
                                            <?php
                                            $query = "SELECT supplierID, name FROM suppliers";
                                            $stmt1 = $conn->prepare($query);
                                            if ($stmt1) {
                                                $stmt1->execute();
                                                $res1 = $stmt1->get_result();

                                                if ($res1->num_rows > 0) {
                                                    while ($row = $res1->fetch_assoc()) {
                                                        echo "<option value='" . $row['supplierID'] . '-' . $row['name'] . "'>" . $row['supplierID'] . '-' . $row['name'] . "</option>";
                                                    }
                                                }
                                                $stmt1->close();
                                            } else {
                                                echo "Failed to prepare the statement.";
                                            }

                                            ?>
                                        </select>
                                    </label>
                                </div>

                                <!-- add the medicine order : medecine + quantity -->
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
                                            <?php
                                            $query = "SELECT productName, price FROM products";
                                            $stmt1 = $conn->prepare($query);
                                            if ($stmt1) {
                                                $stmt1->execute();
                                                $res1 = $stmt1->get_result();
                                                if ($res1->num_rows > 0) {
                                                    while ($row = $res1->fetch_assoc()) {
                                                        echo "<tr>
                                                                <td><input type='checkbox' name='addToCart[]' class='addBox'></td>
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
                                <button class="allButtons close-btn" data-close type="submit" name="submit" id="addOrder">Save</button>
                            </form>
                            <button type="button" class="allButtons" id="closeAddOrderBtn" >Close</button>
                            <script>
                                document.getElementById('closeAddOrderBtn').addEventListener('click', function() {
                                    const popup = document.getElementById('popup');
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
                                <th>Order ID</th>
                                <th>Supplier ID</th>
                                <th>Order Date</th>
                                <th>Delivery Date</th>
                                <th>Status</th>
                                <th>Total Amount</th>
                                <th>See Details</th>
                                <th>Delete</th>
                                <th>Deliver</th>
                                <th>Cancel</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // SQL query to fetch all orders
                            $sql = "SELECT * FROM orders";

                            // Execute the query directly as there are no placeholders
                            $result = $conn->query($sql);

                            if ($result) {
                                // Check if there are rows in the result set
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['orderID']); ?></td>
                                            <td><?php echo htmlspecialchars($row['supplierID']); ?></td>
                                            <td><?php echo htmlspecialchars($row['orderDate']); ?></td>
                                            <td><?php echo htmlspecialchars($row['deliveryDate']); ?></td>
                                            <td><?php echo htmlspecialchars($row['currentStatus']); ?></td>
                                            <td><?php echo htmlspecialchars($row['totalAmount']); ?></td>
                                            <td>
                                                <form method='POST' action='orders.php'>
                                                    <input type='hidden' name='orderId' value="<?php echo htmlspecialchars($row['orderID']); ?>">
                                                    <button type='submit' name='viewDetails' class='btn btn-outline-primary'>
                                                        View Details
                                                    </button>
                                                </form>

                                            </td>
                                            <td>
                                                <form action="delete_order.php" method="GET" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['orderID']); ?>">
                                                    <button class="btn btn-outline-primary" name="submit">
                                                        <i class="bx bx-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="modify_order.php" method="GET" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['orderID']); ?>">
                                                    <button class="btn-view btn btn-outline-primary openEditFormBtn" id="openEditFormBtn" name="submitUpdateDate">
                                                        <i class='bx bx-check'></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="modify_order.php" method="GET" style="display:inline;">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['orderID']); ?>">
                                                    <button class="btn-view btn btn-outline-primary openEditFormBtn" id="openEditFormBtn" name="submitCancel">
                                                        <i class='bx bx-x'></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                            <?php endwhile;
                                } else {
                                    echo "<tr><td colspan='10'>No orders found.</td></tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>Error executing query: " . htmlspecialchars($conn->error) . "</td></tr>";
                            }

                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Popup for order details -->
        <?php if (isset($orderDetails) && isset($_POST['viewDetails']) && !empty($_POST['orderId'])) : ?>
            <div id="detailsPopup" class="popup" style="display: block;">
                <h4>Order Details</h4>
                <?php echo $orderDetails; ?>
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
    <script src="../js/orders.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded');

            document.getElementById('detailsPopup').forEach((popup) => {
                popup.addEventListener('click', (e) => {
                    if (e.target.classList.contains('popup')) {
                        popup.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>