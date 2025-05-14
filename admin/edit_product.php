<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$id = $_GET['id'] ?? null;
if (!$id) header('Location: products.php');

$categories = $pdo->query("SELECT * FROM tblCategories")->fetchAll();
$product = $pdo->prepare("SELECT * FROM tblProducts WHERE ProductID = ?");
$product->execute([$id]);
$data = $product->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['ProductName'];
    $desc = $_POST['Description'];
    $price = $_POST['Price'];
    $size = $_POST['Size'];
    $stock = $_POST['Stock'];
    $catId = $_POST['CategoryID'];
    $imagePath = $_POST['ImagePath']; // Get the image name directly from the input field

    $stmt = $pdo->prepare("UPDATE tblProducts SET CategoryID=?, ProductName=?, Description=?, Price=?, Size=?, ImagePath=?, Stock=? WHERE ProductID=?");
    $stmt->execute([$catId, $name, $desc, $price, $size, $imagePath, $stock, $id]);

    header("Location: products.php");
    exit;
}

require_once '../includes/header.php';
?>

<h2>Edit Product</h2>
<form method="post">
    <label>Name:</label><input type="text" name="ProductName" value="<?= htmlspecialchars($data['ProductName']) ?>" required>
    <label>Description:</label><textarea name="Description" required><?= htmlspecialchars($data['Description']) ?></textarea>
    <label>Price:</label><input type="number" step="0.01" name="Price" value="<?= $data['Price'] ?>" required>
    <label>Size:</label><input type="text" name="Size" value="<?= htmlspecialchars($data['Size']) ?>">
    <label>Stock:</label><input type="number" name="Stock" value="<?= $data['Stock'] ?>" required>
    <label>Category:</label>
    <select name="CategoryID" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['CategoryID'] ?>" <?= $data['CategoryID'] == $cat['CategoryID'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['CategoryName']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label>Image Path:</label><input type="text" name="ImagePath" value="<?= htmlspecialchars($data['ImagePath']) ?>" placeholder="e.g., product1.jpg" required>
    <button type="submit" class="btn">Update Product</button>
</form>

<?php require_once '../includes/footer.php'; ?>