<?php
include '../connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT productName, productDetails, quantity, Price, productIMG, productIMGType FROM Products WHERE productID = ?";
    $stmt1 = $conn->prepare($sql);

    if ($stmt1) {
        $stmt1->bind_param('i', $id);
        $stmt1->execute();
        // Bind results to variables
        $stmt1->bind_result($name, $details, $quantity, $Price, $img, $imgtype);

        // Fetch the result
        if ($stmt1->fetch()) {
            // Variables are now set: $name, $details, $quantity, $Price, $img, $imgtype
        } else {
            $name = $details = "Unknown";
            $quantity = $Price = 0;
            $img = $imgtype = null;
        }

        $stmt1->close();
    }
}
$conn->close();
?>
