<?php
    session_start();
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
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register_process.php" method="POST">
        Name : <input type="text" name="name" value="<?= isset($old['name']) ? $old['name'] : "" ?>" />
        <p style="color:red"><?= isset($errors['name']) ? $errors['name'] : ""  ?></p>
        <br/><br/>

        Email : <input type="email" name="email" value="<?= isset($old['email']) ? $old['email'] : "" ?>" />
        <p style="color:red"><?= isset($errors['email']) ? $errors['email'] : ""  ?></p>
        <br/><br/>

        Password : <input type="password" name="password" />
        <p style="color:red"><?= isset($errors['password']) ? $errors['password'] : ""  ?></p>
        <br/><br/>

        Confirm Password : <input type="password" name="confirm_password"  />
        <p style="color:red"><?= isset($errors['confirm_password']) ? $errors['confirm_password'] : ""  ?></p>
        <br/><br/>

        <input type="submit" value="Register">
        <br/><br/>
        <p>if already registered ? <a href="login.php">Login</a></p>
    </form>
</body>
</html>
<?php
unset($errors);
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>