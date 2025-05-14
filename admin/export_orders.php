<?php
require_once '../includes/database.php';
require_once '../includes/auth.php';

$orderId = (int)($_GET['order'] ?? 0);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="order_'.$orderId.'.csv"');

$out = fopen('php://output','w');
fputcsv($out, ['OrderItemID','ProductName','Quantity','PriceAtPurchase']);

$stmt = $pdo->prepare(
  "SELECT oi.OrderItemID, p.ProductName, oi.Quantity, oi.PriceAtPurchase
     FROM tblOrderItems oi
     JOIN tblProducts p ON oi.ProductID = p.ProductID
     WHERE oi.OrderID = ?"
);
$stmt->execute([$orderId]);

while($row = $stmt->fetch(PDO::FETCH_NUM)) {
    fputcsv($out, $row);
}
fclose($out);
exit();
