<?php
$page_title = 'LG Cool Store - Streetwear Essentials';
include 'parts/meta.php';
include 'parts/header.php';
include 'parts/functions.php';
?>
<?php
// FILE: index.php

// Set page-specific variables
$page_title = 'LG Cool Store - Streetwear Essentials';
$page_description = 'Shop affordable streetwear essentials including caps, shoes, and accessories.';

// Include shared header
include 'parts/meta.php';
include 'parts/header.php';
include 'parts/functions.php';
?>

<!-- Your existing hero section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Fall Collection 2025</h1>
            <p>Cozy styles. Crisp prices.</p>
            <a href="product_list.php" class="btn btn-primary">Shop Now</a>
        </div>
    </div>
</section>

<!-- Category filters -->
<section class="category-section">
    <div class="container">
        <div class="category-filters">
            <a href="product_list.php" class="category-pill active">All</a>
            <a href="product_list.php?category=caps" class="category-pill">Caps</a>
            <a href="product_list.php?category=shoes" class="category-pill">Shoes</a>
            <a href="product_list.php?category=accessories" class="category-pill">Accessories</a>
        </div>
    </div>
</section>

<!-- Featured Products - Now dynamically generated -->
<section class="featured-products">
    <div class="container">
        <h2>Featured Products</h2>
        <div class="product-grid">
            <?php 
            $featuredProducts = getFeaturedProducts();
            foreach ($featuredProducts as $product): 
            ?>
                <div class="product-card" data-id="<?= $product['id'] ?>">
                    <a href="product_detail.php?id=<?= $product['id'] ?>" class="product-image">
                        <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>">
                        <button class="favorite-btn" onclick="event.preventDefault();">♥</button>
                    </a>
                    <div class="product-info">
                        <h3><a href="product_detail.php?id=<?= $product['id'] ?>"><?= e($product['name']) ?></a></h3>
                        <p class="price"><?= formatPrice($product['price']) ?></p>
                        <button class="btn btn-primary add-to-cart" data-id="<?= $product['id'] ?>">
                            Add to Cart
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Your existing features section -->
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