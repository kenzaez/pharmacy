<?php
require_once 'connect.php';
require_once 'search-bar.php'; 
session_start();


$sql = 'SELECT productID, productName, productDetails, quantity, Price FROM Products';

$stmt = $conn->stmt_init();

if ($stmt->prepare($sql)) {
    $stmt->execute();
    
    // Bind the results
    $stmt->bind_result($productID, $productName, $productDetails, $quantity, $Price);
    
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
        /* Popup Form Styles */
        .popup-form {
            display: none;
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
                            <th>Price ($)</th>
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
                        <a href="medicine.php?id=<?= $productID ?>">
                            <button class='btn btn-outline-primary'><i class='fas fa-edit'></i></button>
                        </a>
                        <button class='btn btn-outline-primary'><i class='fas fa-eye'></i></button>

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
    <div class="form-group">
        <input type="text" name="name" class="form-control" placeholder="Medicine Name" value="<?= htmlspecialchars($productName) ?>" required>
    </div>
    <div class="form-group">
        <input type="text" name="manufacturer" class="form-control" placeholder="Manufacturer" value="<?= htmlspecialchars($productDetails) ?>" required>
    </div>
    <div class="form-group">
        <input type="number" name="price" class="form-control" placeholder="Price" step="0.01" value="<?= htmlspecialchars($Price) ?>" required>
    </div>
    <div class="form-group">
        <input type="number" name="stock" class="form-control" placeholder="Stock" value="<?= htmlspecialchars($quantity) ?>" required>
    </div>
    <div class="form-group">
        <input type="file" name="image" class="form-control" required>
    </div>
    <button type="submit" name="submit" class="btn btn-outline-primary mb-2">
        <i class="fas fa-plus"></i> Add Medicine
    </button>
</form>

    </div>
</div>
            
            </div>
        </div>
    </div>

  <?php require_once 'edit-form.php'; ?>


    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chartsjs/Chart.min.js"></script>
    <script src="../assets/js/dashboard-charts.js"></script>
    <script src="../assets/js/script.js"></script>

    <script>
        
        const searchContainer = document.getElementById('searchContainer');
    const searchInput = document.getElementById('searchInput');
    const searchIcon = document.getElementById('searchIcon');

    searchIcon.addEventListener('click', () => {
        searchContainer.classList.toggle('active');
        searchInput.focus();
    });

    // Close the search bar when the user clicks outside
    window.addEventListener('click', (event) => {
        if (!searchContainer.contains(event.target)) {
            searchContainer.classList.remove('active');
        }
    });
        // Get elements
        const openFormBtn = document.getElementById('openFormBtn');
        const closeFormBtn = document.getElementById('closeFormBtn');
        const popupForm = document.getElementById('popupForm');

        // Open the form
        openFormBtn.addEventListener('click', () => {
            popupForm.style.display = 'flex';
        });

        // Close the form
        closeFormBtn.addEventListener('click', () => {
            popupForm.style.display = 'none';
        });

        // Close the form if clicked outside of the form
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
        document.querySelectorAll(".btn-outline-primary .fa-edit").addEventListener("click", function() {
        // button.parentElement.addEventListener("click", function() {
        //     const row = this.closest("tr");
        //     document.getElementById("editProductID").value = row.cells[0].textContent;
        //     document.getElementById("editName").value = row.cells[2].textContent;
        //     document.getElementById("editManufacturer").value = row.cells[3].textContent;
        //     document.getElementById("editPrice").value = row.cells[4].textContent;
        //     document.getElementById("editStock").value = row.cells[5].textContent;
            document.getElementById("editPopupForm").style.display = "flex";
        });
    // });

    document.getElementById("closeEditFormBtn").addEventListener("click", function() {
        document.getElementById("editPopupForm").style.display = "none";
    });
    
    window.addEventListener("click", function(e) {
        if (e.target === document.getElementById("editPopupForm")) {
            document.getElementById("editPopupForm").style.display = "none";
        }
    });

    </script>

</body>
</html>