<?php
require_once 'connect.php';
require_once 'search-bar.php'; 
session_start();


$sql = 'SELECT productID, productName, productDetails, quantity, Price, productIMG, productIMGType FROM Products';

$stmt = $conn->stmt_init();

if ($stmt->prepare($sql)) {
    $stmt->execute();
    
    // Bind the results
    $stmt->bind_result($productID, $productName, $productDetails, $quantity, $Price, $productIMG, $productIMGType);
    
    // Store result (optional, only needed if you check `num_rows`)
    $stmt->store_result();

    // Check for errors
    if ($stmt->error) {
        echo $stmt->errno . ": " . $stmt->error;
        exit();
    }
    
} else {
    echo "SQL preparation error: " . $conn->error;
}



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pharmacy Dashboard</title>
    <link href="../assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/master.css" rel="stylesheet">

    <style>
      
        .popup-form {
    display: none; /* Initially hidden */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
}

.form-container {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    width: 400px;
    position: relative; /* Ensure the close button is placed properly */
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    cursor: pointer;
}


       
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-icon {
            font-size: 16px;
            padding: 6px 10px;
        }

        #body {
            background-color:rgb(243, 241, 241);
        }

        .table-bordered {
            border: 0.5px solid  #1E84C4;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-bordered tbody tr td {
            background-color: rgb(243, 241, 241);
            border: 0.5px solid rgb(151, 175, 190);
            border-left: 1px solid #1E84C4;  /* Solid left border */
            border-right: 1px solid #1E84C4; /* Solid right border */
        }

        .table-bordered thead tr th {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #1E84C4;
            color: rgb(243, 241, 241);
            border: 0.5px solid #1E84C4;
        }

        .search-container {
            position: relative;
            width: 50px;
            height: 50px;
            margin-top: auto;
            margin-left: auto;
        }

        .search-icon {
            position: absolute;
             top: 50%;
            /* left: 50%; */
            transform: translate(-50%, -50%);
            font-size: 20px;
        
            color:#1E84C4;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .search-input {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0;
            height: 40px;
            padding: 0 15px;
            border: 1px solid rgb(3, 107, 218);
            border-radius: 30px;
            font-size: 16px;
            opacity: 0;
            outline: none;
            transition: width 0.4s ease, opacity 0.4s ease;
        }

        .search-input:focus {
            width: 250px;
            opacity: 1;
        }

        .search-input::placeholder {
            color: rgb(3, 107, 218);
        }

        .search-container.active .search-input {
            width: 150px;
            opacity: 1;
            background-color:rgb(243, 241, 241);
        }

        .search-container.active .search-icon {
            opacity: 0;
        }
        .buton-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-bordered th:nth-child(3),
        .table-bordered td:nth-child(3) {
            width: 80px;
            text-align: center;
        }
        
    </style>
</head>

