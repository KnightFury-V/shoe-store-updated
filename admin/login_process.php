<?php
require_once '../includes/config.php';
require_once '../includes/database.php';

session_start();

// Verify CSRF token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['admin_login_error'] = "Invalid CSRF token.";
    header("Location: /shoe-store/admin/login.php");
    exit();
}

// Process login
$email = trim($_POST['email']);
$password = $_POST['password'];

if (!$email || !$password) {
    $_SESSION['admin_login_error'] = "Please enter both email and password.";
    header("Location: /shoe-store/admin/login.php");
    exit();
}

// Fetch admin details
$stmt = $pdo->prepare("
    SELECT a.AdminID, a.FullName AS AdminFullName, u.PasswordHash 
    FROM tblAdmins a 
    JOIN tblUsers u ON a.UserID = u.UserID 
    WHERE u.Email = ?
");
$stmt->execute([$email]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($password, $admin['PasswordHash'])) {
    // Login successful
    $_SESSION['admin_id'] = $admin['AdminID'];
    $_SESSION['admin_name'] = $admin['AdminFullName'];
    header("Location: /shoe-store/admin/dashboard.php");
    exit();
} else {
    // Login failed
    $_SESSION['admin_login_error'] = "Invalid email or password.";
    header("Location: /shoe-store/admin/login.php");
    exit();
}
?>