<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/auth_user.php';
require_once '../includes/functions.php';

// Add to wishlist
if (isset($_GET['add'])) {
    $productId = (int)$_GET['add'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO tblWishlist (UserID, ProductID) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $productId]);
    header("Location: wishlist.php");
    exit();
}

// Remove from wishlist
if (isset($_GET['remove'])) {
    $productId = (int)$_GET['remove'];
    $stmt = $pdo->prepare("DELETE FROM tblWishlist WHERE UserID = ? AND ProductID = ?");
    $stmt->execute([$_SESSION['user_id'], $productId]);
    header("Location: wishlist.php");
    exit();
}

// Add to cart from wishlist
if (isset($_GET['add_to_cart'])) {
    $productId = (int)$_GET['add_to_cart'];

    // Fetch product details
    $stmt = $pdo->prepare("SELECT ProductID, ProductName, Price, ImagePath FROM tblProducts WHERE ProductID = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
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

        // Remove the product from the wishlist
        $stmt = $pdo->prepare("DELETE FROM tblWishlist WHERE UserID = ? AND ProductID = ?");
        $stmt->execute([$_SESSION['user_id'], $productId]);

        header("Location: wishlist.php");
        exit();
    }
}

// Fetch wishlist items
$stmt = $pdo->prepare("
    SELECT p.ProductID, p.ProductName, p.Price, p.ImagePath 
    FROM tblProducts p
    JOIN tblWishlist w ON p.ProductID = w.ProductID
    WHERE w.UserID = ?
");
$stmt->execute([$_SESSION['user_id']]);
$wishlistItems = $stmt->fetchAll();

require_once '../includes/header.php';
?>

<h2>Your Wishlist</h2>

<?php if (empty($wishlistItems)): ?>
    <p>No items in your wishlist.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wishlistItems as $item): ?>
                <tr>
                    <td><img src="../assets/images/products/<?php echo htmlspecialchars($item['ImagePath']); ?>" alt="<?php echo htmlspecialchars($item['ProductName']); ?>" width="50"></td>
                    <td><?php echo htmlspecialchars($item['ProductName']); ?></td>
                    <td><?php echo formatPrice($item['Price']); ?></td>
                    <td>
                        <a href="?remove=<?php echo $item['ProductID']; ?>" class="btn">Remove</a>
                        <a href="?add_to_cart=<?php echo $item['ProductID']; ?>" class="btn">Add to Cart</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>