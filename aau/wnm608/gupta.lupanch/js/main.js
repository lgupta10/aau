// ================================
// Cart Page JavaScript
// ================================

document.addEventListener('DOMContentLoaded', function() {
  displayCart();
  updateCartSummary();
});

// ================================
// Display Cart Items
// ================================
function displayCart() {
  const cart = getCart();
  const cartContainer = document.getElementById('cart-items');
  
  if (!cartContainer) return;
  
  if (cart.length === 0) {
    cartContainer.innerHTML = `
      <div class="card soft" style="text-align: center; padding: 3em;">
        <h3>Your cart is empty 🛒</h3>
        <p class="muted">Add some cool items to get started!</p>
        <a href="index.html" class="form-button" style="display: inline-block; margin-top: 1em;">
          Continue Shopping
        </a>
      </div>
    `;
    return;
  }
  
  // Create cart items HTML
  let html = '<div class="cart-items-list">';
  
  cart.forEach((item, index) => {
    html += `
      <div class="card soft cart-item" data-index="${index}">
        <div class="display-flex flex-align-center" style="gap: 1.5em;">
          <div class="cart-item-image">
            <img src="${item.image || 'https://via.placeholder.com/100'}" alt="${item.name}">
          </div>
          <div class="flex-stretch">
            <h4 style="margin: 0 0 0.5em 0;">${item.name}</h4>
            <p class="muted" style="margin: 0;">${item.price}</p>
          </div>
          <div class="cart-item-quantity">
            <button class="qty-btn" onclick="updateQuantity(${index}, -1)">−</button>
            <span class="quantity">${item.quantity}</span>
            <button class="qty-btn" onclick="updateQuantity(${index}, 1)">+</button>
          </div>
          <div class="cart-item-total">
            <strong>${calculateItemTotal(item)}</strong>
          </div>
          <button class="remove-btn" onclick="removeFromCart(${index})" aria-label="Remove ${item.name}">
            ✕
          </button>
        </div>
      </div>
    `;
  });
  
  html += '</div>';
  cartContainer.innerHTML = html;
  
  // Add styles for cart items
  addCartStyles();
}

// ================================
// Cart Operations
// ================================
function getCart() {
  const cart = localStorage.getItem('lgstore_cart');
  return cart ? JSON.parse(cart) : [];
}

function saveCart(cart) {
  localStorage.setItem('lgstore_cart', JSON.stringify(cart));
}

function updateQuantity(index, change) {
  const cart = getCart();
  
  if (cart[index]) {
    cart[index].quantity += change;
    
    // Remove if quantity is 0
    if (cart[index].quantity <= 0) {
      cart.splice(index, 1);
      showNotification('Item removed from cart');
    } else {
      showNotification('Quantity updated');
    }
    
    saveCart(cart);
    displayCart();
    updateCartSummary();
  }
}

function removeFromCart(index) {
  const cart = getCart();
  const item = cart[index];
  
  cart.splice(index, 1);
  saveCart(cart);
  
  showNotification(`${item.name} removed from cart`);
  displayCart();
  updateCartSummary();
}

function clearCart() {
  if (confirm('Are you sure you want to clear your cart?')) {
    localStorage.removeItem('lgstore_cart');
    showNotification('Cart cleared!');
    displayCart();
    updateCartSummary();
  }
}

// ================================
// Cart Summary & Calculations
// ================================
function updateCartSummary() {
  const cart = getCart();
  const summaryContainer = document.getElementById('cart-summary');
  
  if (!summaryContainer) return;
  
  const subtotal = calculateSubtotal(cart);
  const tax = subtotal * 0.08; // 8% tax
  const shipping = subtotal > 75 ? 0 : 10; // Free shipping over $75
  const total = subtotal + tax + shipping;
  
  summaryContainer.innerHTML = `
    <div class="card soft">
      <h3>Order Summary</h3>
      <div class="summary-line">
        <span>Subtotal:</span>
        <span>${formatPrice(subtotal)}</span>
      </div>
      <div class="summary-line">
        <span>Tax (8%):</span>
        <span>${formatPrice(tax)}</span>
      </div>
      <div class="summary-line">
        <span>Shipping:</span>
        <span>${shipping === 0 ? 'FREE' : formatPrice(shipping)}</span>
      </div>
      ${shipping > 0 ? `<p class="muted" style="font-size: 0.85em; margin-top: 0.5em;">
        Add ${formatPrice(75 - subtotal)} more for free shipping!
      </p>` : ''}
      <hr style="margin: 1em 0; border: none; border-top: 1px solid var(--color-neutral-medium);">
      <div class="summary-line" style="font-size: 1.25em; font-weight: bold;">
        <span>Total:</span>
        <span>${formatPrice(total)}</span>
      </div>
      <button class="form-button" style="width: 100%; margin-top: 1.5em;" onclick="checkout()">
        Proceed to Checkout
      </button>
      <button class="form-button" style="width: 100%; margin-top: 0.5em; background: transparent; border: 1px solid var(--color-neutral-medium); color: var(--color-text);" onclick="clearCart()">
        Clear Cart
      </button>
    </div>
  `;
}

