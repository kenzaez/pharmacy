<?php
require_once '../connect.php';
session_start();
//SETTING COOKIES TO TRACK THE VISITORS
if (isset($_COOKIE['staff'])) {
    $visitorCount = $_COOKIE['staff'] + 1;
} else {
    $visitorCount = 1;
}
setcookie("staff", $visitorCount, time() + 365 * 24 * 60 * 60, "/");
// SQL query to fetch user data
$sql = 'SELECT userid, username, fullname, email, mobilephone, userRole FROM users';

$stmt = $conn->stmt_init(); 

if ($stmt->prepare($sql)) {
    $stmt->execute(); 
    
   
    $stmt->bind_result($userid, $username, $fullname, $email, $mobilephone, $role);
    
    $stmt->store_result(); 

 
    if ($stmt->error) {
        echo $stmt->errno . ": " . $stmt->error; 
        exit();
    }
} else {
    echo "SQL preparation error: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Staff</title>
    <link href="../../assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="../../assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/master.css" rel="stylesheet">
    <link href="../css/staff.css" rel="stylesheet">
</head>

<body>
    <?php include '../nav-bar.php'; ?>
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
                <i class="fas fa-plus"></i> Add Staff
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
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Mobile Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($stmt->num_rows > 0): ?>
                    <?php while ($stmt->fetch()): ?>
                    <tr>
                        <td><?= htmlspecialchars($userid) ?></td>
                        <td><?= htmlspecialchars($username) ?></td>
                        <td><?= htmlspecialchars($fullname) ?></td>
                        <td><?= htmlspecialchars($email) ?></td>
                        <td> <?= htmlspecialchars($mobilephone) ?></td>
                        <td><?= htmlspecialchars($role) ?></td>
                        <td>
                            <?php if ($_SESSION['role'] === 'pharmacist'): ?>
                            <button class='btn-view btn btn-outline-primary'><i class='fas fa-eye'></i></button>

                            <?php else: ?>

                            <button class='btn-view btn btn-outline-primary'><i class='fas fa-eye'></i></button>
                            <button class='openEditFormBtn btn btn-outline-primary' id="openEditFormBtn"><i
                                    class='fas fa-edit'></i></button>

                            <form action="delete-staff.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $userid ?>">
                                <button class="btn btn-outline-primary" type="submit"><i
                                        class="fas fa-trash-alt"></i></button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>

                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No staff found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
<!-- PART II : FORM FOR ADDING A STAFF -->

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

        <form method="POST" action="add-staff.php" >
            <img src="../grandmedicine.png" width="150px" height="150px" alt="">
            <div class="form-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="passwordone" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="passwordtwo" class="form-control" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="tel" name="mobilephone" class="form-control" placeholder="Mobile Phone" required>
            </div>
            <div class="form-group">
                <input type="text" name="userRole" class="form-control" placeholder="User Role" optional>
            </div>
            <button type="submit" name="submit" class="btn btn-outline-primary">
                <i class="fas fa-plus"></i> Add User
            </button>
        </form>
    </div>
</div>
</div>
<!-- PART III : FORM FOR EDITING A STAFF -->
<div id="editPopupForm" class="popup-form">
    <div class="form-container">
        <img src="../grandmedicine.png" width="150px" height="150px" alt="">
        <span id="closeEditFormBtn" class="close-btn">&times;</span>
        <form method="POST" action="edit-staff.php">
            <input type="hidden" name="userid" id="editUserID" value="">
            <div class="form-group">
                <input type="text" name="username" class="form-control" id="editUsername" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="passwordone" class="form-control" id="editPasswordOne" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="passwordtwo" class="form-control" id="editPasswordTwo" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <input type="text" name="fullname" class="form-control" id="editFullname" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-control" id="editEmail" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="tel" name="mobilephone" class="form-control" id="editMobilephone" placeholder="Mobile Phone" required>
            </div>
            <div class="form-group">
                <input type="text" name="userRole" class="form-control" id="editUserRole" placeholder="User Role">
            </div>
            <button type="submit" class="btn btn-outline-primary mb-2">
                <i class="fas fa-edit"></i> Edit User
            </button>
        </form>
    </div>
</div>
<!-- PART IV : VIEWING STAFF DETAILS -->
<div id="viewPopupForm" class="popup-form">
    <div class="form-container">
        <span id="closeViewFormBtn" class="close-btn">&times;</span>
        <div class="user-details">
            <img src="pharmacist.png" width="150px" height="150px" alt="">
          
            <p class="name"><span id="viewFullname"></span></p>
            <div class="details">
            <p><strong>Username:</strong> <span id="viewUsername"></span></p>
            <p><strong>Email:</strong> <span id="viewEmail"></span></p>
            <p><strong>Mobile Phone:</strong> <span id="viewMobilephone"></span></p>
            <p><strong>User Role:</strong> <span id="viewUserRole"></span></p>
            </div>
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
        const userRow = e.target.closest('tr');
        const userID = userRow.querySelector('td').textContent;
        const username = userRow.querySelectorAll('td')[1].textContent;
        const fullname = userRow.querySelectorAll('td')[2].textContent;
        const email = userRow.querySelectorAll('td')[3].textContent;
        const mobilephone = userRow.querySelectorAll('td')[4].textContent;
        const userRole = userRow.querySelectorAll('td')[5].textContent;

        // Fill the edit form with the selected user's data
        document.getElementById('editUserID').value = userID;
        document.getElementById('editUsername').value = username;
        document.getElementById('editFullname').value = fullname;
        document.getElementById('editEmail').value = email;
        document.getElementById('editMobilephone').value = mobilephone;
        document.getElementById('editUserRole').value = userRole;

        // Open the edit popup form
        editPopupForm.style.display = 'flex';
    });
    if(closeEditFormBtn){
        closeEditFormBtn.addEventListener('click', () => {
            editPopupForm.style.display = 'none';
        });
    }
});

const openViewFormBtns = document.querySelectorAll('.btn-view'); // Modify to handle multiple view buttons
    const closeViewFormBtn = document.getElementById('closeViewFormBtn');
    const viewPopupForm = document.getElementById('viewPopupForm');
openViewFormBtns.forEach((btn) => {
    btn.addEventListener('click', (e) => {
        const userRow = e.target.closest('tr');
        const userID = userRow.querySelector('td').textContent;
        const username = userRow.querySelectorAll('td')[1].textContent;
        const fullname = userRow.querySelectorAll('td')[2].textContent;
        const email = userRow.querySelectorAll('td')[3].textContent;
        const mobilephone = userRow.querySelectorAll('td')[4].textContent;
        const userRole = userRow.querySelectorAll('td')[5].textContent;

        // Fill the view form with the selected user's data
        document.getElementById('viewUsername').textContent = username;
        document.getElementById('viewFullname').textContent = fullname;
        document.getElementById('viewEmail').textContent = email;
        document.getElementById('viewMobilephone').textContent = mobilephone;
        document.getElementById('viewUserRole').textContent = userRole;

        // Open the view popup form
        viewPopupForm.style.display = 'flex';
    });
    if (closeViewFormBtn) {
        closeViewFormBtn.addEventListener('click', () => {
            viewPopupForm.style.display = 'none';
        });
    }
});

</script>

</body>

</html>