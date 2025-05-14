<?php


session_start();
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

// Decode the incoming JSON data
$data = json_decode(file_get_contents('php://input'), true);
$productId = (int)($data['productId'] ?? 0);

if (!$productId) {
    echo json_encode(['message' => 'Invalid product ID.']);
    exit();
}

// Fetch product details
$stmt = $pdo->prepare("SELECT ProductID, ProductName, Price, ImagePath FROM tblProducts WHERE ProductID = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo json_encode(['message' => 'Product not found.']);
    exit();
}

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity']++;
} else {
    $_SESSION['cart'][$productId] = [
        'id' => $product['ProductID'],
        'name' => $product['ProductName'],
        'price' => $product['Price'],
        'image' => $product['ImagePath'],
        'quantity' => 1,
    ];
}

echo json_encode(['message' => 'Product added to cart.']);
exit();