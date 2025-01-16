<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && isset($_POST['productID'])) {
    $productID = intval($_POST['productID']);
    
    // Check if file is uploaded and there are no errors
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Get the MIME type of the uploaded file
        $imageType = mime_content_type($_FILES['image']['tmp_name']);
        
        // If mime type is not determined, set a default
        if (!$imageType) {
            $imageType = 'application/octet-stream'; // Default MIME type
        }
        
        // Read the file as binary data
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        
        // Prepare the SQL query to update the image and its MIME type
        $sql = "UPDATE products SET productIMG = ?, productIMGType = ? WHERE productID = ?";
        $stmt = $conn->prepare($sql);
        
        // Bind the parameters (b for binary, s for string, i for integer)
        $null = NULL; // Set $null as a separate variable for reference
        $stmt->bind_param("bsi", $null, $imageType, $productID);
        
        // Send the binary data to the prepared statement
        $stmt->send_long_data(0, $imageData); // 0 corresponds to the first parameter (productIMG)
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "✅ Image updated for Product ID: $productID";
        } else {
            echo "❌ Error updating Product ID: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "❌ File upload error: " . $_FILES['image']['error'];
    }
}
?>

<!-- Form to Upload Image and Ask for Product ID -->
<form action="" method="post" enctype="multipart/form-data">
    <label>Product ID: </label>
    <input type="number" name="productID" required><br>
    <label>Upload Image: </label>
    <input type="file" name="image" required><br>
    <button type="submit">Upload</button>
</form>

