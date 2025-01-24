<?php
require_once '../../php/connect.php';
session_start();

if(isset($_GET['submitUpdateDate'])) {
    $orderId = (int)$_GET['id'];

    //delete from cart
    $sql = "UPDATE ORDERS 
        SET deliveryDate = NOW(), 
            currentStatus = 'Delivered' 
        WHERE orderID = ?
        AND currentStatus = 'Pending'";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $orderId);
        
        if (!$stmt->execute()) {
            echo "Erreur lors de la modification : " . $stmt->error;
        }
    }
    $stmt->close();
    
} else {
    echo "Aucune commande spécifiée.";
}

if(isset($_GET['submitCancel'])) {
    $orderId = (int)$_GET['id'];

    //delete from cart
    $sql = "UPDATE ORDERS 
        SET deliveryDate = NULL, 
            currentStatus = 'Cancelled' 
        WHERE orderID = ?
        AND currentStatus = 'Pending'";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $orderId);
        
        if (!$stmt->execute()) {
            echo "Erreur lors de la modification : " . $stmt->error;
        }
    }
    $stmt->close();
    
} else {
    echo "Aucune commande spécifiée.";
}

$conn->close();
header("Location: orders.php");
exit();

?>