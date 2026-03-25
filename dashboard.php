<?php
    session_start();

    if (!isset($_SESSION['user'])) {
        header("Location: auth/login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    
    <?php echo "Welcome " . htmlspecialchars($_SESSION['user']['name']); ?>

    <p><a href="auth/logout.php">Logout</a></p>

    <p><a href="products/list.php">View Product</a> || <a href="products/add.php"> Add Product </a></p>
</body>
</html>