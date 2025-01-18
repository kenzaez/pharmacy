<?php
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['productID'];
    $productName = $_POST['name'];
    $manufacturer = $_POST['manufacturer'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    
   
    $sql = 'UPDATE Products SET productName = ?, productDetails = ?, Price = ?, quantity = ? WHERE productID = ?';
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ssdii', $productName, $manufacturer, $price, $stock, $productID);
        
        if ($stmt->execute()) {
            $_SESSION['messageEdit'] = 'Product updated successfully!';
            $_SESSION['popupEdit'] = true;
        } else {
            $_SESSION['messageEdit'] = 'Failed to update product.';
            $_SESSION['popupEdit'] = true;
        }
        
        $stmt->close();
    }
    
    
    header('Location: medicine.php');
    exit();
}
?>
