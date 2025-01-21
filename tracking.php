<div class="row">
                       
                        <div class="col-md-6">
    <div class="card">
        <div class="content">
            <div class="container mt-4">
                <?php
                // Step 1: Find the productName with the highest quantity in Transactions 
                $sql_most_sold = "
                    SELECT productName
                    FROM transactions
                    WHERE productQuantity = (SELECT MAX(productQuantity) FROM transactions);
                ";

                $result_most_sold = $conn->query($sql_most_sold);

                if ($result_most_sold->num_rows > 0) {
                    $row_most_sold = $result_most_sold->fetch_assoc();
                    $mostSoldProductID = $row_most_sold['productName'];

                    $sql_product = "
                        SELECT productID, productName, productDetails, productIMG, productIMGType
                        FROM Products
                        WHERE productName = ?
                    ";

                
                    if ($stmt = $conn->prepare($sql_product)) {
                      
                        $stmt->bind_param("s", $mostSoldProductID);
                        $stmt->execute();
                        $stmt->bind_result($productID, $productName, $productDetails, $productIMG, $productIMGType);

                     
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

                        
                        $stmt->close();
                    } else {
                        echo "Error preparing the product query.";
                    }
                } else {
                    $productData = null;
                }

             
                $conn->close();
                ?>
                <div class="row">
                   
                        <h2 class="sold">Most Sold Product</h2>
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
    </div>
</div>

                                
                        <div class="col-md-6">
                            <div class="card">
                                <div class="content">
                                    <div class="head">
                                        <h5 class="mb-0">Most Visited Pages</h5>
                                        <p class="text-muted">Current year website visitor data</p>
                                    </div>
                                    <div class="canvas-wrapper">
                                        <table class="table table-striped">
                                            <thead class="success">
                                                <tr>
                                                    <th>Page Name</th>
                                                    <th class="text-end">Visitors</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>/medicine.php <a href="php/medicine/medicine.php"><i class="fas fa-link blue"></i></a>
                                                    </td>
                                                    <td class="text-end"><?php echo $_COOKIE['medicine']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>/staff.php <a href="php/staff/staff.php"><i
                                                                class="fas fa-link blue"></i></a></td>
                                                    <td class="text-end"><?php echo $_COOKIE['staff']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>/sales.php <a href="my_php/sales.php"><i class="fas fa-link blue"></i></a>
                                                    </td>
                                                    <td class="text-end"><?php echo $_COOKIE['staff']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>/orders.php <a href="my_php/orders.php"><i
                                                                class="fas fa-link blue"></i></a></td>
                                                    <td class="text-end"><?php echo $_COOKIE['staff']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>/dashboard.php <a href="#"><i
                                                                class="fas fa-link blue"></i></a></td>
                                                    <td class="text-end"><?php echo $_COOKIE['staff']; ?></td>
                                                </tr>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>