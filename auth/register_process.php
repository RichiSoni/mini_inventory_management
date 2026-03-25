<?php
require "../config/database.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $password = $_POST['password'] ?? "";
    $confirm = $_POST['confirm_password'] ?? "";

    $_SESSION['old'] = $_POST;
    $errors = [];

    if (!$name) $errors['name'] = "Name is required";

    if (!$email) {
        $errors['email'] = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email";
    }

    if (!$password || strlen($password) < 6)  {
        $errors['password'] = "Min 6 character long password required";
    }

    if (!$confirm) {
        $errors['confirm_password'] = "Confirm Password is required";
    } else if ($password !== $confirm) {
        $errors['confirm_password'] = "Password and Confirm password mismatched";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT count(*), email FROM users where email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetchColumn();

        if ($user) {
            $errors['email'] = "Email is already taken";
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit();
    }

    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users(name, email, password) values(:name,:email,:password)");
    $stmt->execute([':name' => $name,':email' => $email, ':password' => $hashPassword]);

    $_SESSION['success_msg'] = "Registered Successfully, Please login";
    header("Location: login.php");

}

?>