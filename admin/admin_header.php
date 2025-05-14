<?php
session_start();
require_once '../includes/auth.php';
require_admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="/shoe-store/admin/dashboard.php">Dashboard</a></li>
            <li><a href="/shoe-store/admin/categories.php">Manage Categories</a></li>
            <li><a href="/shoe-store/admin/products.php">Manage Products</a></li>
            <li><a href="/shoe-store/admin/orders.php">Manage Orders</a></li>
            <li><a href="/shoe-store/admin/users.php">Manage Users</a></li>
            <li><a href="/shoe-store/admin/Logs.php">Admin Actions</a></li>
            <li><a href="/shoe-store/admin/logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<main>