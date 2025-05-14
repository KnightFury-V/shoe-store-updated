<?php
require_once '../includes/auth.php';
require_admin();
require_once '../includes/config.php';
require_once '../includes/database.php';

$products = $pdo->query(
    "SELECT p.*, c.CategoryName 
     FROM tblProducts p 
     LEFT JOIN tblCategories c ON p.CategoryID = c.CategoryID
     ORDER BY p.ProductID DESC"
)->fetchAll();


if (!empty($_SESSION['success_message'])) {
    echo "<p class='success'>" . htmlspecialchars($_SESSION['success_message']) . "</p>";
    unset($_SESSION['success_message']);
}

if (!empty($_SESSION['error_message'])) {
    echo "<p class='error'>" . htmlspecialchars($_SESSION['error_message']) . "</p>";
    unset($_SESSION['error_message']);
}

include 'admin_header.php';
?>
<h2>Manage Products</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>

            <tr>
                <td><?= $product['ProductID'] ?></td>
                <td><?= htmlspecialchars($product['ProductName']) ?></td>
                <td><?= htmlspecialchars($product['CategoryName']) ?></td>
                <td>$<?= number_format($product['Price'], 2) ?></td>
                <td><?= $product['Stock'] ?></td>
                <td>
                    <a href="../admin/edit_product.php?id=<?= $product['ProductID'] ?>" class="btn">Edit</a>
                    <a href="../admin/delete_product.php?id=<?= $product['ProductID'] ?>" class="btn btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <a href="../admin/add_product.php?id=<?= $product['ProductID'] ?>" class="btn">Add Product</a>

</table>
<?php include '../includes/footer.php'; ?>