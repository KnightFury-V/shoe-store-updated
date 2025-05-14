<?php
session_start();

$action = $_GET['action'] ?? '';
$id = (int)($_GET['id'] ?? 0);

if ($action === 'remove' && $id && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
    $_SESSION['success_message'] = "Product removed from cart.";
}

header('Location: view_cart.php');
exit();