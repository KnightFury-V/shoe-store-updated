<?php
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';

$id = (int)($_GET['id'] ?? 0);

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM tblProducts WHERE ProductID = ?");
        $stmt->execute([$id]);

        // Check if the product was deleted
        if ($stmt->rowCount() > 0) {
            $_SESSION['success_message'] = "Product #$id deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Product #$id not found or could not be deleted.";
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error deleting product: " . $e->getMessage();
    }
} else {
    $_SESSION['error_message'] = "Invalid product ID.";
}

header("Location: products.php");
exit;