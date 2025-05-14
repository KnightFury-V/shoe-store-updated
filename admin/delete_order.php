<?php
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';

$orderId = (int)($_GET['id'] ?? 0);

if (!$orderId) {
    header("Location: orders.php");
    exit();
}

try {
    // Start a transaction
    $pdo->beginTransaction();

    // Delete order items
    $stmt = $pdo->prepare("DELETE FROM tblOrderItems WHERE OrderID = ?");
    $stmt->execute([$orderId]);

    // Delete the order
    $stmt = $pdo->prepare("DELETE FROM tblOrders WHERE OrderID = ?");
    $stmt->execute([$orderId]);

    // Commit the transaction
    $pdo->commit();

    // Redirect back to the orders page with a success message
    header("Location: orders.php?success=Order deleted successfully");
    exit();
} catch (Exception $e) {
    // Rollback the transaction on failure
    $pdo->rollBack();
    header("Location: orders.php?error=Failed to delete order");
    exit();
}