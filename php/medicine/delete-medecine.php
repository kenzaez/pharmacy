<?php
session_start();
include '../connect.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Prepare and execute delete query
    $sql = "DELETE FROM Products WHERE productID = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $_SESSION['deleteMessage'] = "Erreur de préparation de la requête : " . $conn->error;
        
    } else {
        $stmt->bind_param("i", $productId);
        
        if ($stmt->execute()) {
            $_SESSION['deleteMessage'] = "Produit supprimé avec succès!";
           
        } else {
            $_SESSION['deleteMessage'] = "Erreur lors de la suppression : " . $stmt->error;
           
        }
    }

    $stmt->close();
} else {
    $_SESSION['deleteMessage'] = "Aucun produit spécifié.";
  
}

$conn->close();
header("Location: medicine.php");
exit();
?>
