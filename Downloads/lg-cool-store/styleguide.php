<?php
$page_title = 'Style Guide - LG Cool Store';
$page_description = 'Design system and component library for LG Cool Store';

include 'parts/functions.php';
include 'parts/meta.php';
include 'parts/header.php';
?>

<style>
.styleguide {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
}

.styleguide-section {
    margin-bottom: 4rem;
    padding-bottom: 3rem;
    border-bottom: 2px solid var(--border-color);
}

.styleguide-section:last-child {
    border-bottom: none;
}

.section-title {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--text-dark);
    position: relative;
    padding-bottom: 0.5rem;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: var(--primary-color);
}

.section-description {
    color: var(--text-light);
    margin-bottom: 2rem;
}

.component-demo {
    background: #f8fafc;
    padding: 2rem;
    border-radius: 0.75rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border-color);
}

.component-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.color-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.color-swatch {
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.color-preview {
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
}

.color-info {
    background: white;
    padding: 1rem;
}

.color-info h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
}

.color-info p {
    margin: 0.25rem 0;
    font-size: 0.85rem;
    color: var(--text-light);
    font-family: 'Courier New', monospace;
}

.typography-demo {
    margin: 1rem 0;
}

.button-grid {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.form-example {
    max-width: 500px;
}

.icon-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 1rem;
}

.icon-item {
    text-align: center;
    padding: 1.5rem;
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
}

.icon-item svg {
    margin: 0 auto 0.5rem;
}

.code-block {
    background: #1e293b;
    color: #e2e8f0;
    padding: 1.5rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin-top: 1rem;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.6;
}

