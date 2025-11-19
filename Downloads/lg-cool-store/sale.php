<?php
include 'parts/functions.php';

$page_title = 'Sale - Up to 50% Off | LG Cool Store';
$page_description = 'Shop our sale items and save big on streetwear essentials!';

include 'parts/meta.php';
include 'parts/header.php';

$sale_products = getSaleProducts();
$sort_by = $_GET['sort'] ?? 'featured';
$sale_products = sortProducts($sale_products, $sort_by);
?>

<section class="page-header sale-header">
    <div class="container">
        <h1>🔥 Sale - Up to 50% Off</h1>
        <p>Limited time offers on selected items. Don't miss out!</p>
        <nav class="breadcrumb">
            <a href="index.php">Home</a> / <span>Sale</span>
        </nav>
    </div>
</section>

<section class="products-section">
    <div class="container">
        <!-- Toolbar -->
        <div class="products-toolbar">
            <div class="toolbar-left">
                <p class="results-count"><?= count($sale_products) ?> items on sale</p>
            </div>
            
            <div class="toolbar-right">
                <div class="sort-dropdown">
                    <label for="sortProducts">Sort by:</label>
                    <select id="sortProducts" onchange="window.location.href='sale.php?sort=' + this.value">
                        <option value="featured" <?= $sort_by === 'featured' ? 'selected' : '' ?>>Featured</option>
                        <option value="price-low" <?= $sort_by === 'price-low' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price-high" <?= $sort_by === 'price-high' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="name" <?= $sort_by === 'name' ? 'selected' : '' ?>>Name: A to Z</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Sale Products Grid -->
        <?php if (empty($sale_products)): ?>
            <div class="no-results">
                <p>No sale items available at this time. Check back soon!</p>
                <a href="products.php" class="btn btn-primary">Browse All Products</a>
            </div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($sale_products as $product): ?>
                    <div class="product-card sale-item">
                        <a href="product_detail.php?id=<?= $product['id'] ?>" class="product-image">
                            <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
                            <span class="sale-badge">-<?= getDiscountPercent($product['price'], $product['sale_price']) ?>%</span>
                            <button class="favorite-btn" data-id="<?= $product['id'] ?>" onclick="event.preventDefault();">♥</button>
                        </a>
                        <div class="product-info">
                            <h3><a href="product_detail.php?id=<?= $product['id'] ?>"><?= e($product['name']) ?></a></h3>
                            <p class="category"><?= ucfirst($product['category']) ?></p>
                            <div class="price-container">
                                <span class="price-original"><?= formatPrice($product['price']) ?></span>
                                <span class="price-sale"><?= formatPrice($product['sale_price']) ?></span>
                            </div>
                            <p class="savings-text">Save <?= formatPrice($product['price'] - $product['sale_price']) ?></p>
                            <p class="stock <?= $product['stock'] < 10 ? 'low-stock' : '' ?>">
                                <?= $product['stock'] > 0 ? "✓ In Stock ({$product['stock']} left)" : '✗ Out of Stock' ?>
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

<?php include 'parts/footer.php'; ?>