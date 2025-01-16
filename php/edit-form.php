<?php
require_once 'connect.php';
$sql = 'SELECT productID, productName, productDetails, quantity, Price FROM Products WHERE productID = ?';

$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('i',$_GET['id']);
$stmt->bind_result($productID, $productName, $productDetails, $quantity, $Price);
$stmt->execute();
	$stmt->store_result();//use this so that you can access "num_rows"
	$stmt->fetch();

if ($stmt->error) {
    echo "Statement error: " . $stmt->errno . ": " . $stmt->error;
    exit();
}

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
      <!-- Add the popup form for editing -->
<div id="editPopupForm" class="popup-form" style="display: <?= isset($_SESSION['popupform']) && $_SESSION['popupform'] ? 'flex' : 'none' ?>;">


<div class="form-container">
    <span id="closeEditFormBtn" class="close-btn">&times;</span>
    <?php if (isset($_SESSION['messageEdit'])): ?>
<div class="alert alert-info">
    <?= htmlspecialchars($_SESSION['messageEdit']) ?>
</div>
<?php 
unset($_SESSION['messageEdit']); // Clear message after displaying 
if (isset($_SESSION['popupform'])) {
    unset($_SESSION['popupform']); // Reset popup state
}
?>

<?php endif; ?>

    <form method="POST" action="edit-medecine.php">
        <input type="hidden" id="editProductID" name="id">
        <div class="form-group">
            <input type="text" id="editName" name="name" class="form-control" placeholder="Medicine Name" value="" required>
        </div>
        <div class="form-group">
            <input type="text" id="editManufacturer" name="manufacturer" class="form-control" placeholder="Manufacturer" required>
        </div>
        <div class="form-group">
            <input type="number" id="editPrice" name="price" class="form-control" placeholder="Price" step="0.01" required>
        </div>
        <div class="form-group">
            <input type="number" id="editStock" name="stock" class="form-control" placeholder="Stock" required>
        </div>

        <button type="submit" class="btn btn-outline-primary mb-2">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </form>
</div>
</div>


        </div>
    </div>
</div>

</body>
</html>