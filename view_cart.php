<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';
require_once 'includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<h2>Your Cart</h2>

<?php if (empty($cart)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart as $item): ?>
                <tr>
                    <td><img src="assets/images/products/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="50"></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo formatPrice($item['price']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo formatPrice($item['price'] * $item['quantity']); ?></td>
                    <td>
                        <a href="update_cart.php?action=remove&id=<?php echo $item['id']; ?>" class="btn">Remove</a>
                    </td>
                </tr>
                <?php $total += $item['price'] * $item['quantity']; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: <?php echo formatPrice($total); ?></h3>
    <a href="./checkout.php" class="btn">Proceed to Checkout</a>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>