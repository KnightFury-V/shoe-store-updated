<?php
require_once '../includes/config.php';
require_once '../includes/database.php';
require_once '../includes/csrf.php';
require_once '../includes/functions.php';
require_once '../includes/header.php';


$id = $_GET['id'] ?? null;
if (!$id) { echo "Invalid Product"; exit(); }

$stmt = $pdo->prepare("SELECT * FROM tblProducts WHERE ProductID = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) { echo "Product not found."; exit(); }
?>

<h2><?= htmlspecialchars($product['ProductName']) ?></h2>
<img src="../<?= $product['ImagePath'] ?>" width="200">
<p><?= $product['Description'] ?></p>
<p>Size: <?= $product['Size'] ?></p>
<p>Price: $<?= $product['Price'] ?></p>
<p>In Stock: <?= $product['Stock'] ?></p>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review'])) {
    verify_csrf();
    $rating = (int)$_POST['rating'];
    $text   = trim($_POST['text']);
    $stmt = $pdo->prepare(
        "INSERT INTO tblReviews (ProductID, UserID, Rating, ReviewText) 
         VALUES (?, ?, ?, ?)"
    );
    $stmt->execute([$id, $_SESSION['user_id'], $rating, $text]);
    header("Location: product.php?id=$id");
    exit;
}

// Fetch reviews
$revStmt = $pdo->prepare(
    "SELECT r.*, u.FullName FROM tblReviews r 
     JOIN tblUsers u ON r.UserID = u.UserID
     WHERE r.ProductID = ? 
     ORDER BY r.CreatedAt DESC"
);
$revStmt->execute([$id]);
$reviews = $revStmt->fetchAll();
?>

<!-- Review Form -->
<h3>Leave a Review</h3>
<form method="POST">
  <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
  <label>Rating:
    <select name="rating">
      <?php for ($i = 1; $i <= 5; $i++): ?>
        <option value="<?= $i ?>"><?= $i ?></option>
      <?php endfor; ?>
    </select>
  </label><br>
  <textarea name="text" required placeholder="Your review…"></textarea><br>
  <button type="submit" name="review">Submit Review</button>
</form>
<a href="../user/wishlist.php?add=<?php echo $product['ProductID']; ?>" class="btn">Add to Wishlist</a>
<!-- Display Reviews -->
<h3>Reviews</h3>
<?php if (!$reviews): ?>
  <p>No reviews yet.</p>
<?php else: ?>
  <?php foreach ($reviews as $r): ?>
    <div style="border:1px solid #ccc; padding:8px; margin:4px 0;">
      <strong><?= htmlspecialchars($r['FullName']) ?></strong> 
      (<?= $r['Rating'] ?>/5) at <?= $r['CreatedAt'] ?><br>
      <?= nl2br(htmlspecialchars($r['ReviewText'])) ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>