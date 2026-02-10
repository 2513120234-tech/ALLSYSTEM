<?php
session_start();
require_once '../config/condb.php';
require_once '../activity_log.php';

if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] !== 'member') {
    if (isset($_SESSION['user_id'])) {
        logActivity(
            $condb,
            $_SESSION['user_id'],
            $_SESSION['role'],
            'unauthorized'
        );
    }

    header("Location: ../login.php?error=unauthorized");
    exit;
}

?>