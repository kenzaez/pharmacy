<?php
require_once 'connect.php'; 

// Step 1: Find the productID with the highest quantity in Sales
$sql_most_sold = "
    SELECT productID
    FROM Sales
    WHERE quantity = (SELECT MAX(quantity) FROM Sales);
";

$result_most_sold = $conn->query($sql_most_sold);

// Check if a productID is found
if ($result_most_sold->num_rows > 0) {
    $row_most_sold = $result_most_sold->fetch_assoc();
    $mostSoldProductID = $row_most_sold['productID'];

    // Step 2: Fetch the product details from Products table
    $sql_product = "
        SELECT productID, productName, productDetails, productIMG, productIMGType
        FROM Products
        WHERE productID = ?
    ";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql_product)) {
        // Bind the productID to the query
        $stmt->bind_param("i", $mostSoldProductID);
        $stmt->execute();
        $stmt->bind_result($productID, $productName, $productDetails, $productIMG, $productIMGType);

        // Fetch the product details
        if ($stmt->fetch()) {
            $productData = [
                'productID' => $productID,
                'productName' => $productName,
                'productDetails' => $productDetails,
                'productIMG' => base64_encode($productIMG),
                'productIMGType' => $productIMGType,
            ];
        } else {
            $productData = null;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the product query.";
    }
} else {
    $productData = null;
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Sold Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <h2>Most Sold Product</h2>
                <?php if ($productData): ?>
                    <div class="card" style="width: 18rem;">
                        <img src="data:<?= $productData['productIMGType'] ?>;base64,<?= $productData['productIMG'] ?>" class="card-img-top" alt="Product Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($productData['productName']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($productData['productDetails']) ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No products found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
