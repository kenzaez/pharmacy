<!--php part for selecting data from database -->
<?php
require_once '../connect.php';
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
//COOKIEEESS 
if (!isset($_COOKIE['pageViews'])) {
    setcookie('pageViews', 1, time() + (30 * 24 * 60 * 60), "/"); 
    $pageViews = 1;
} else {
    $pageViews = $_COOKIE['pageViews'] + 1;
    setcookie('pageViews', $pageViews, time() + (30 * 24 * 60 * 60), "/"); 
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>medicine</title>
    <link href="../../assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/master.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/medicine.css">

</head>

<body>
    <!-- including navigation bar -->
    <?php    include '../nav-bar.php'; ?>
    <div class="container mt-4">
        <!-- MESSAGE SHOWN AFTER DELETING A MEDICINE -->
        <?php if (isset($_SESSION['deleteMessage'])): ?>
        <div class="alert alert-info" id="deleteMessage">
            <?= htmlspecialchars($_SESSION['deleteMessage']) ?>
        </div>
        <?php unset($_SESSION['deleteMessage']); ?>
        <?php endif; ?>

        <!-- BUTTONS FOR ADDING A MEDICINE AND SEARCH BAR -->
        <div class="buton-container">
            <!-- ADD MEDICINE -->
            <?php if ($_SESSION['role'] != 'pharmacist'): ?>
            <button type="button" id="openFormBtn" class="btn btn-outline-primary mb-2">
                <i class="fas fa-plus"></i> Add Medicine
            </button>
            <?php endif; ?>

            <!-- THE SEACRH BAR -->
            <form action="" method="GET">
                <div id="searchContainer" class="search-container">
                    <input type="text" name="search" id="searchInput" class="search-input" placeholder="Search..."
                        value="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>">
                    <i id="searchIcon" class="fas fa-search search-icon"></i>
                </div>
            </form>
        </div>

        <!-- PART I : TABLE FOR DISPLAYING MEDICINES -->
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

                <?php
    // Check if the search parameter exists
    if (isset($_GET['search'])) {
        include 'search-bar.php';  // Include search bar if searching
    }

    // Check if there are results
    if ($stmt->num_rows > 0):
        while ($stmt->fetch()): ?>
                <tr>
                    <td><?= htmlspecialchars($productID) ?></td>

                    <!-- IMAGE -->
                    <td>
                        <?php if (!empty($productIMG)): 
                        $base64Image = base64_encode($productIMG);
                        $imageType = $productIMGType;
                    ?>
                        <img src="data:<?= $imageType; ?>;base64,<?= $base64Image; ?>" width="100px" height="100px"
                            alt="Product Image">
                        <?php else: ?>
                        No Image
                        <?php endif; ?>
                    </td>
                    <!-- IMAGE -->

                    <td><?= htmlspecialchars($productName) ?></td>
                    <td><?= htmlspecialchars($productDetails) ?></td>
                    <td><?= htmlspecialchars($Price) ?></td>
                    <td>
                        <?php if ($quantity <= 0): ?>
                        <span class="badge bg-danger">Out of Stock</span>
                        <?php else: ?>
                        <?= htmlspecialchars($quantity) ?>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($_SESSION['role'] === 'pharmacist'): ?>
                        <button class='btn-view btn btn-outline-primary'><i class='fas fa-eye'></i></button>
                        <?php else: ?>
                        <button class='btn-view btn btn-outline-primary'><i class='fas fa-eye'></i></button>
                        <button class='openEditFormBtn btn btn-outline-primary' id="openEditFormBtn"><i
                                class='fas fa-edit'></i></button>
                        <form action="delete-medecine.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $productID ?>">
                            <button class="btn btn-outline-primary" type="submit"><i
                                    class="fas fa-trash-alt"></i></button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; 
    else: ?>
                <tr>
                    <td colspan="7" class="text-center">No medicines found.</td>
                </tr>
                <?php endif; ?>

            </tbody>

        </table>

        <!-- PART 2 : POPUP FORMS FOR ADDING MEDICINES -->

        <div id="popupForm" class="popup-form"
            style="display: <?= isset($_SESSION['popup']) && $_SESSION['popup'] ? 'flex' : 'none' ?>;">

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
                        <input type="text" name="name" class="form-control" placeholder="Medicine Name" required>
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
                    <div class="form-group">
                        <input type="file" name="image" class="form-control" required>
                        <button type="submit" name="submit" class="btn btn-outline-primary">
                            <i class="fas fa-plus"></i> Add Medicine
                        </button>
                </form>

            </div>
        </div>

    </div>
    </div>
    </div>
    <!-- PART 3 : POPUP FORMS FOR EDITING MEDICINES -->


    <div id="editPopupForm" class="popup-form">

        <div class="form-container">
            <img src="../grandmedicine.png" width="150px" height="150px" alt="">
            <span id="closeEditFormBtn" class="close-btn">&times;</span>
            <form method="POST" action="edit-medecine.php">
                <input type="hidden" name="productID" id="editProductID" value="">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" id="editProductName" placeholder="Medicine Name"
                        required>
                </div>
                <div class="form-group">
                    <input type="text" name="manufacturer" class="form-control" id="editManufacturer"
                        placeholder="Manufacturer" required>
                </div>
                <div class="form-group">
                    <input type="number" name="price" class="form-control" id="editPrice" placeholder="Price"
                        step="0.01" required>
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
    <!-- PART 4 : POPUP FORMS FOR VIEWING MEDICINES -->
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



    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/chartsjs/Chart.min.js"></script>
    <script src="../../assets/js/dashboard-charts.js"></script>
    <script src="../../assets/js/script.js"></script>


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
    const searchIcon = document.getElementById('searchIcon');
    const searchInput = document.getElementById('searchInput');
    const searchContainer = document.getElementById('searchContainer');

    searchIcon.addEventListener('click', () => {
        searchInput.focus();
        searchContainer.classList.add('active');
    });

    searchInput.addEventListener('blur', () => {
        if (searchInput.value === '') {
            searchContainer.classList.remove('active');
        }
    });
    </script>


</body>

</html>