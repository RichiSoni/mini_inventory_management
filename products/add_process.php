<?php
require "../config/database.php";
require "../config/csrf.php";

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if(!verify_csrf($_POST['csrf_token'] ?? "")) {
        die("Invalid CSRF token");
    }

    $name = $_POST['name'] ?? "";
    $price = $_POST['price'] ?? "";
    $qty = $_POST['qty'] ?? "";
    $file = $_FILES['image']['name'] ?? "";
    $allowedType = ['image/jpeg', 'image/png'];

    $_SESSION['old'] = $_POST;
    $errors = [];

    if (!$name) $errors['name'] = "Name is required";

    if (!$price) {
        $errors['price'] = "Price is required";
    } else if (!is_numeric($price) || $price < 0) {
        $errors['price'] = "Price must be numeric and greater than 0";
    }

    if (!$qty || !is_numeric($qty) || $qty < 0)  {
        $errors['qty'] = "Quantity is required and it must be greater than 0";
    }

    if (empty($file)) {
        $errors['image'] = "Image is required";
    } 
    else if (!in_array($_FILES['image']['type'], $allowedType)) {
        $errors['image'] = "Only JPG and PNG image type is allowed";
    }
    else if ($_FILES['image']['size'] > 2000000) {
        $errors['image'] = "Max size 2MB image upload allowed";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: add.php");
        exit();
    }

    if(!is_dir('../uploads/')) {
        mkdir("../uploads/");
    }
    $folder = "../uploads/";
    $fileName = uniqid().'_'.$file;
    $targetFile = $folder.basename($fileName);
    $uploaded = move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    if (!$uploaded) {
        die("Issue in uploading image");
    }

    $stmt = $pdo->prepare("INSERT INTO products(name, price, quantity, image) VALUES(:name,:price,:qty,:img)");
    $stmt->execute([':name' => $name,':price' => $price, ':qty'=>$qty, ':img' => $fileName]);


    $_SESSION['success_msg'] = "Product added successfully";
    header("Location: list.php");
    exit();
}

?>