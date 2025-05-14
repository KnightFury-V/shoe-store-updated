<?php
//require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

$users = $pdo->query("SELECT * FROM tblUsers ORDER BY CreatedAt DESC")->fetchAll();
require_once '../admin/admin_header.php';
?>
<h2>Manage Users</h2>
<table>
  <tr><th>ID</th><th>Email</th><th>Name</th><th>Since</th><th>Action</th></tr>
  <?php foreach($users as $u): ?>
    <tr>
      <td><?= $u['UserID'] ?></td>
      <td><?= htmlspecialchars($u['Email']) ?></td>
      <td><?= htmlspecialchars($u['FullName']) ?></td>
      <td><?= $u['CreatedAt'] ?></td>
      <td>
        <a href="edit_user.php?id=<?= $u['UserID'] ?>" class="btn">Edit</a>
        <a href="delete_user.php?id=<?= $u['UserID'] ?>" class="btn btn-danger" onclick="return confirm('Delete user?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php require_once '../includes/footer.php'; ?>
