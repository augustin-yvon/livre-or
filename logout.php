<?php
require_once './classe/user.php';

session_start();

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $user->logout();
}

header("Location: index.php");
exit();
?>