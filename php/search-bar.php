<?php
include 'connect.php';

// Check if the search term has been submitted
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

// SQL query to fetch all products or filtered products based on the search term
$sql = "SELECT * FROM products";

if ($searchTerm) {
    // Add conditions to the query if there is a search term
    $sql .= " WHERE 
              CAST(productID AS CHAR) LIKE ? 
              OR productName LIKE ? 
              OR productDetails LIKE ? 
              OR CAST(Price AS CHAR) LIKE ? 
              OR CAST(quantity AS CHAR) LIKE ?";
}

$stmt = $conn->prepare($sql);

// Create the search pattern
$searchPattern = "{$searchTerm}%";

// Bind parameters if there is a search term
if ($searchTerm) {
    $stmt->bind_param("sssss", $searchPattern, $searchPattern, $searchPattern, $searchPattern, $searchPattern);
}

$stmt->execute();
$result = $stmt->get_result(); // Fetch the results

$stmt->close();

?>