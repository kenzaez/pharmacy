<?php
session_start();
require_once '../../php/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $total = 0;
    $quantity = 0;

    $saleID = (int)$_POST['saleID'];
    $saleDate = $_POST['saleDate'];
    $transaction = $_POST['addToTransaction'];

    $sql1 = "INSERT INTO transactions (saleID, productName, productPrice, productQuantity, totalAmount, saleDate) VALUES (?, ?, ?, ?, ?, ?)";

    $sql2 = "INSERT INTO sales (saleID, quantity, saleDate, totalAmount) VALUES (?, ?, ?, ?)";

    
        // Insert into cart
        foreach ($transaction as $item) {
            $item = explode(',', $item);
            $productName = $item[0];
            $productPrice = $item[1];
            $productQuantity = $item[2];
            $totalAmount = $item[3];
            $total += $totalAmount;
            $quantity += $productQuantity;

            $stmt = $conn->prepare($sql1);
            $stmt->bind_param("isdids", $saleID, $productName, $productPrice, $productQuantity, $totalAmount, $saleDate);

            if (!$stmt->execute()) {
                echo "Error: " . $stmt->error;
                exit;
            }
            $stmt->close();
        }

        // Insert into sales

        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("iisd", $saleID, $quantity, $saleDate, $total);
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit;
        }
    $stmt->close();
}

$conn->close();
header("Location: sales.php");
exit();
