<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$categories = $pdo->query("SELECT * FROM tblCategories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['ProductName'];
    $desc = $_POST['Description'];
    $price = $_POST['Price'];
    $size = $_POST['Size'];
    $stock = $_POST['Stock'];
    $catId = $_POST['CategoryID'];
    $imagePath = $_POST['ImagePath']; // Get the image name directly from the input field

    $stmt = $pdo->prepare("INSERT INTO tblProducts (CategoryID, ProductName, Description, Price, Size, ImagePath, Stock) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$catId, $name, $desc, $price, $size, $imagePath, $stock]);

    header("Location: products.php");
    exit;
}

require_once '../admin/admin_header.php';
?>

<h2>Add Product</h2>
<form method="post">
    <label>Name:</label><input type="text" name="ProductName" required>
    <label>Description:</label><textarea name="Description" required></textarea>
    <label>Price:</label><input type="number" step="0.01" name="Price" required>
    <label>Size:</label><input type="text" name="Size">
    <label>Stock:</label><input type="number" name="Stock" required>
    <label>Category:</label>
    <select name="CategoryID" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['CategoryID'] ?>"><?= htmlspecialchars($cat['CategoryName']) ?></option>
        <?php endforeach; ?>
    </select>
    <label>Image Path:</label><input type="text" name="ImagePath" placeholder="e.g., product1.jpg" required>
    <button type="submit" class="btn">Add Product</button>
</form>

<?php require_once '../includes/footer.php'; ?>