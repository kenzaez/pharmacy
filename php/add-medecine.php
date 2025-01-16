<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $productName = $_POST['name'];
    $productDetails = $_POST['manufacturer'];
    $price = $_POST['price'];
    $quantity = $_POST['stock'];
    
    // Check for image upload errors
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
      
        $imageType = mime_content_type($_FILES['image']['tmp_name']);
        
        if (!$imageType) {
            $imageType = 'application/octet-stream';
        }
        
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        
        $sql = "INSERT INTO Products (productName, productDetails, quantity, Price, productIMG, productIMGType) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiibs", $productName, $productDetails, $quantity, $price, $imageData, $imageType);
       
        // Send the image data
        $stmt->send_long_data(4, $imageData); 
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Produit ajouté avec succès !";
            $_SESSION['popup'] = true;
        } else {
            $_SESSION['message'] = "Erreur lors de l'ajout : " . $stmt->error;
            $_SESSION['popup'] = true;
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Aucune image téléchargée.";
        $_SESSION['popup'] = true;
    }
}

$conn->close();
header("Location: medicine.php");
exit();
?>
