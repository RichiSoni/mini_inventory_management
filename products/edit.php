<?php
    require "../config/database.php";
    require "../config/csrf.php";
    //session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: ../auth/login.php");
        exit();
    }

    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
    }

    if (isset($_SESSION['old'])) {
        $old = $_SESSION['old'];
    }

    $id = $_GET['id'] ?? null;
    if(!$id) {
        die("Product not found");
    }
    $stmt = $pdo->prepare("SELECT * from products where id = :id");
    $stmt->execute([
        ':id' => $id
    ]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($product)) {
        die("No data found");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form action="update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= create_csrf() ?>">
        <input type="hidden" name="id" value="<?= $product['id'] ?>" >
        Name : <input type="text" name="name" value="<?= isset($old['name']) ? $old['name'] : $product['name'] ?? "" ?>" />
        <p style="color:'red'"><?= isset($errors['name']) ? $errors['name'] : ""  ?></p>
        <br/><br/>

        Price : <input type="number" name="price" value="<?= isset($old['price']) ? $old['price'] : $product['price'] ?? "" ?>" />
        <p style="color:'red'"><?= isset($errors['price']) ? $errors['price'] : ""  ?></p>
        <br/><br/>

        Quantity : <input type="number" name="qty" value="<?= isset($old['qty']) ? $old['qty'] : $product['quantity'] ?? "" ?>" />
        <p style="color:'red'"><?= isset($errors['qty']) ? $errors['qty'] : ""  ?></p>
        <br/><br/>

        Current Image : <img src="../uploads/<?=$product['image']?>" width="50px"><br/>

        Image (optional) : <input type="file" name="image"/>
        <p style="color:'red'"><?= isset($errors['image']) ? $errors['image'] : ""  ?></p>
        <br/><br/>

        <input type="hidden" name="old_image" value="<?=$product['image']?>">

        <input type="submit" value="Update Product">
        <br/><br/>
        <p>View Products ? <a href="list.php">View</a></p>
    </form>
</body>
</html>
<?php
unset($errors);
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>