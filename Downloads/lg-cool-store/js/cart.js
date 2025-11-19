// Cart Page Functionality

// Sample product data (in a real app, this would come from the server)
const productData = {
    1: { id: 1, name: 'Classic Snapback Cap', price: 24.99, image: 'images/cap-black.jpg' },
    2: { id: 2, name: 'High-Top Sneakers', price: 69.99, salePrice: 69.99, image: 'images/shoe-white.jpg' },
    3: { id: 3, name: 'Canvas Tote Bag', price: 19.99, image: 'images/bag-beige.jpg' },
    4: { id: 4, name: 'Wool Beanie', price: 22.99, salePrice: 17.99, image: 'images/beanie-grey.jpg' },
    5: { id: 5, name: 'Low-Top Sneakers', price: 69.99, image: 'images/shoe-black.jpg' },
    6: { id: 6, name: 'Leather Backpack', price: 89.99, salePrice: 74.99, image: 'images/backpack-brown.jpg' }
};

document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on cart or checkout page
    if (document.getElementById('cart-items-container')) {
        renderCart();
    }
    
    if (document.getElementById('checkoutCartItems')) {
        renderCheckoutCart();
    }
    
    // Promo code
    const applyPromoBtn = document.getElementById('applyPromo');
    if (applyPromoBtn) {
        applyPromoBtn.addEventListener('click', applyPromoCode);
    }
});

function getCart() {
    return JSON.parse(localStorage.getItem('cart') || '[]');
}

function saveCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function renderCart() {
    const cart = getCart();
    const container = document.getElementById('cart-items-container');
    const itemCount = document.getElementById('cart-item-count');
    
    if (cart.length === 0) {
        container.innerHTML = `
            <div class="empty-cart">
                <p>Your cart is empty.</p>
                <a href="products.php" class="btn btn-primary">Start Shopping</a>
            </div>
        `;
        updateCartTotals(0, 0, 0, 0);
        return;
    }
    
    let html = '';
    cart.forEach(item => {
        const product = productData[item.id];
        if (!product) return;
        
        const price = product.salePrice || product.price;
        const subtotal = price * item.quantity;
        
        html += `
            <div class="cart-item" data-id="${item.id}">
                <div class="cart-item-image">
                    <img src="${product.image}" alt="${product.name}">
                </div>
                <div class="cart-item-details">
                    <h3>${product.name}</h3>
                    <p class="item-price">$${price.toFixed(2)}</p>
                </div>
                <div class="cart-item-quantity">
                    <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">−</button>
                    <span>${item.quantity}</span>
                    <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                </div>
                <div class="cart-item-total">
                    <p>$${subtotal.toFixed(2)}</p>
                </div>
                <button class="remove-item" onclick="removeFromCart(${item.id})" aria-label="Remove item">✕</button>
            </div>
        `;
    });
    
    container.innerHTML = html;
    if (itemCount) {
        itemCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
    }
    
    calculateTotals();
}

function updateQuantity(productId, change) {
    const cart = getCart();
    const item = cart.find(i => i.id == productId);
    
    if (item) {
        item.quantity += change;
        if (item.quantity <= 0) {
            removeFromCart(productId);
            return;
        }
        saveCart(cart);
        renderCart();
    }
}

function removeFromCart(productId) {
    let cart = getCart();
    cart = cart.filter(item => item.id != productId);
    saveCart(cart);
    renderCart();
    
    // Update cart count in header
    if (typeof updateCartCount === 'function') {
        updateCartCount();
    }
}

function calculateTotals() {
    const cart = getCart();
    let subtotal = 0;
    
    cart.forEach(item => {
        const product = productData[item.id];
        if (product) {
            const price = product.salePrice || product.price;
            subtotal += price * item.quantity;
        }
    });
    
    const shipping = subtotal >= 75 ? 0 : 0; // Free shipping over $75
    const tax = subtotal * 0.08; // 8% tax
    const discount = parseFloat(localStorage.getItem('cartDiscount') || '0');
    const total = subtotal + shipping + tax - discount;
    
    updateCartTotals(subtotal, shipping, tax, total, discount);
}

function updateCartTotals(subtotal, shipping, tax, total, discount = 0) {
    const elements = {
        subtotal: document.getElementById('cart-subtotal'),
        shipping: document.getElementById('cart-shipping'),
        tax: document.getElementById('cart-tax'),
        total: document.getElementById('cart-total'),
        discount: document.getElementById('cart-discount'),
        discountRow: document.getElementById('discountRow'),
        checkoutSubtotal: document.getElementById('checkoutSubtotal'),
        checkoutShipping: document.getElementById('checkoutShipping'),
        checkoutTax: document.getElementById('checkoutTax'),
        checkoutTotal: document.getElementById('checkoutTotal')
    };
    
    if (elements.subtotal) elements.subtotal.textContent = `$${subtotal.toFixed(2)}`;
    if (elements.shipping) elements.shipping.textContent = shipping === 0 ? 'FREE' : `$${shipping.toFixed(2)}`;
    if (elements.tax) elements.tax.textContent = `$${tax.toFixed(2)}`;
    if (elements.total) elements.total.textContent = `$${total.toFixed(2)}`;
    
    if (discount > 0 && elements.discount) {
        elements.discount.textContent = `-$${discount.toFixed(2)}`;
        if (elements.discountRow) elements.discountRow.style.display = 'flex';
    }
    
    // Checkout page
    if (elements.checkoutSubtotal) elements.checkoutSubtotal.textContent = `$${subtotal.toFixed(2)}`;
    if (elements.checkoutShipping) elements.checkoutShipping.textContent = shipping === 0 ? 'FREE' : `$${shipping.toFixed(2)}`;
    if (elements.checkoutTax) elements.checkoutTax.textContent = `$${tax.toFixed(2)}`;
    if (elements.checkoutTotal) elements.checkoutTotal.textContent = `$${total.toFixed(2)}`;
}

