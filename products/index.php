<?php
require_once '../includes/database.php';
$products = $pdo->query("SELECT * FROM tblProducts")->fetchAll();
?>
<h1>Product Catalog</h1>
<?php foreach ($products as $product): ?>
    <div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
        <h3><?= htmlspecialchars($product['ProductName']) ?></h3>
        <img src="../assets/images/products/<?= $product['ImagePath'] ?>" width="100" alt="">
        <p>Price: $<?= $product['Price'] ?></p>
        <p><?= htmlspecialchars($product['Description']) ?></p>
        <a href="product.php?id=<?= $product['ProductID'] ?>">View Details</a>
    </div>
<?php endforeach; ?>
