<?php
include 'parts/functions.php';

// Get $_GET parameters
$category = $_GET['category'] ?? 'all';
$sort_by = $_GET['sort'] ?? 'featured';
$search = $_GET['search'] ?? '';

// Page title based on category
$category_names = getCategories();
$page_title = ($category !== 'all') 
    ? $category_names[$category] . ' - LG Cool Store' 
    : 'Shop All Products - LG Cool Store';

include 'parts/meta.php';
include 'parts/header.php';

// Get and filter products
$products = getProductsByCategory($category);

// Search filter
if (!empty($search)) {
    $products = array_filter($products, function($product) use ($search) {
        return stripos($product['name'], $search) !== false || 
               stripos($product['description'], $search) !== false;
    });
}

// Sort products
$products = sortProducts($products, $sort_by);
$product_count = count($products);
?>

<section class="page-header">
    <div class="container">
        <h1><?= e($category_names[$category]) ?></h1>
        <nav class="breadcrumb">
            <a href="index.php">Home</a> / <span>Shop</span>
            <?php if ($category !== 'all'): ?>
                / <span><?= e($category_names[$category]) ?></span>
            <?php endif; ?>
        </nav>
    </div>
</section>

<section class="products-section">
    <div class="container">
        <!-- Toolbar: Filters & Sort -->
        <div class="products-toolbar">
            <div class="toolbar-left">
                <p class="results-count"><?= $product_count ?> product<?= $product_count !== 1 ? 's' : '' ?> found</p>
            </div>
            
            <div class="toolbar-right">
                <div class="sort-dropdown">
                    <label for="sortProducts">Sort by:</label>
                    <select id="sortProducts" onchange="window.location.href=updateQueryParam('sort', this.value)">
                        <option value="featured" <?= $sort_by === 'featured' ? 'selected' : '' ?>>Featured</option>
                        <option value="price-low" <?= $sort_by === 'price-low' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price-high" <?= $sort_by === 'price-high' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="name" <?= $sort_by === 'name' ? 'selected' : '' ?>>Name: A to Z</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Category Filters -->
        <div class="category-filters">
            <?php foreach ($category_names as $cat_key => $cat_name): ?>
                <a href="products.php?category=<?= $cat_key ?><?= !empty($search) ? '&search=' . urlencode($search) : '' ?>" 
                   class="category-pill <?= $category === $cat_key ? 'active' : '' ?>">
                    <?= e($cat_name) ?>
                </a>
            <?php endforeach; ?>
        </div>
        
        <!-- Products Grid -->
        <?php if (empty($products)): ?>
            <div class="no-results">
                <p>No products found<?= !empty($search) ? ' for "' . e($search) . '"' : '' ?>.</p>
                <a href="products.php" class="btn btn-primary">View All Products</a>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="product_detail.php?id=<?= $product['id'] ?>" class="product-image">
                            <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
                            <?php if ($product['on_sale']): ?>
                                <span class="sale-badge">-<?= getDiscountPercent($product['price'], $product['sale_price']) ?>%</span>
                            <?php endif; ?>
                            <button class="favorite-btn" data-id="<?= $product['id'] ?>" onclick="event.preventDefault();">♥</button>
                        </a>
                        <div class="product-info">
                            <h3><a href="product_detail.php?id=<?= $product['id'] ?>"><?= e($product['name']) ?></a></h3>
                            <p class="category"><?= ucfirst($product['category']) ?></p>
                            <div class="price-container">
                                <?php if ($product['sale_price']): ?>
                                    <span class="price-original"><?= formatPrice($product['price']) ?></span>
                                    <span class="price-sale"><?= formatPrice($product['sale_price']) ?></span>
                                <?php else: ?>
                                    <span class="price"><?= formatPrice($product['price']) ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="stock <?= $product['stock'] < 10 ? 'low-stock' : '' ?>">
                                <?= $product['stock'] > 0 ? "✓ In Stock ({$product['stock']} available)" : '✗ Out of Stock' ?>
                            </p>
                            <button class="btn btn-primary add-to-cart" data-id="<?= $product['id'] ?>">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
function updateQueryParam(key, value) {
    const url = new URL(window.location);
    url.searchParams.set(key, value);
    return url.toString();
}
</script>

<?php include 'parts/footer.php'; ?>