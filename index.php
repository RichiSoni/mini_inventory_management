<?php
    session_start();
    if (isset($_SESSION['user'])) {
        header("Location: products/list.php");
    } else {
        header("Location: auth/login.php");
    }

?>