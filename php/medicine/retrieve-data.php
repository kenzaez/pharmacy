<?php
// Include database connection
include('../connect.php');

// Get the productID from the URL
$productID = $_GET['id'];

// Retrieve product data from the database
$sql = "SELECT * FROM products WHERE productID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $productID);
$stmt->execute();
$result = $stmt->get_result();

// Check if the product exists
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc(); // Fetch product data
} else {
    echo "Product not found.";
    exit;
}

?>
