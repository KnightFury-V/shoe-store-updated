<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $name     = trim($_POST['fullname']);

    // Basic validation
    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT UserID FROM tblUsers WHERE Email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $errors[] = "Email is already registered.";
    }

    if (empty($errors)) {
        // Hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $stmt = $pdo->prepare("INSERT INTO tblUsers (Email, PasswordHash, FullName) VALUES (?, ?, ?)");
        $stmt->execute([$email, $hash, $name]);

        // Log them in
        $_SESSION['user_id'] = $pdo->lastInsertId();
        header("Location: ../index.php");
        exit();
    }
}
require_once '../includes/header.php';

?>
<h2>Register</h2>
<?php if (!empty($errors)): ?>
    <ul style="color:red;">
    <?php foreach ($errors as $e): ?>
        <li><?= htmlspecialchars($e) ?></li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
<form method="POST">
    <input type="text"  name="fullname" required placeholder="Full Name" value="<?= htmlspecialchars($name ?? '') ?>"><br>
    <input type="email" name="email"    required placeholder="Email"     value="<?= htmlspecialchars($email ?? '') ?>"><br>
    <input type="password" name="password" required placeholder="Password"><br>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login here</a>.</p>
