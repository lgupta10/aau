<?php
include 'parts/functions.php';

// Get product ID from $_GET
$product_id = $_GET['id'] ?? null;

if (!$product_id) {
    header('Location: products.php');
    exit;
}

$product = getProductById($product_id);

if (!$product) {
    header('Location: products.php');
    exit;
}

$page_title = e($product['name']) . ' - LG Cool Store';
$page_description = e($product['description']);

include 'parts/meta.php';
include 'parts/header.php';

// Get related products (same category, different ID)
$related_products = array_filter(getProductsByCategory($product['category']), function($p) use ($product_id) {
    return $p['id'] != $product_id;
});
$related_products = array_slice($related_products, 0, 4);
?>

<section class="page-header">
    <div class="container">
        <nav class="breadcrumb">
            <a href="index.php">Home</a> / 
            <a href="products.php">Shop</a> / 
            <a href="products.php?category=<?= $product['category'] ?>"><?= ucfirst($product['category']) ?></a> / 
            <span><?= e($product['name']) ?></span>
        </nav>
    </div>
</section>

<section class="product-detail">
    <div class="container">
        <div class="product-layout">
            <!-- Product Images -->
            <div class="product-images">
                <div class="main-image">
                    <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>" id="mainImage">
                    <?php if ($product['on_sale']): ?>
                        <span class="sale-badge-large">-<?= getDiscountPercent($product['price'], $product['sale_price']) ?>% OFF</span>
                    <?php endif; ?>
                </div>
                <div class="thumbnail-images">
                    <img src="<?= e($product['image']) ?>" alt="Thumbnail 1" class="thumbnail active" onclick="changeImage(this.src)">
                    <img src="<?= e($product['image']) ?>" alt="Thumbnail 2" class="thumbnail" onclick="changeImage(this.src)">
                    <img src="<?= e($product['image']) ?>" alt="Thumbnail 3" class="thumbnail" onclick="changeImage(this.src)">
                    <img src="<?= e($product['image']) ?>" alt="Thumbnail 4" class="thumbnail" onclick="changeImage(this.src)">
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="product-details">
                <h1><?= e($product['name']) ?></h1>
                
                <div class="product-rating">
                    <span class="stars">★★★★★</span>
                    <span class="rating-text">4.8/5.0 (124 reviews)</span>
                </div>
                
                <div class="price-container-large">
                    <?php if ($product['sale_price']): ?>
                        <span class="price-original-large"><?= formatPrice($product['price']) ?></span>
                        <span class="price-sale-large"><?= formatPrice($product['sale_price']) ?></span>
                        <span class="savings">You save <?= formatPrice($product['price'] - $product['sale_price']) ?>!</span>
                    <?php else: ?>
                        <span class="price-large"><?= formatPrice($product['price']) ?></span>
                    <?php endif; ?>
                </div>
                
                <p class="product-description"><?= e($product['description']) ?></p>
                
                <!-- Product Options -->
                <div class="product-options">
                    <!-- Color Selection -->
                    <div class="option-group">
                        <label>Color:</label>
                        <div class="color-options">
                            <?php foreach ($product['colors'] as $index => $color): ?>
                                <button class="color-swatch <?= $index === 0 ? 'active' : '' ?>" 
                                        data-color="<?= $color ?>"
                                        style="background: <?= $color ?>;"
                                        aria-label="<?= ucfirst($color) ?>">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Size Selection -->
                    <div class="option-group">
                        <label for="sizeSelect">Size:</label>
                        <select id="sizeSelect" name="size">
                            <?php foreach ($product['sizes'] as $size): ?>
                                <option value="<?= e($size) ?>"><?= e($size) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Quantity -->
                    <div class="option-group">
                        <label for="quantity">Quantity:</label>
                        <div class="quantity-selector">
                            <button class="qty-btn" id="decreaseQty">-</button>
                            <input type="number" value="1" min="1" max="<?= $product['stock'] ?>" id="quantity">
                            <button class="qty-btn" id="increaseQty">+</button>
                        </div>
                    </div>
                </div>
                
                <p class="stock-status <?= $product['stock'] < 10 ? 'low-stock' : 'in-stock' ?>">
                    <?php if ($product['stock'] > 0): ?>
                        ✓ In Stock (<?= $product['stock'] ?> available)
                    <?php else: ?>
                        ✗ Out of Stock
                    <?php endif; ?>
                </p>
                
                <!-- Action Buttons -->
                <div class="product-actions">
                    <button class="btn btn-primary btn-large add-to-cart" 
                            data-id="<?= $product['id'] ?>" 
                            data-name="<?= e($product['name']) ?>" 
                            data-price="<?= getFinalPrice($product) ?>">
                        Add to Cart
                    </button>
                    <button class="btn btn-secondary btn-large favorite-btn" data-id="<?= $product['id'] ?>">
                        ♥ Add to Favorites
                    </button>
                </div>
                
                <!-- Product Tabs -->
                <div class="product-tabs">
                    <div class="tab-buttons">
                        <button class="tab-btn active" data-tab="description">Description</button>
                        <button class="tab-btn" data-tab="specifications">Specifications</button>
                        <button class="tab-btn" data-tab="shipping">Shipping</button>
                        <button class="tab-btn" data-tab="reviews">Reviews (124)</button>
                    </div>
                    <div class="tab-content active" id="description">
                        <h3>Product Details</h3>
                        <p><?= e($product['description']) ?></p>
                        <ul>
                            <li>Premium quality materials</li>
                            <li>Durable construction for long-lasting wear</li>
                            <li>Comfortable fit for all-day use</li>
                            <li>Easy care and maintenance</li>
                        </ul>
                    </div>
                    <div class="tab-content" id="specifications">
                        <h3>Specifications</h3>
                        <table class="specs-table">
                            <tr>
                                <th>Category</th>
                                <td><?= ucfirst($product['category']) ?></td>
                            </tr>
                            <tr>
                                <th>Available Colors</th>
                                <td><?= implode(', ', array_map('ucfirst', $product['colors'])) ?></td>
                            </tr>
                            <tr>
                                <th>Available Sizes</th>
                                <td><?= implode(', ', $product['sizes']) ?></td>
                            </tr>
                            <tr>
                                <th>Stock Status</th>
                                <td><?= $product['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-content" id="shipping">
                        <h3>Shipping Information</h3>
                        <p><strong>Free Shipping:</strong> On orders over $75</p>
                        <p><strong>Standard Delivery:</strong> 5-7 business days</p>
                        <p><strong>Express Delivery:</strong> 2-3 business days (+$15.00)</p>
                        <p><strong>Overnight:</strong> Next business day (+$30.00)</p>
                        <h3>Returns</h3>
                        <p>30-day return policy. Items must be unused and in original packaging.</p>
                    </div>
                    <div class="tab-content" id="reviews">
                        <h3>Customer Reviews</h3>
                        <div class="review-summary">
                            <p>⭐⭐⭐⭐⭐ 4.8 out of 5</p>
                            <p>Based on 124 reviews</p>
                        </div>
                        <p>Customer reviews coming soon!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php if (!empty($related_products)): ?>
<section class="related-products">
    <div class="container">
        <h2>You May Also Like</h2>
        <div class="product-grid">
            <?php foreach ($related_products as $related): ?>
                <div class="product-card">
                    <a href="product_detail.php?id=<?= $related['id'] ?>" class="product-image">
                        <img src="<?= e($related['image']) ?>" alt="<?= e($related['name']) ?>">
                        <?php if ($related['on_sale']): ?>
                            <span class="sale-badge">Sale</span>
                        <?php endif; ?>
                    </a>
                    <div class="product-info">
                        <h3><a href="product_detail.php?id=<?= $related['id'] ?>"><?= e($related['name']) ?></a></h3>
                        <div class="price-container">
                            <?php if ($related['sale_price']): ?>
                                <span class="price-original"><?= formatPrice($related['price']) ?></span>
                                <span class="price-sale"><?= formatPrice($related['sale_price']) ?></span>
                            <?php else: ?>
                                <span class="price"><?= formatPrice($related['price']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
// Image gallery
function changeImage(src) {
    document.getElementById('mainImage').src = src;
    document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
    event.target.classList.add('active');
}

// Quantity controls
document.getElementById('decreaseQty').addEventListener('click', () => {
    const qty = document.getElementById('quantity');
    if (qty.value > 1) qty.value = parseInt(qty.value) - 1;
});

document.getElementById('increaseQty').addEventListener('click', () => {
    const qty = document.getElementById('quantity');
    const max = parseInt(qty.max);
    if (qty.value < max) qty.value = parseInt(qty.value) + 1;
});

// Color selection
document.querySelectorAll('.color-swatch').forEach(swatch => {
    swatch.addEventListener('click', () => {
        document.querySelectorAll('.color-swatch').forEach(s => s.classList.remove('active'));
        swatch.classList.add('active');
    });
});

// Tab switching
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const tabId = btn.dataset.tab;
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    });
});
</script>

<?php include 'parts/footer.php'; ?>