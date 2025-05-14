<?php
require_once 'includes/database.php';

$query = $_GET['q'] ?? '';
$category = $_GET['category'] ?? '';

$sql = "SELECT * FROM tblProducts WHERE 1=1";
$params = [];

if ($query !== '') {
    $sql .= " AND ProductName LIKE ?";
    $params[] = "%$query%";
}
if ($category !== '') {
    $sql .= " AND CategoryID = ?";
    $params[] = $category;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();

// Fetch categories for filter dropdown
$cats = $pdo->query("SELECT * FROM tblCategories")->fetchAll();
?>

<h2>Search Products</h2>
<form method="GET">
    <input type="text" name="q" placeholder="Search..." value="<?= htmlspecialchars($query) ?>">
    <select name="category">
        <option value="">All Categories</option>
        <?php foreach ($cats as $cat): ?>
            <option value="<?= $cat['CategoryID'] ?>" <?= $cat['CategoryID'] == $category ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['CategoryName']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Search</button>
</form>

<?php if ($results): ?>
    <ul>
        <?php foreach ($results as $prod): ?>
            <li>
                <?= htmlspecialchars($prod['ProductName']) ?> - $<?= $prod['Price'] ?>
                <a href="products/product.php?id=<?= $prod['ProductID'] ?>">View</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>
