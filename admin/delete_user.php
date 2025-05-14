<?php
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    $_SESSION['error_message'] = "Invalid user ID.";
    header("Location: users.php");
    exit();
}

try {
    // Delete related records in tblOrderItems
    $stmt = $pdo->prepare("
        DELETE tblOrderItems 
        FROM tblOrderItems 
        INNER JOIN tblOrders ON tblOrderItems.OrderID = tblOrders.OrderID 
        WHERE tblOrders.UserID = ?
    ");
    $stmt->execute([$id]);

    // Delete related records in tblOrders
    $stmt = $pdo->prepare("DELETE FROM tblOrders WHERE UserID = ?");
    $stmt->execute([$id]);

    // Delete related records in tblReviews
    $stmt = $pdo->prepare("DELETE FROM tblReviews WHERE UserID = ?");
    $stmt->execute([$id]);

    // Delete the user
    $stmt = $pdo->prepare("DELETE FROM tblUsers WHERE UserID = ?");
    $stmt->execute([$id]);

    // Check if the user was deleted
    if ($stmt->rowCount() > 0) {
        logAdminAction($_SESSION['admin_id'], "Deleted user #$id");
        $_SESSION['success_message'] = "User #$id deleted successfully.";
    } else {
        $_SESSION['error_message'] = "User #$id not found or could not be deleted.";
    }
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Error deleting user: " . $e->getMessage();
}

header("Location: users.php");
exit();