function calculateItemTotal(item) {
  const price = parseFloat(item.price.replace('$', ''));
  const total = price * item.quantity;
  return formatPrice(total);
}

function calculateSubtotal(cart) {
  return cart.reduce((sum, item) => {
    const price = parseFloat(item.price.replace('$', ''));
    return sum + (price * item.quantity);
  }, 0);
}

function formatPrice(amount) {
  return `$${amount.toFixed(2)}`;
}

// ================================
// Checkout
// ================================
function checkout() {
  const cart = getCart();
  
  if (cart.length === 0) {
    alert('Your cart is empty!');
    return;
  }
  
  // This is a placeholder - will be replaced with actual backend integration
  showNotification('🎉 Checkout feature coming soon!');
  
  console.log('Checkout data:', {
    items: cart,
    subtotal: calculateSubtotal(cart),
    timestamp: new Date().toISOString()
  });
  
  // In production, this would:
  // 1. Send cart data to backend
  // 2. Process payment
  // 3. Create order
  // 4. Clear cart
  // 5. Redirect to confirmation page
}

// ================================
// Notification System
// ================================
function showNotification(message, duration = 3000) {
  const existing = document.querySelector('.notification');
  if (existing) existing.remove();
  
  const notification = document.createElement('div');
  notification.className = 'notification';
  notification.textContent = message;
  notification.style.cssText = `
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: linear-gradient(135deg, #ffd166, #f4a261);
    color: #0a0a0a;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    z-index: 9999;
    animation: slideInUp 0.3s ease;
  `;
  
  document.body.appendChild(notification);
  
  setTimeout(() => {
    notification.style.animation = 'slideOutDown 0.3s ease';
    setTimeout(() => notification.remove(), 300);
  }, duration);
}

// ================================
// Cart Styles
// ================================
function addCartStyles() {
  if (document.getElementById('cart-styles')) return;
  
  const style = document.createElement('style');
  style.id = 'cart-styles';
  style.textContent = `
    .cart-items-list {
      display: flex;
      flex-direction: column;
      gap: 1em;
    }
    
    .cart-item-image {
      width: 100px;
      height: 100px;
      border-radius: 0.5em;
      overflow: hidden;
      flex-shrink: 0;
    }
    
    .cart-item-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .cart-item-quantity {
      display: flex;
      align-items: center;
      gap: 0.5em;
      background: var(--color-neutral-medium);
      padding: 0.5em;
      border-radius: 0.5em;
    }
    
    .qty-btn {
      background: var(--color-neutral-light);
      border: 1px solid var(--color-neutral-medium);
      color: var(--color-text);
      width: 32px;
      height: 32px;
      border-radius: 0.25em;
      cursor: pointer;
      font-size: 1.2em;
      font-weight: bold;
      transition: all 0.2s ease;
    }
    
    .qty-btn:hover {
      background: var(--color-main-light);
      color: var(--color-neutral-dark);
      border-color: var(--color-main-light);
    }
    
    .quantity {
      min-width: 30px;
      text-align: center;
      font-weight: 600;
      font-family: var(--font-display);
    }
    
    .cart-item-total {
      font-size: 1.25em;
      font-family: var(--font-display);
      color: var(--color-main-light);
      min-width: 80px;
      text-align: right;
    }
    
    .remove-btn {
      background: transparent;
      border: 1px solid var(--color-neutral-medium);
      color: var(--color-text-muted);
      width: 36px;
      height: 36px;
      border-radius: 0.5em;
      cursor: pointer;
      font-size: 1.2em;
      transition: all 0.2s ease;
      flex-shrink: 0;
    }
    
    .remove-btn:hover {
      background: #ff4444;
      color: white;
      border-color: #ff4444;
    }
    
    .summary-line {
      display: flex;
      justify-content: space-between;
      margin: 0.75em 0;
      font-size: 1em;
    }
    
    @media (max-width: 768px) {
      .cart-item .display-flex {
        flex-wrap: wrap;
      }
      
      .cart-item-image {
        width: 80px;
        height: 80px;
      }
      
      .cart-item-total {
        width: 100%;
        margin-top: 1em;
        text-align: left;
      }
    }
  `;
  document.head.appendChild(style);
}