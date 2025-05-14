<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/auth_user.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch orders for the logged-in user
$stmt = $pdo->prepare("
    SELECT o.OrderID, o.TotalAmount, o.OrderDate
    FROM tblOrders o
    WHERE o.UserID = ?
    ORDER BY o.OrderDate DESC
");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';


?>

<h2>Your Orders</h2>

<?php if (empty($orders)): ?>
    <p>You have not placed any orders yet.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Products</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <?php
                // Fetch products for each order
                $stmt = $pdo->prepare("
                    SELECT p.ProductName, p.ImagePath, oi.Quantity, oi.PriceAtPurchase
                    FROM tblOrderItems oi
                    JOIN tblProducts p ON oi.ProductID = p.ProductID
                    WHERE oi.OrderID = ?
                ");
                $stmt->execute([$order['OrderID']]);
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <tr>
                    <td><?= htmlspecialchars($order['OrderID']) ?></td>
                    <td><?= htmlspecialchars($order['OrderDate']) ?></td>
                    <td><?= formatPrice($order['TotalAmount']) ?></td>
                    <td>
                        <?php foreach ($products as $product): ?>
                            <div class="product-item">
                                <img src="../assets/images/products/<?= htmlspecialchars($product['ImagePath']) ?>" alt="<?= htmlspecialchars($product['ProductName']) ?>" width="50">
                                <span><?= htmlspecialchars($product['ProductName']) ?> (x<?= $product['Quantity'] ?>)</span>
                            </div>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <a href="user_order_details.php?order_id=<?= $order['OrderID'] ?>" class="btn">View Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>