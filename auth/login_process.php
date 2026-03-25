<?php
require "../config/database.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";

    $_SESSION['old'] = $_POST;
    $errors = [];

    if (!$email) {
        $errors['email'] = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email";
    }

    if (!$password)  {
        $errors['password'] = "Password is required";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: login.php");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users where email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: ../dashboard.php");
        exit();
    } else {
        $errors['password'] = "Invalid email or Password";
        $_SESSION['errors'] = $errors;
        header("Location: login.php");
        exit();
    }
    
    

}

?>