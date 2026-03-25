<?php
    session_start();
    
    function create_csrf()
    {
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    function verify_csrf($token) {
        return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
    }

?>