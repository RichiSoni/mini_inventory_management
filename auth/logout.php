<?php
    session_start();
    $_SESSION['errors'] = [];
    $_SESSION['old'] = [];
    $_SESSION['user'] = [];
    session_destroy();
    header("Location: login.php");
    exit();
?>