<body>
      <?php    include 'nav-bar.php'; ?>

            <div class="container mt-4">
            <?php if (isset($_SESSION['deleteMessage'])): ?>
    <div class="alert alert-info" id="deleteMessage">
        <?= htmlspecialchars($_SESSION['deleteMessage']) ?>
    </div>
    <?php unset($_SESSION['deleteMessage']); ?>
    <?php endif; ?>
                <div class="buton-container">
            <button type="button" id="openFormBtn" class="btn btn-outline-primary mb-2" >
                    <i class="fas fa-plus"></i> Add Medicine
                </button>
           

                      <!-- THE SEACRH BAR -->

                <form method="POST" action="medicine.php">
                <div class="search-container" id="searchContainer">
                    <input type="text" name="search" class="search-input" placeholder="Search" value="<?= htmlspecialchars($searchTerm) ?>" id="searchInput">
                    <i class="fas fa-search search-icon"
 id="searchIcon"></i>

                </div>
                </form>
                </div>

               
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Medicine Name</th>
                            <th>Manufacturer</th>
                            <th>Price (MAD)</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                      
                            <?php if ($stmt->num_rows > 0): ?>
            <?php while ($stmt->fetch()): ?>
                <tr>
                    <td><?= htmlspecialchars($productID) ?></td>

                    <!-- IMAGE -->
                    <td>
                                    <?php 
                                    if (!empty($productIMG)) {
                                    
                                        $base64Image = base64_encode($productIMG);

                                        $imageType = $productIMGType; 
                                    ?>
                                         <img src="data:<?php echo $imageType; ?>;base64,<?php echo $base64Image; ?>" width="100px" height="100px" alt="Product Image">
                                    <?php 
                                    } else { 
                                    ?>
                                        No Image
                                    <?php 
                                    } 
                                    ?>
                                    </td>
                    <!-- IMAGE -->

                    <td><?= htmlspecialchars($productName) ?></td>
                    <td><?= htmlspecialchars($productDetails) ?></td>
                    <td><?= htmlspecialchars($Price) ?></td>
                    <td><?= htmlspecialchars($quantity) ?></td>
                    <td>
                
                            <button class='openEditFormBtn btn btn-outline-primary' id="openEditFormBtn"><i class='fas fa-edit'></i></button>
                       
                            <button class='btn-view btn btn-outline-primary'><i class='fas fa-eye'></i></button>

                        <form action="delete-medecine.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $productID ?>">
                            <button class="btn btn-outline-primary" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">No medicines found.</td></tr>
        <?php endif; ?>
                    </tbody>
                </table>

                       
                <div id="popupForm" class="popup-form" style="display: <?= isset($_SESSION['popup']) && $_SESSION['popup'] ? 'flex' : 'none' ?>;">
    
                <div class="form-container">
        <span id="closeFormBtn" class="close-btn">&times;</span>
       

       <!-- Message Display -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info">
        <?= htmlspecialchars($_SESSION['message']) ?>
    </div>
    <?php 
    unset($_SESSION['message']); // Clear message after displaying 
    if (isset($_SESSION['popup'])) {
        unset($_SESSION['popup']); // Reset popup state
    }
    ?>
    
<?php endif; ?>

<form method="POST" action="add-medecine.php" enctype="multipart/form-data">
<img src="grandmedicine.png" width="150px" height="150px" alt="">
    <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Medicine Name"required>
    </div>
    <div class="form-group">
        <input type="text" name="manufacturer" class="form-control" placeholder="Manufacturer" required>
    </div>
    <div class="form-group">
        <input type="number" name="price" class="form-control" placeholder="Price" step="0.01" required>
    </div>
    <div class="form-group">
        <input type="number" name="stock" class="form-control" placeholder="Stock" required>
    </div>
    <button type="submit" name="submit" class="btn btn-outline-primary">
        <i class="fas fa-plus"></i> Add Medicine
    </button>
</form>

    </div>
</div>
            
            </div>
        </div>
    </div>

<!-- Edit Popup Form -->
<div id="editPopupForm" class="popup-form">
    
    <div class="form-container">
    <img src="grandmedicine.png" width="150px" height="150px" alt="">
        <span id="closeEditFormBtn" class="close-btn">&times;</span>
        <form method="POST" action="edit-medecine.php">
            <input type="hidden" name="productID" id="editProductID" value="">
            <div class="form-group">
                <input type="text" name="name" class="form-control" id="editProductName" placeholder="Medicine Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="manufacturer" class="form-control" id="editManufacturer" placeholder="Manufacturer" required>
            </div>
            <div class="form-group">
                <input type="number" name="price" class="form-control" id="editPrice" placeholder="Price" step="0.01" required>
            </div>
            <div class="form-group">
                <input type="number" name="stock" class="form-control" id="editStock" placeholder="Stock" required>
            </div>
            <button type="submit" class="btn btn-outline-primary mb-2">
                <i class="fas fa-edit"></i> Edit Medicine
            </button>
        </form>
    </div>
</div>

