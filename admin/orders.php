<?php
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';

$orders = $pdo->query(
    "SELECT o.*, u.FullName 
     FROM tblOrders o 
     LEFT JOIN tblUsers u ON o.UserID = u.UserID
     ORDER BY o.OrderDate DESC"
)->fetchAll();

include 'admin_header.php';
?>
<h2>Manage Orders</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Total</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['OrderID'] ?></td>
                <td><?= htmlspecialchars($order['FullName'] ?: 'Guest') ?></td>
                <td>$<?= number_format($order['TotalAmount'], 2) ?></td>
                <td><?= $order['OrderDate'] ?></td>
                <td><?= $order['Status'] ?></td>
                <td>
                    <a href="edit_order.php?id=<?= $order['OrderID'] ?>" class="btn">Edit</a>
                    <a href="delete_order.php?id=<?= $order['OrderID'] ?>" class="btn btn-danger" onclick="return confirm('Delete this order?')">Delete</a>
                    <a href="export_orders.php?order=<?= $order['OrderID'] ?>" class="btn">Export</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include '../includes/footer.php'; ?>