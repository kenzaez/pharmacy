<?php
session_start();
require_once '../../php/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $total = 0;

    $orderID = (int)$_POST['orderID'];
    $supplier = explode('-', $_POST['supplier']);
    $supplierID = $supplier[0];
    $supplierName = $supplier[1];

    $cart = $_POST['addToCart'];

    $sql1 = "INSERT INTO cart (orderID, productName, productPrice, productQuantity, totalAmount, supplierName) VALUES (?, ?, ?, ?, ?, ?)";

    $sql2 = "INSERT INTO orders (orderID, supplierID, orderDate, deliveryDate, currentStatus, totalAmount) VALUES (?, ?, ?, ?, ?, ?)";

    
        // Insert into cart
        foreach ($cart as $item) {
            $item = explode(',', $item);
            $productName = $item[0];
            $productPrice = $item[1];
            $productQuantity = $item[2];
            $totalAmount = $item[3];
            $total += $totalAmount;

            $stmt = $conn->prepare($sql1);
            $stmt->bind_param("isdids", $orderID, $productName, $productPrice, $productQuantity, $totalAmount, $supplierName);

            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
                exit;
            }
            $stmt->close();
        }

        // Insert into orders
        $orderDate = date('Y-m-d');
        $deliveryDate = NULL;
        $currentStatus = 'Pending';

        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("iisssd", $orderID, $supplierID, $orderDate, $deliveryDate, $currentStatus, $total);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit;
        }
    $stmt->close();
}

$conn->close();
header("Location: orders.php");
exit();