function applyPromoCode() {
    const promoInput = document.getElementById('promoCode');
    const code = promoInput.value.trim().toUpperCase();
    
    const validCodes = {
        'SAVE10': 10,
        'SAVE20': 20,
        'WELCOME': 5
    };
    
    if (validCodes[code]) {
        localStorage.setItem('cartDiscount', validCodes[code]);
        alert(`Promo code applied! You saved $${validCodes[code]}`);
        calculateTotals();
    } else {
        alert('Invalid promo code');
    }
}

function renderCheckoutCart() {
    const cart = getCart();
    const container = document.getElementById('checkoutCartItems');
    
    if (!container) return;
    
    let html = '';
    cart.forEach(item => {
        const product = productData[item.id];
        if (!product) return;
        
        const price = product.salePrice || product.price;
        
        html += `
            <div class="checkout-item">
                <img src="${product.image}" alt="${product.name}">
                <div class="checkout-item-info">
                    <p>${product.name}</p>
                    <p>Qty: ${item.quantity}</p>
                </div>
                <p class="checkout-item-price">$${(price * item.quantity).toFixed(2)}</p>
            </div>
        `;
    });
    
    container.innerHTML = html;
    calculateTotals();
}

// Add styles for cart items
const cartStyles = document.createElement('style');
cartStyles.textContent = `
    .cart-item {
        display: grid;
        grid-template-columns: 100px 1fr auto auto auto;
        gap: 1.5rem;
        align-items: center;
        padding: 1.5rem;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .cart-item-image img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 0.5rem;
    }
    
    .cart-item-details h3 {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }
    
    .item-price {
        color: #64748b;
        font-weight: 600;
    }
    
    .cart-item-quantity {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: #f8fafc;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
    }
    
    .qty-btn {
        background: white;
        border: 1px solid #e2e8f0;
        width: 2rem;
        height: 2rem;
        border-radius: 0.25rem;
        cursor: pointer;
        font-size: 1.1rem;
        transition: all 0.2s;
    }
    
    .qty-btn:hover {
        background: #2563eb;
        color: white;
        border-color: #2563eb;
    }
    
    .cart-item-total {
        font-weight: 700;
        font-size: 1.25rem;
        min-width: 100px;
        text-align: right;
    }
    
    .remove-item {
        background: none;
        border: none;
        color: #ef4444;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0.5rem;
        transition: transform 0.2s;
    }
    
    .remove-item:hover {
        transform: scale(1.2);
    }
    
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-cart p {
        font-size: 1.25rem;
        color: #64748b;
        margin-bottom: 2rem;
    }
    
    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 2rem;
        margin: 2rem 0;
    }
    
    .cart-summary {
        background: #f8fafc;
        padding: 2rem;
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
        height: fit-content;
        position: sticky;
        top: 100px;
    }
    
    .cart-summary h3 {
        margin-bottom: 1.5rem;
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .summary-divider {
        height: 1px;
        background: #cbd5e1;
        margin: 1rem 0;
    }
    
    .total-row {
        font-size: 1.25rem;
        font-weight: 700;
        border-bottom: none;
        padding: 1rem 0;
    }
    
    .free-shipping {
        color: #10b981;
        font-weight: 600;
    }
    
    .discount-row {
        color: #10b981;
    }
    
    .promo-code-section {
        display: flex;
        gap: 0.5rem;
        margin: 1rem 0;
    }
    
    .promo-code-section input {
        flex: 1;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
    }
    
    .shipping-notice {
        margin-top: 1rem;
        padding: 1rem;
        background: #dbeafe;
        border-radius: 0.5rem;
        color: #1e40af;
        text-align: center;
    }
    
    .checkout-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .checkout-item img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 0.5rem;
    }
    
    .checkout-item-info {
        flex: 1;
    }
    
    .checkout-item-info p {
        margin: 0.25rem 0;
    }
    
    .checkout-item-price {
        font-weight: 700;
    }
    
    @media (max-width: 968px) {
        .cart-layout {
            grid-template-columns: 1fr;
        }
        
        .cart-item {
            grid-template-columns: 80px 1fr;
            gap: 1rem;
        }
        
        .cart-item-quantity,
        .cart-item-total {
            grid-column: 2;
        }
    }
`;
document.head.appendChild(cartStyles);
