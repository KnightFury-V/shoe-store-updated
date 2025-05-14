<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';

$stmt = $pdo->query("SELECT * FROM tblCategories ORDER BY CategoryName ASC");
$categories = $stmt->fetchAll();

require_once '../admin/admin_header.php';
?>

<h2>Manage Categories</h2>
<a href="add_category.php" class="btn">Add Category</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['CategoryID'] ?></td>
                <td><?= htmlspecialchars($cat['CategoryName']) ?></td>
                <td>
                    <a href="edit_category.php?id=<?= $cat['CategoryID'] ?>" class="btn">Edit</a>
                    <a href="delete_category.php?id=<?= $cat['CategoryID'] ?>" class="btn btn-danger" onclick="return confirm('Delete this category?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../includes/footer.php'; ?>