<!-- View Product Popup Form -->
<div id="viewPopupForm" class="popup-form">
    <div class="form-container">
        <span id="closeViewFormBtn" class="close-btn">&times;</span>
        <div class="product-details">
            <h4>Product Details</h4>
            <p><strong>Product Name:</strong> <span id="viewProductName"></span></p>
            <p><strong>Manufacturer:</strong> <span id="viewManufacturer"></span></p>
            <p><strong>Price:</strong> MAD<span id="viewPrice"></span></p>
            <p><strong>Stock:</strong> <span id="viewStock"></span></p>
            <p><strong>Product Image:</strong></p>
            <img id="viewProductImage" src="" alt="Product Image" width="200px" height="200px">
        </div>
    </div>
</div>



    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chartsjs/Chart.min.js"></script>
    <script src="../assets/js/dashboard-charts.js"></script>
    <script src="../assets/js/script.js"></script>
    <script>
    // Get elements for add form
const openFormBtn = document.getElementById('openFormBtn');
const closeFormBtn = document.getElementById('closeFormBtn');
const popupForm = document.getElementById('popupForm');

// Get elements for edit form
const openEditFormBtns = document.querySelectorAll('.openEditFormBtn'); // Modify to handle multiple edit buttons
const closeEditFormBtn = document.getElementById('closeEditFormBtn');
const editPopupForm = document.getElementById('editPopupForm');

// Open the add form
openFormBtn.addEventListener('click', () => {
    popupForm.style.display = 'flex';
});

// Close the add form
closeFormBtn.addEventListener('click', () => {
    popupForm.style.display = 'none';
});
window.addEventListener('click', (e) => {
    if (e.target === popupForm) {
        popupForm.style.display = 'none';
    }
   
});
setTimeout(function() {
    var message = document.getElementById('deleteMessage');
    if (message) {
        message.style.display = 'none';
    }
}, 5000);
// Open the edit form for the selected product
openEditFormBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
        const productRow = e.target.closest('tr');
        const productID = productRow.querySelector('td').textContent;
        const productName = productRow.querySelectorAll('td')[2].textContent;
        const manufacturer = productRow.querySelectorAll('td')[3].textContent;
        const price = productRow.querySelectorAll('td')[4].textContent;
        const stock = productRow.querySelectorAll('td')[5].textContent;

        document.getElementById('editProductID').value = productID;
        document.getElementById('editProductName').value = productName;
        document.getElementById('editManufacturer').value = manufacturer;
        document.getElementById('editPrice').value = price;
        document.getElementById('editStock').value = stock;

        editPopupForm.style.display = 'flex';
    });
});

// Close the edit form
closeEditFormBtn.addEventListener('click', () => {
    editPopupForm.style.display = 'none';
});
window.addEventListener('click', (e) => {
    if (e.target === editPopupForm) {
        editPopupForm.style.display = 'none';
    }
});
// Get elements for the view form
const openViewFormBtns = document.querySelectorAll('.btn-view'); // Modify to handle multiple view buttons
const closeViewFormBtn = document.getElementById('closeViewFormBtn');
const viewPopupForm = document.getElementById('viewPopupForm');

// Open the view form for the selected product
openViewFormBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
        const productRow = e.target.closest('tr');
        const productID = productRow.querySelector('td').textContent;
        const productName = productRow.querySelectorAll('td')[2].textContent;
        const manufacturer = productRow.querySelectorAll('td')[3].textContent;
        const price = productRow.querySelectorAll('td')[4].textContent;
        const stock = productRow.querySelectorAll('td')[5].textContent;
        const imageSrc = productRow.querySelector('img').src;

        document.getElementById('viewProductName').textContent = productName;
        document.getElementById('viewManufacturer').textContent = manufacturer;
        document.getElementById('viewPrice').textContent = price;
        document.getElementById('viewStock').textContent = stock;
        document.getElementById('viewProductImage').src = imageSrc;

        viewPopupForm.style.display = 'flex';
    });
});

// Close the view form
closeViewFormBtn.addEventListener('click', () => {
    viewPopupForm.style.display = 'none';
});
window.addEventListener('click', (e) => {
    if (e.target === viewPopupForm) {
        viewPopupForm.style.display = 'none';
    }
});

</script>


</body>
</html>