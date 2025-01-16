<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Sécurisation des entrées utilisateur
    $name = trim(htmlspecialchars($_POST['name']));
    $manufacturer = trim(htmlspecialchars($_POST['manufacturer']));
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $productID = intval($_POST['id']);  // Assuming you have the product ID to update

    // Préparation de la requête SQL pour la mise à jour
    $sql = "UPDATE Products SET productName = ?, productDetails = ?, quantity = ?, Price = ? WHERE productID = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Associer les valeurs aux paramètres
        $stmt->bind_param("ssiii", $name, $manufacturer, $stock, $price, $id);

        // Exécuter la requête
        if ($stmt->execute()) {
            $_SESSION['messageEdit'] = "Produit mis à jour avec succès !";
        } else {
            $_SESSION['messageEdit'] = "Erreur lors de la mise à jour : " . $stmt->error;
            error_log("SQL Error: " . $stmt->error);  // Log the error if the query fails
        }

        $stmt->close();
    } else {
        $_SESSION['messageEdit'] = "Erreur lors de la préparation de la requête.";
        error_log("SQL Error: " . $conn->error);  // Log the error if the prepare fails
    }
}

// Close connection and redirect (outside the if block)
$conn->close();
header("Location: medicine.php");
exit();
?>
