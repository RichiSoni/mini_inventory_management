<?php
    require "../config/csrf.php";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h2>Add Product</h2>
    <form action="add_process.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= create_csrf() ?>">
        Name : <input type="text" name="name" value="<?= isset($old['name']) ? $old['name'] : "" ?>" />
        <p style="color:'red'"><?= isset($errors['name']) ? $errors['name'] : ""  ?></p>
        <br/><br/>

        Price : <input type="number" name="price" value="<?= isset($old['price']) ? $old['price'] : "" ?>" />
        <p style="color:'red'"><?= isset($errors['price']) ? $errors['price'] : ""  ?></p>
        <br/><br/>

        Quantity : <input type="number" name="qty" value="<?= isset($old['qty']) ? $old['qty'] : "" ?>" />
        <p style="color:'red'"><?= isset($errors['qty']) ? $errors['qty'] : ""  ?></p>
        <br/><br/>

        Image : <input type="file" name="image"/>
        <p style="color:'red'"><?= isset($errors['image']) ? $errors['image'] : ""  ?></p>
        <br/><br/>

        <input type="submit" value="Add Product">
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