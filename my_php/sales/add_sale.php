<?php
session_start();
require_once '../../php/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $total = 0;
    $quantity = 0;

    $saleID = (int)$_POST['saleID'];
    $saleDate = $_POST['saleDate'];
    $transaction = $_POST['addToTransaction'];

    $sql1 = "INSERT INTO transactions (saleID, productName, productPrice, productQuantity, totalAmount) VALUES (?, ?, ?, ?, ?)";
    $sql2 = "INSERT INTO sales (saleID, quantity, saleDate, totalAmount) VALUES (?, ?, ?, ?)";

    if (isset($transaction) && is_array($transaction)) {
        foreach ($transaction as $item) {
            $item = explode(',', $item);

            // Validate and cast input values
            if (count($item) < 4) {
                echo "Error: Invalid transaction format.";
                exit;
            }

            $productName = $item[0];
            $productPrice = (float)$item[1];
            $productQuantity = (int)$item[2];
            $totalAmount = (float)$item[3];

            $total += $totalAmount;
            $quantity += $productQuantity;

            // Prepare and bind parameters for transactions
            $stmt1 = $conn->prepare($sql1);
            if ($stmt1) {
                $stmt1->bind_param("isddi", $saleID, $productName, $productPrice, $productQuantity, $totalAmount);
                if (!$stmt1->execute()) {
                    echo "Error: " . $stmt1->error;
                    exit;
                }
                $stmt1->close();
            } else {
                echo "Error preparing statement for transactions: " . $conn->error;
                exit;
            }
        }

        // Prepare and bind parameters for sales
        $stmt2 = $conn->prepare($sql2);
        if ($stmt2) {
            $stmt2->bind_param("iisd", $saleID, $quantity, $saleDate, $total);
            if (!$stmt2->execute()) {
                echo "Error: " . $stmt2->error;
                exit;
            }
            $stmt2->close();
        } else {
            echo "Error preparing statement for sales: " . $conn->error;
            exit;
        }
    } else {
        echo "Error: Invalid transaction data.";
        exit;
    }

    $conn->close();
    header("Location: sales.php");
    exit();
}
?>
