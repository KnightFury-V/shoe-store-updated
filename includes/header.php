<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Store</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="/shoe-store/index.php">Home</a></li>
            <li><a href="/shoe-store/view_cart.php">View Cart</a></li>
            <li><a href="/shoe-store/user/wishlist.php">My Wishlist</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="/shoe-store/user/user_orders.php">My Orders</a></li>
                <li><a href="/shoe-store/user/profile.php">Profile</a></li>
                <li><a href="/shoe-store/user/logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="/shoe-store/user/login.php">Login</a></li>
                <li><a href="/shoe-store/user/register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>