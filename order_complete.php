<?php
$orderId = $_GET['order_id'] ?? null;
?>
<h2>Order Completed</h2>
<p>Thank you! Your order ID is: <strong><?= htmlspecialchars($orderId) ?></strong></p>
<a href="index.php">Back to Home</a>
