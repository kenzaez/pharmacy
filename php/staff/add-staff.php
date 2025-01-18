<?php 
session_start();
include '../connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $username = $_POST['username'];
    $passwordOne = $_POST['passwordone'];
    $passwordTwo = $_POST['passwordtwo'];
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $mobilePhone = $_POST['mobilephone'];
    $userRole = $_POST['userRole'];

    // Vérification si les mots de passe correspondent
    if ($passwordOne !== $passwordTwo) {
        $_SESSION['message'] = "Les mots de passe ne correspondent pas.";
        $_SESSION['popup'] = true;
        header("Location: register.php");
        exit();
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($passwordOne, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, passwordone, fullname, email, mobilephone, userRole) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $username, $hashedPassword, $fullName, $email, $mobilePhone, $userRole);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Utilisateur ajouté avec succès !";
        $_SESSION['popup'] = true;
    } else {
        $_SESSION['message'] = "Erreur lors de l'inscription : " . $stmt->error;
        $_SESSION['popup'] = true;
    }
    
    $stmt->close();
}

$conn->close();
header("Location: staff.php");
exit();
?>
