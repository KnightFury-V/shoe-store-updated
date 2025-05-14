<?php
require_once '../includes/auth_user.php';
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/csrf.php';

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM tblUsers WHERE UserID = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit();
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    verify_csrf();
    $name = trim($_POST['fullname']);
    $stmt = $pdo->prepare("UPDATE tblUsers SET FullName = ? WHERE UserID = ?");
    $stmt->execute([$name, $_SESSION['user_id']]);
    header("Location: profile.php");
    exit;
}

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    verify_csrf();
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    if (!password_verify($current_password, $user['PasswordHash'])) {
        $error = "Current password is incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New passwords do not match.";
    } else {
        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE tblUsers SET PasswordHash = ? WHERE UserID = ?");
        $stmt->execute([$hashed_password, $_SESSION['user_id']]);
        $success = "Password updated successfully.";
    }
}
?>

<h2>Your Profile</h2>

<!-- Display Profile Update Form -->
<form method="POST">
  <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
  <label>Full Name:
    <input name="fullname" value="<?= htmlspecialchars($user['FullName']) ?>" required>
  </label><br>
  <label>Email:
    <input value="<?= htmlspecialchars($user['Email']) ?>" disabled>
  </label><br>
  <button type="submit" name="update_profile">Update Profile</button>
</form>

<hr>

<!-- Display Change Password Form -->
<h3>Change Password</h3>
<?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <p style="color:green;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>
<form method="POST">
  <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
  <label>Current Password:
    <input type="password" name="current_password" required>
  </label><br>
  <label>New Password:
    <input type="password" name="new_password" required>
  </label><br>
  <label>Confirm New Password:
    <input type="password" name="confirm_password" required>
  </label><br>
  <button type="submit" name="change_password">Change Password</button>
</form>