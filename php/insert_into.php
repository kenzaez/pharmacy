<?php
require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $passwordOne = $_POST['passwordone'];
    $passwordTwo = $_POST['passwordtwo'];
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $mobilephone = trim($_POST['mobilephone']);

    // Validate input
    if (empty($username) || empty($passwordOne) || empty($passwordTwo) || empty($fullname) || empty($email) || empty($mobilephone)) {
        die("All fields are required.");
    }

    // Check if passwords match
    if ($passwordOne !== $passwordTwo) {
        die("Passwords do not match.");
    }

 

    // Hash passwords
    $hashedPasswordOne = password_hash($passwordOne, PASSWORD_DEFAULT);
    $hashedPasswordTwo = password_hash($passwordTwo, PASSWORD_DEFAULT);

    // Insert new user
    $sql = "INSERT INTO users (username, passwordone, passwordtwo, fullname, email, mobilephone, userRole) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $username, $hashedPasswordOne, $hashedPasswordTwo, $fullname, $email, $mobilephone, $role);

    if ($stmt->execute()) {
        echo "User registered successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="insert_into.php" method="POST">
    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Full Name:</label>
    <input type="text" name="fullname" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Mobile Phone:</label>
    <input type="text" name="mobilephone" required>

    <label>Password:</label>
    <input type="password" name="passwordone" required>

    <label>Confirm Password:</label>
    <input type="password" name="passwordtwo" required>
    <label>role</label>
    <input type="text" name="role" required>

    <button type="submit">Register</button>
</form>


</body>
</html>