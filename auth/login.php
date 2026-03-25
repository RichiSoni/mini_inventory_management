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
    <title>Login</title>
</head>
<body>
    <?php if (isset($_SESSION['success_msg'])) : ?>
        <p style="color:green"><?= $_SESSION['success_msg'] ?></p>
    <?php 
        unset($_SESSION['success_msg']);
        endif;
    ?>
    <h2>Login</h2>
    <form action="login_process.php" method="POST">
        Email : <input type="email" name="email" value="<?= isset($old['email']) ? $old['email'] : "" ?>" />
        <p style="color:red"><?= isset($errors['email']) ? $errors['email'] : ""  ?></p>
        <br/><br/>

        Password : <input type="password" name="password" />
        <p style="color:red"><?= isset($errors['password']) ? $errors['password'] : ""  ?></p>
        <br/><br/>

        <input type="submit" value="Login">
        <br/><br/>
        <p>if you have not registered yet ? <a href="register.php">Register</a></p>
    </form>
</body>
</html>
<?php
unset($errors);
unset($_SESSION['errors']);
unset($_SESSION['old']);
?>