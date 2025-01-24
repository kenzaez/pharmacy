<?php
require_once '../../php/connect.php';
session_start();

if(isset($_GET['submit'])) {
    $orderId = (int)$_GET['id'];

    //delete from cart
    $sql = "DELETE FROM Cart WHERE orderID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $orderId);
        
        if (!$stmt->execute()) {
            echo "Erreur lors de la suppression : " . $stmt->error;
        }
    }
    $stmt->close();
    
    //delete from orders
    $sql = "DELETE FROM Orders WHERE orderID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $orderId);
        
        if (!$stmt->execute()) {
            echo "Erreur lors de la suppression : " . $stmt->error;
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