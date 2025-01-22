<?php
require_once '../../php/connect.php';
session_start();

if(isset($_GET['submit'])) {
    $saleId = (int)$_GET['id'];

    //delete from transactions
    $sql = "DELETE FROM transactions WHERE saleID = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $saleId);
        
        if (!$stmt->execute()) {
            echo "Erreur lors de la suppression : " . $stmt->error;
        }
    }
    $stmt->close();
    
    //delete from sales
    $sql = "DELETE FROM sales WHERE saleID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $saleId);
        
        if (!$stmt->execute()) {
            echo "Erreur lors de la suppression : " . $stmt->error;
        }
    }

    $stmt->close();
} else {
    echo "Aucune commande spécifiée.";
}

$conn->close();
header("Location: sales.php");
exit();

?>