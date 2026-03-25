<?php
require "../config/database.php";
require "../config/csrf.php";

//session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if(!verify_csrf($_POST['csrf_token'] ?? "")) {
        die("Invalid CSRF token");
    }

    $id = $_POST['id'] ?? null;

    if(!$id) {
        die("Product not found");
    }
    $stmt = $pdo->prepare("SELECT image from products where id = :id");
    $stmt->execute([
        ':id' => $id
    ]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($product)) {
        die("No data found");
    }
    
    if (file_exists('../uploads/'.$product['image'])) {
        unlink('../uploads/'.$product['image']);
    }
        

    $stmt = $pdo->prepare("DELETE FROM products where id=:id");
    $stmt->execute([
        ':id' => $id
    ]);
        
    $_SESSION['success_msg'] = "Product deleted successfully";
    header("Location: list.php");
    exit();
}

?>