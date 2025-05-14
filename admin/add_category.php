<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['CategoryName']);

    if ($name !== '') {
        $stmt = $pdo->prepare("INSERT INTO tblCategories (CategoryName) VALUES (?)");
        $stmt->execute([$name]);
        header('Location: categories.php');
        exit;
    }
}

require_once '../admin/admin_header.php';
?>

<h2>Add New Category</h2>
<form method="post">
    <label>Category Name:</label>
    <input type="text" name="CategoryName" required>
    <button type="submit" class="btn">Add</button>
</form>

<?php require_once '../includes/footer.php'; ?>
