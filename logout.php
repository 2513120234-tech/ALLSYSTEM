<?php
session_start(); //ประกาศใช้ session
require_once 'config/condb.php';
require_once 'activity_log.php';

if (isset($_SESSION['user_id'])) {
    logActivity(
        $condb,
        $_SESSION['user_id'],
        $_SESSION['role'],
        'logout'
    );
}

session_destroy();
header("Location: login.php");
exit;
?>