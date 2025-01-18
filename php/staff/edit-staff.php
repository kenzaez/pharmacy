<?php
require_once '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture the form data for the user
    $userID = $_POST['userid'];
    $username = $_POST['username'];
    $passwordone = $_POST['passwordone'];
    $passwordtwo = $_POST['passwordtwo'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $mobilephone = $_POST['mobilephone'];
    $userRole = $_POST['userRole'];

    // Ensure the passwords match
    if ($passwordone !== $passwordtwo) {
        $_SESSION['messageEdit'] = 'Passwords do not match.';
        $_SESSION['popupEdit'] = true;
        header('Location: user.php');
        exit();
    }

    // Hash the password before updating
    $hashedPassword = password_hash($passwordone, PASSWORD_DEFAULT);

    // Update the user information in the database
    $sql = 'UPDATE users SET username = ?, passwordone = ?, fullname = ?, email = ?, mobilephone = ?, userRole = ? WHERE userid = ?';

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ssssssi', $username, $hashedPassword, $fullname, $email, $mobilephone, $userRole, $userID);

        if ($stmt->execute()) {
            $_SESSION['messageEdit'] = 'User updated successfully!';
            $_SESSION['popupEdit'] = true;
        } else {
            $_SESSION['messageEdit'] = 'Failed to update user.';
            $_SESSION['popupEdit'] = true;
        }

        $stmt->close();
    }

    // Redirect back to the users page
    header('Location: staff.php');
    exit();
}
?>