.spacing-demo {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.spacing-item {
    text-align: center;
}

.spacing-box {
    background: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.alert-demo {
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    border-left: 4px solid;
}

.alert-success {
    background: #d1fae5;
    border-color: #10b981;
    color: #065f46;
}

.alert-error {
    background: #fee2e2;
    border-color: #ef4444;
    color: #991b1b;
}

.alert-warning {
    background: #fef3c7;
    border-color: #f59e0b;
    color: #92400e;
}

.alert-info {
    background: #dbeafe;
    border-color: #3b82f6;
    color: #1e40af;
}

.grid-demo {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
}

.grid-item {
    background: var(--bg-light);
    padding: 2rem;
    text-align: center;
    border: 2px dashed var(--border-color);
    border-radius: 0.5rem;
}
</style>

<section class="page-header">
    <div class="container">
        <h1>Style Guide</h1>
        <p>Design System & Component Library</p>
    </div>
</section>

<div class="styleguide">

    <!-- Colors Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Color Palette</h2>
        <p class="section-description">Our brand colors create a modern, trustworthy, and energetic feel.</p>
        
        <div class="color-grid">
            <div class="color-swatch">
                <div class="color-preview" style="background: #2563eb;">
                    Primary
                </div>
                <div class="color-info">
                    <h4>Primary Blue</h4>
                    <p>HEX: #2563eb</p>
                    <p>RGB: 37, 99, 235</p>
                    <p>Usage: Buttons, links, accents</p>
                </div>
            </div>
            
            <div class="color-swatch">
                <div class="color-preview" style="background: #475569;">
                    Secondary
                </div>
                <div class="color-info">
                    <h4>Secondary Gray</h4>
                    <p>HEX: #475569</p>
                    <p>RGB: 71, 85, 105</p>
                    <p>Usage: Text, borders</p>
                </div>
            </div>
            
            <div class="color-swatch">
                <div class="color-preview" style="background: #f59e0b;">
                    Accent
                </div>
                <div class="color-info">
                    <h4>Accent Orange</h4>
                    <p>HEX: #f59e0b</p>
                    <p>RGB: 245, 158, 11</p>
                    <p>Usage: Sale badges, highlights</p>
                </div>
            </div>
            
            <div class="color-swatch">
                <div class="color-preview" style="background: #10b981;">
                    Success
                </div>
                <div class="color-info">
                    <h4>Success Green</h4>
                    <p>HEX: #10b981</p>
                    <p>RGB: 16, 185, 129</p>
                    <p>Usage: Success states, in stock</p>
                </div>
            </div>
            
            <div class="color-swatch">
                <div class="color-preview" style="background: #ef4444;">
                    Error
                </div>
                <div class="color-info">
                    <h4>Error Red</h4>
                    <p>HEX: #ef4444</p>
                    <p>RGB: 239, 68, 68</p>
                    <p>Usage: Errors, sale prices</p>
                </div>
            </div>
            
            <div class="color-swatch">
                <div class="color-preview" style="background: #1e293b; color: white;">
                    Dark
                </div>
                <div class="color-info">
                    <h4>Text Dark</h4>
                    <p>HEX: #1e293b</p>
                    <p>RGB: 30, 41, 59</p>
                    <p>Usage: Headings, body text</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Typography Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Typography</h2>
        <p class="section-description">We use Space Grotesk for headings and Inter for body text.</p>
        
        <div class="component-demo">
            <div class="typography-demo">
                <h1>Heading 1 - Space Grotesk Bold</h1>
                <p style="color: var(--text-light); font-size: 0.9rem; margin-top: -0.5rem;">Font: Space Grotesk, 2.5rem (40px), 700 weight</p>
            </div>
        </div>
        
        <div class="component-demo">
            <div class="typography-demo">
                <h2>Heading 2 - Space Grotesk Bold</h2>
                <p style="color: var(--text-light); font-size: 0.9rem; margin-top: -0.5rem;">Font: Space Grotesk, 2rem (32px), 700 weight</p>
            </div>
        </div>
        
        <div class="component-demo">
            <div class="typography-demo">
                <h3>Heading 3 - Space Grotesk Bold</h3>
                <p style="color: var(--text-light); font-size: 0.9rem; margin-top: -0.5rem;">Font: Space Grotesk, 1.5rem (24px), 700 weight</p>
            </div>
        </div>
        
        <div class="component-demo">
            <div class="typography-demo">
                <p>Body text uses Inter font family. This is the default text style used throughout the site. It's designed for maximum readability with a font size of 1rem (16px) and line height of 1.6. The color is set to our text-dark variable (#1e293b).</p>
                <p style="color: var(--text-light); font-size: 0.9rem; margin-top: 1rem;">Font: Inter, 1rem (16px), 400 weight, 1.6 line-height</p>
            </div>
        </div>
        
        <div class="component-demo">
            <div class="typography-demo">
                <p style="color: var(--text-light);">Light text is used for secondary information and descriptions. It uses the same Inter font but with our text-light color (#64748b).</p>
                <p style="color: var(--text-light); font-size: 0.9rem; margin-top: 1rem;">Font: Inter, 1rem (16px), 400 weight, color: #64748b</p>
            </div>
        </div>
        
        <div class="component-demo">
            <div class="typography-demo">
                <a href="#">This is a link with hover effect</a>
                <p style="color: var(--text-light); font-size: 0.9rem; margin-top: 1rem;">Color: #2563eb, Hover: #f59e0b, Transition: 0.3s</p>
            </div>
        </div>
    </section>

    <!-- Buttons Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Buttons</h2>
        <p class="section-description">Our button styles for different actions and contexts.</p>
        
        <div class="component-demo">
            <p class="component-label">Primary Buttons</p>
            <div class="button-grid">
                <button class="btn btn-primary">Primary Button</button>
                <button class="btn btn-primary" disabled>Disabled Primary</button>
            </div>
        </div>
        
        <div class="component-demo">
            <p class="component-label">Secondary Buttons</p>
            <div class="button-grid">
                <button class="btn btn-secondary">Secondary Button</button>
                <button class="btn btn-secondary" disabled>Disabled Secondary</button>
            </div>
        </div>
        
        <div class="component-demo">
            <p class="component-label">Button Sizes</p>
            <div class="button-grid">
                <button class="btn btn-primary">Default Size</button>
                <button class="btn btn-primary btn-large">Large Button</button>
            </div>
        </div>
        
        <div class="component-demo">
            <p class="component-label">Icon Buttons</p>
            <div class="button-grid">
                <button class="icon-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                </button>
                <button class="favorite-btn">♥</button>
            </div>
        </div>
        
        <div class="code-block">
&lt;button class="btn btn-primary"&gt;Primary Button&lt;/button&gt;
&lt;button class="btn btn-secondary"&gt;Secondary Button&lt;/button&gt;
&lt;button class="btn btn-primary btn-large"&gt;Large Button&lt;/button&gt;
        </div>
    </section>

    <!-- Form Elements Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Form Elements</h2>
        <p class="section-description">Input fields, selects, checkboxes, and other form components.</p>
        
        <div class="component-demo">
            <p class="component-label">Text Inputs</p>
            <div class="form-example">
                <div class="form-group">
                    <label for="example-input">Label Text</label>
                    <input type="text" id="example-input" placeholder="Placeholder text">
                </div>
                <div class="form-group">
                    <label for="example-email">Email Address</label>
                    <input type="email" id="example-email" placeholder="your@email.com">
                </div>
                <div class="form-group">
                    <label for="example-textarea">Textarea</label>
                    <textarea id="example-textarea" rows="4" placeholder="Enter your message here..."></textarea>
                </div>
            </div>
        </div>
        
        <div class="component-demo">
            <p class="component-label">Select Dropdown</p>
            <div class="form-example">
                <div class="form-group">
                    <label for="example-select">Select an option</label>
                    <select id="example-select">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="component-demo">
            <p class="component-label">Checkboxes & Radio Buttons</p>
            <div class="form-example">
                <label class="checkbox-option">
                    <input type="checkbox">
                    <span>Checkbox Option 1</span>
                </label>
                <label class="checkbox-option">
                    <input type="checkbox" checked>
                    <span>Checkbox Option 2 (Checked)</span>
                </label>
                <br><br>
                <label class="radio-option">
                    <input type="radio" name="example-radio" checked>
                    <span>Radio Option 1</span>
                </label>
                <label class="radio-option">
                    <input type="radio" name="example-radio">
                    <span>Radio Option 2</span>
                </label>
            </div>
        </div>
    </section>

    <!-- Product Cards Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Product Cards</h2>
        <p class="section-description">Product card components used throughout the site.</p>
        
        <div class="component-demo">
            <p class="component-label">Standard Product Card</p>
            <div style="max-width: 300px;">
                <div class="product-card">
                    <a href="#" class="product-image">
                        <div style="aspect-ratio: 1; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                            Product Image
                        </div>
                        <button class="favorite-btn" onclick="event.preventDefault();">♥</button>
                    </a>
                    <div class="product-info">
                        <h3><a href="#">Product Name</a></h3>
                        <p class="category">Category</p>
                        <div class="price-container">
                            <span class="price">$24.99</span>
                        </div>
                        <button class="btn btn-primary">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="component-demo">
            <p class="component-label">Sale Product Card</p>
            <div style="max-width: 300px;">
                <div class="product-card">
                    <a href="#" class="product-image">
                        <div style="aspect-ratio: 1; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                            Product Image
                        </div>
                        <span class="sale-badge">-25%</span>
                        <button class="favorite-btn active" onclick="event.preventDefault();">♥</button>
                    </a>
                    <div class="product-info">
                        <h3><a href="#">Sale Product</a></h3>
                        <p class="category">Category</p>
                        <div class="price-container">
                            <span class="price-original">$84.99</span>
                            <span class="price-sale">$69.99</span>
                        </div>
                        <button class="btn btn-primary">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Badges & Pills Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Badges & Pills</h2>
        <p class="section-description">Small indicators and category filters.</p>
        
        <div class="component-demo">
            <p class="component-label">Badges</p>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <span class="badge" style="position: relative;">5</span>
                <span class="sale-badge">Sale</span>
                <span class="sale-badge">-25%</span>
            </div>
        </div>
        
        <div class="component-demo">
            <p class="component-label">Category Pills</p>
            <div class="category-filters">
                <a href="#" class="category-pill active">All Products</a>
                <a href="#" class="category-pill">Caps</a>
                <a href="#" class="category-pill">Shoes</a>
                <a href="#" class="category-pill">Accessories</a>
            </div>
        </div>
    </section>

    <!-- Alerts Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Alerts & Notifications</h2>
        <p class="section-description">Status messages and notifications.</p>
        
        <div class="component-demo">
            <div class="alert-demo alert-success">
                <strong>Success!</strong> Your item has been added to cart.
            </div>
            <div class="alert-demo alert-error">
                <strong>Error!</strong> Something went wrong. Please try again.
            </div>
            <div class="alert-demo alert-warning">
                <strong>Warning!</strong> Only 3 items left in stock.
            </div>
            <div class="alert-demo alert-info">
                <strong>Info:</strong> Free shipping on orders over $75.
            </div>
        </div>
    </section>

    <!-- Icons Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Icons</h2>
        <p class="section-description">SVG icons used throughout the interface.</p>
        
        <div class="component-demo">
            <div class="icon-grid">
                <div class="icon-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">Search</p>
                </div>
                
                <div class="icon-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">Cart</p>
                </div>
                
                <div class="icon-item">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">Favorite</p>
                </div>
                
                <div class="icon-item">
                    <span style="font-size: 2rem;">✓</span>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">Check</p>
                </div>
                
                <div class="icon-item">
                    <span style="font-size: 2rem;">✕</span>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">Close</p>
                </div>
                
                <div class="icon-item">
                    <span style="font-size: 2rem;">♥</span>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">Heart</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Spacing Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Spacing</h2>
        <p class="section-description">Consistent spacing scale used throughout the design.</p>
        
        <div class="component-demo">
            <div class="spacing-demo">
                <div class="spacing-item">
                    <div class="spacing-box" style="width: 16px; height: 16px;"></div>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">0.25rem<br>(4px)</p>
                </div>
                <div class="spacing-item">
                    <div class="spacing-box" style="width: 32px; height: 32px;"></div>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">0.5rem<br>(8px)</p>
                </div>
                <div class="spacing-item">
                    <div class="spacing-box" style="width: 48px; height: 48px;"></div>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">0.75rem<br>(12px)</p>
                </div>
                <div class="spacing-item">
                    <div class="spacing-box" style="width: 64px; height: 64px;"></div>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">1rem<br>(16px)</p>
                </div>
                <div class="spacing-item">
                    <div class="spacing-box" style="width: 96px; height: 96px;"></div>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">1.5rem<br>(24px)</p>
                </div>
                <div class="spacing-item">
                    <div class="spacing-box" style="width: 128px; height: 128px;"></div>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">2rem<br>(32px)</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Grid System Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Grid System</h2>
        <p class="section-description">Responsive grid layout used for product displays.</p>
        
        <div class="component-demo">
            <p class="component-label">Product Grid (Auto-fill, min 280px)</p>
            <div class="grid-demo">
                <div class="grid-item">Grid Item</div>
                <div class="grid-item">Grid Item</div>
                <div class="grid-item">Grid Item</div>
                <div class="grid-item">Grid Item</div>
            </div>
        </div>
        
        <div class="code-block">
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
}
        </div>
    </section>

    <!-- Border Radius Section -->
    <section class="styleguide-section">
        <h2 class="section-title">Border Radius</h2>
        <p class="section-description">Rounded corner standards for consistency.</p>
        
        <div class="component-demo">
            <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
                <div>
                    <div style="width: 100px; height: 100px; background: var(--primary-color); border-radius: 0.25rem;"></div>
                    <p style="margin-top: 0.5rem; text-align: center; font-size: 0.85rem;">0.25rem<br>Small</p>
                </div>
                <div>
                    <div style="width: 100px; height: 100px; background: var(--primary-color); border-radius: 0.5rem;"></div>
                    <p style="margin-top: 0.5rem; text-align: center; font-size: 0.85rem;">0.5rem<br>Medium</p>
                </div>
                <div>
                    <div style="width: 100px; height: 100px; background: var(--primary-color); border-radius: 0.75rem;"></div>
                    <p style="margin-top: 0.5rem; text-align: center; font-size: 0.85rem;">0.75rem<br>Large</p>
                </div>
                <div>
                    <div style="width: 100px; height: 100px; background: var(--primary-color); border-radius: 50%;"></div>
                    <p style="margin-top: 0.5rem; text-align: center; font-size: 0.85rem;">50%<br>Circle</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Shadow Section -->
    <section class="styleguide-section" style="border-bottom: none;">
        <h2 class="section-title">Shadows</h2>
        <p class="section-description">Elevation levels for depth and hierarchy.</p>
        
        <div class="component-demo">
            <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
                <div>
                    <div style="width: 120px; height: 120px; background: white; box-shadow: 0 1px 2px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: center; border-radius: 0.5rem;">
                        Small
                    </div>
                    <p style="margin-top: 0.5rem; text-align: center; font-size: 0.85rem;">Light shadow</p>
                </div>
                <div>
                    <div style="width: 120px; height: 120px; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; border-radius: 0.5rem;">
                        Medium
                    </div>
                    <p style="margin-top: 0.5rem; text-align: center; font-size: 0.85rem;">Card shadow</p>
                </div>
                <div>
                    <div style="width: 120px; height: 120px; background: white; box-shadow: 0 10px 20px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: center; border-radius: 0.5rem;">
                        Large
                    </div>
                    <p style="margin-top: 0.5rem; text-align: center; font-size: 0.85rem;">Hover shadow</p>
                </div>
            </div>
        </div>
    </section>

</div>

<?php include 'parts/footer.php'; ?>
