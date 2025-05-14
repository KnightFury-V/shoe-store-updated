<?php
/**
 * Homepage - displays product catalog with search and filtering options
 * 
 * Shows featured products with pagination and category filtering
 * 
 * @package ShoeStore
 */

require_once 'includes/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

// Pagination settings
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Filter parameters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$minPrice = $_GET['min_price'] ?? '';
$maxPrice = $_GET['max_price'] ?? '';

// Get products and counts
$products = getProducts($search, $category, $minPrice, $maxPrice, $limit, $offset);
$totalProducts = countProducts($search, $category, $minPrice, $maxPrice);
$totalPages = ceil($totalProducts / $limit);

// Get categories for filter dropdown
$categories = getCategories();

// Page title
$pageTitle = 'Home';
require_once 'includes/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <h1>Step Into Style</h1>
        <p>Discover our latest collection of premium shoes</p>
        <a href="#products" class="btn">Shop Now</a>
    </div>
</section>

<section class="search-filters">
    <form method="get" action="">
        <div class="search-bar">
            <input type="text" name="search" placeholder="Search shoes..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </div>
        <div class="filters">
            <select name="category">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['CategoryID']; ?>" <?php echo $category == $cat['CategoryID'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['CategoryName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="number" name="min_price" placeholder="Min price" value="<?php echo htmlspecialchars($minPrice); ?>">
            <input type="number" name="max_price" placeholder="Max price" value="<?php echo htmlspecialchars($maxPrice); ?>">
            <button type="submit" class="btn">Filter</button>
            <?php if ($search || $category || $minPrice || $maxPrice): ?>
                <a href="index.php" class="btn">Clear Filters</a>
            <?php endif; ?>
        </div>
    </form>
</section>

<section id="products" class="products">
    <h2>Our Collection</h2>
    <?php if (empty($products)): ?>
        <p class="no-results">No products found. Try adjusting your search filters.</p>
    <?php else: ?>
        <div class="product-grid">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
    <div class="product-image">
        <img src="assets/images/products/<?php echo htmlspecialchars($product['ImagePath']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
        <div class="product-overlay">
            <a href="./products/product.php?id=<?php echo $product['ProductID']; ?>" class="btn">View Details</a>
            <button class="btn add-to-cart" data-id="<?php echo $product['ProductID']; ?>">Add to Cart</button>
            <a href="user/wishlist.php?add=<?php echo $product['ProductID']; ?>" class="btn">Add to Wishlist</a>
        </div>
    </div>
    <div class="product-info">
        <h3><?php echo htmlspecialchars($product['ProductName']); ?></h3>
        <span class="price"><?php echo formatPrice($product['Price']); ?></span>
        <span class="category"><?php echo htmlspecialchars($product['category_name']); ?></span>
    </div>
</div>
    <?php endforeach; ?>
</div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>" class="page-link">&laquo; Previous</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>" class="page-link <?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
                
                <?php if ($page < $totalPages): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>" class="page-link">Next &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</section>

<?php
require_once 'includes/footer.php';
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');
            
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ productId }),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>