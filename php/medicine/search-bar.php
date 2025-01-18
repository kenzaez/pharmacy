<?php
include '../connect.php';


// Get search term from GET request
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Construct SQL query
$sql = "SELECT productID, productName, productDetails, quantity, Price, productIMG, productIMGType FROM Products";

// If search term exists, modify query
if (!empty($searchTerm)) {
    $sql .= " WHERE 
              productID LIKE ? 
              OR productName LIKE ? 
              OR productDetails LIKE ? 
              OR Price LIKE ? 
              OR quantity LIKE ?";
}

// Prepare the SQL statement
$stmt = $conn->stmt_init();

if ($stmt->prepare($sql)) {
    if (!empty($searchTerm)) {
        $searchPattern = "{$searchTerm}%"; // Use '%' for partial matching
        $stmt->bind_param("sssss", $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern);
    }
    $stmt->execute();
    $stmt->bind_result($productID, $productName, $productDetails, $quantity, $Price, $productIMG, $productIMGType);
    $stmt->store_result();
} else {
    die("SQL Error: " . $conn->error);
}
?>