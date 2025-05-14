<?php
/*
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../user/login.php");
    exit();
}
function is_logged_in() {
    return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}
*/

session_start();
function require_admin() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: /shoe-store/admin/login.php");
        exit();
    }
}
function redirect($url) {
    header("Location: $url");
    exit();
}
?>
