<?php
$page_title = 'LG Cool Store - Streetwear Essentials';
$page_description = 'Shop affordable streetwear essentials including caps, shoes, and accessories.';

include 'parts/functions.php';
include 'parts/meta.php';
include 'parts/header.php';

$featured_products = getFeaturedProducts(4);
$categories = getCategories();
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Fall Collection 2025</h1>
            <p>Cozy styles. Crisp prices.</p>
            <div class="hero-actions">
                <a href="products.php" class="btn btn-primary">Shop Now</a>
                <a href="about.php" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
    </div>
</section>

<!-- Promo Banner -->
<section class="promo-banner">
    <div class="container">
        <p>🎉 Free shipping on orders over $75 • Free returns within 30 days • <a href="sale.php">Check out our sale items!</a></p>
    </div>
</section>

<!-- Category Filters -->
<section class="category-section">
    <div class="container">
        <h2>Shop by Category</h2>
        <div class="category-filters">
            <?php foreach ($categories as $cat_key => $cat_name): ?>
                <a href="products.php?category=<?= $cat_key ?>" class="category-pill">
                    <?= e($cat_name) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products">
    <div class="container">
        <h2>Featured Products</h2>
        <div class="product-grid">
            <?php foreach ($featured_products as $product): ?>
                <div class="product-card" data-id="<?= $product['id'] ?>">
                    <a href="product_detail.php?id=<?= $product['id'] ?>" class="product-image">
                        <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
                        <?php if ($product['on_sale']): ?>
                            <span class="sale-badge">Sale</span>
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
                        <button class="btn btn-primary add-to-cart" data-id="<?= $product['id'] ?>">
                            Add to Cart
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center">
            <a href="products.php" class="btn btn-secondary">View All Products</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <h3>🚚 Free Shipping</h3>
                <p>On orders over $75</p>
            </div>
            <div class="feature-card">
                <h3>↩️ Easy Returns</h3>
                <p>30-day return policy</p>
            </div>
            <div class="feature-card">
                <h3>💳 Secure Payment</h3>
                <p>SSL encrypted checkout</p>
            </div>
            <div class="feature-card">
                <h3>⭐ Quality Guaranteed</h3>
                <p>Premium materials</p>
            </div>
        </div>
    </div>
</section>

<?php include 'parts/footer.php'; ?>