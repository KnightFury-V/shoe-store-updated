<?php

require_once 'config.php';
require_once 'database.php';
function getProducts($search = '', $category = '', $minPrice = '', $maxPrice = '', $limit = 12, $offset = 0) {
    global $pdo;

    $query = "SELECT p.*, c.CategoryName AS category_name 
              FROM tblProducts p
              LEFT JOIN tblCategories c ON p.CategoryID = c.CategoryID
              WHERE p.Stock > 0";

    $params = [];

    if (!empty($search)) {
        $query .= " AND p.ProductName LIKE ?";
        $params[] = "%$search%";
    }
    if (!empty($category)) {
        $query .= " AND p.CategoryID = ?";
        $params[] = $category;
    }
    if ($minPrice !== '') {
        $query .= " AND p.Price >= ?";
        $params[] = $minPrice;
    }
    if ($maxPrice !== '') {
        $query .= " AND p.Price <= ?";
        $params[] = $maxPrice;
    }

    // Embed LIMIT and OFFSET directly into the query
    $query .= " ORDER BY p.ProductID DESC LIMIT $limit OFFSET $offset";

    // Debugging: Output the query and parameters

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function countProducts($search = '', $category = '', $minPrice = '', $maxPrice = '') {
    global $pdo;

    $sql = "SELECT COUNT(*) FROM tblProducts WHERE Stock > 0"; // Ensure only products with stock are counted
    $params = [];

    if (!empty($search)) {
        $sql .= " AND ProductName LIKE ?";
        $params[] = "%$search%";
    }
    if (!empty($category)) {
        $sql .= " AND CategoryID = ?";
        $params[] = $category;
    }
    if ($minPrice !== '') {
        $sql .= " AND Price >= ?";
        $params[] = $minPrice;
    }
    if ($maxPrice !== '') {
        $sql .= " AND Price <= ?";
        $params[] = $maxPrice;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
}

function getCategories() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM tblCategories ORDER BY CategoryName");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function formatPrice($price) {
    return '$' . number_format($price, 2);
}
function getAdminByEmail($email) {
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT a.AdminID, a.FullName, u.PasswordHash 
        FROM tblAdmins a 
        JOIN tblUsers u ON a.UserID = u.UserID 
        WHERE u.Email = ?
    ");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getAllProducts() {
    global $pdo;
    $sql = "SELECT p.*, c.CategoryName 
            FROM tblProducts p 
            JOIN tblCategories c ON p.CategoryID = c.CategoryID";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function getAllProductsWithCategory() {
    global $pdo;
    $sql = "SELECT p.*, c.CategoryName 
            FROM tblProducts p 
            JOIN tblCategories c ON p.CategoryID = c.CategoryID 
            ORDER BY p.ProductID DESC";
    return $pdo->query($sql)->fetchAll();
}
function logAdminAction($adminId, $action) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO tblAdminLogs (AdminID, Action, Timestamp) VALUES (?, ?, NOW())");
    $stmt->execute([$adminId, $action]);
}




