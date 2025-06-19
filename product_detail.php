<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$isLoggedIn = isset($_SESSION['user_id']);

// Get product ID from URL first
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Debug output
error_log("Product ID received: " . $product_id);
error_log("User logged in: " . ($isLoggedIn ? 'Yes' : 'No'));

if (!$isLoggedIn) {
    // Store the current URL to redirect back after login
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: login.html");
    exit();
}

if (!$product_id) {
    header("Location: collections.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Details - Perfumis</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    
    <style>
        /* Modern Product Details Styling */
        .product-hero {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 40px 0;
            margin-top: 20px;
        }

        .breadcrumb {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            margin-bottom: 20px;
        }

        .breadcrumb a {
            color: #bf2e1a;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: #a52a1a;
            text-decoration: underline;
        }

        .breadcrumb span {
            color: #666;
            margin: 0 8px;
        }

        .product-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        .product-image-section {
            position: relative;
        }

        .main-product-image {
            width: 100%;
            max-width: 500px;
            height: 600px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.5s ease;
            cursor: zoom-in;
        }

        .main-product-image:hover {
            transform: scale(1.02);
        }

        .image-gallery {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: #bf2e1a;
            transform: scale(1.05);
        }

        .product-info-section {
            padding: 20px 0;
        }

        .product-title {
            font-family: "Dancing Script", cursive;
            font-size: 3rem;
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
            line-height: 1.2;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stars {
            color: #ffd700;
            font-size: 18px;
        }

        .rating-text {
            color: #666;
            font-size: 14px;
        }

        .product-price {
            font-size: 2.5rem;
            font-weight: 700;
            color: #bf2e1a;
            margin-bottom: 20px;
            font-family: "Nunito", sans-serif;
        }

        .original-price {
            font-size: 1.5rem;
            color: #999;
            text-decoration: line-through;
            margin-right: 15px;
        }

        .discount-badge {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-left: 10px;
        }

        .stock-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .stock-status.in-stock {
            background-color: #e8f5e8;
            color: #2e7d32;
            border: 2px solid #c8e6c9;
        }

        .stock-status.out-of-stock {
            background-color: #fce4ec;
            color: #c62828;
            border: 2px solid #f8bbd9;
        }

        .stock-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: currentColor;
        }

        .product-description {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border: 1px solid #e9ecef;
        }

        .product-description h3 {
            font-family: "Dancing Script", cursive;
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .product-description p {
            color: #666;
            line-height: 1.8;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .product-highlights {
            background: linear-gradient(135deg, #fff8e1, #fffbf0);
            padding: 25px;
            border-radius: 15px;
            border-left: 5px solid #bf2e1a;
            margin-bottom: 30px;
        }

        .product-highlights h4 {
            color: #bf2e1a;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .highlights-list {
            list-style: none;
            padding: 0;
        }

        .highlights-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            color: #555;
        }

        .highlights-list li::before {
            content: "✓";
            color: #bf2e1a;
            font-weight: bold;
            font-size: 16px;
        }

        .purchase-section {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
            position: sticky;
            top: 20px;
        }

        .quantity-selector {
            margin-bottom: 25px;
        }

        .quantity-selector label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #bf2e1a;
            background: white;
            color: #bf2e1a;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            background: #bf2e1a;
            color: white;
        }

        .quantity-input {
            width: 80px;
            height: 40px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
        }

        .add-to-cart-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .add-to-cart-btn {
            width: 100%;
            padding: 18px 25px;
            background: linear-gradient(135deg, #bf2e1a, #d73527);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .add-to-cart-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .add-to-cart-btn:hover::before {
            left: 100%;
        }

        .add-to-cart-btn:hover {
            background: linear-gradient(135deg, #a52a1a, #bf2e1a);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(191, 46, 26, 0.4);
        }

        .add-to-cart-btn:disabled {
            background: #cccccc;
            cursor: not-allowed;
            transform: none;
        }

        .buy-now-btn {
            width: 100%;
            padding: 18px 25px;
            background: transparent;
            color: #bf2e1a;
            border: 2px solid #bf2e1a;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .buy-now-btn:hover {
            background: #bf2e1a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(191, 46, 26, 0.2);
        }

        .product-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .feature-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #bf2e1a;
        }

        .feature-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .feature-text {
            color: #666;
            font-size: 14px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #bf2e1a;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }

        .back-button:hover {
            color: #a52a1a;
        }

        .loading-state {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            flex-direction: column;
            gap: 20px;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #bf2e1a;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .success-message {
            background: #e8f5e8;
            color: #2e7d32;
            padding: 15px 20px;
            border-radius: 10px;
            margin-top: 15px;
            display: none;
            border: 1px solid #c8e6c9;
        }

        .error-state {
            text-align: center;
            padding: 100px 40px;
            color: #666;
        }

        .error-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .error-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        /* Responsive Design */
        @media (max-width: 968px) {
            .product-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .product-title {
                font-size: 2.5rem;
            }
            
            .main-product-image {
                max-width: 400px;
                height: 500px;
            }
        }

        @media (max-width: 768px) {
            .product-hero {
                padding: 20px 0;
            }
            
            .product-container {
                padding: 0 15px;
                gap: 30px;
            }
            
            .product-title {
                font-size: 2rem;
            }
            
            .product-price {
                font-size: 2rem;
            }
            
            .main-product-image {
                max-width: 100%;
                height: 400px;
            }
            
            .purchase-section {
                position: static;
            }
        }
    </style>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main>
        <div class="loading-state" id="loading">
            <div class="loading-spinner"></div>
            <p>Loading product details...</p>
        </div>

        <div class="error-state" id="error-state" style="display: none;">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>Product Not Found</h3>
            <p>Sorry, we couldn't find the product you're looking for.</p>
            <a href="collections.php" class="btn btn-primary">Browse Collections</a>
        </div>

        <div class="product-hero" id="product-content" style="display: none;">
            <div class="breadcrumb">
                <a href="index.php">Home</a>
                <span>/</span>
                <a href="collections.php">Products</a>
                <span>/</span>
                <span id="breadcrumb-product">Product Details</span>
            </div>

            <a href="collections.php" class="back-button">
                ← Back to Products
            </a>

            <div class="product-container">
                <!-- Left Column - Images -->
                <div class="product-image-section">
                    <img id="main-product-image" class="main-product-image" src="" alt="" onerror="this.src='images/placeholder.jpg'">
                    <div class="image-gallery" id="image-gallery">
                        <!-- Additional images will be loaded here -->
                    </div>
                </div>

                <!-- Right Column - Product Info -->
                <div class="product-info-section">
                    <h1 class="product-title" id="product-name">Loading...</h1>
                    
                    <div class="product-rating">
                        <div class="stars" id="product-rating">★★★★★</div>
                        <span class="rating-text">(4.8 out of 5 stars)</span>
                    </div>

                    <div class="product-price" id="product-price">$0.00</div>

                    <div class="stock-status" id="stock-status">
                        <div class="stock-dot"></div>
                        <span>Checking availability...</span>
                    </div>

                    <div class="product-description" id="product-description">
                        <h3>About This Fragrance</h3>
                        <p>Loading product description...</p>
                    </div>

                    <div class="product-highlights">
                        <h4>Key Features</h4>
                        <ul class="highlights-list">
                            <li>Premium quality ingredients</li>
                            <li>Long-lasting fragrance</li>
                            <li>Elegant packaging</li>
                            <li>Perfect for any occasion</li>
                        </ul>
                    </div>

                    <div class="purchase-section">
                        <div class="quantity-selector">
                            <label for="quantity">Quantity:</label>
                            <div class="quantity-controls">
                                <button class="quantity-btn" id="decrease-qty">-</button>
                                <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="10">
                                <button class="quantity-btn" id="increase-qty">+</button>
                            </div>
                        </div>

                        <div class="add-to-cart-section">
                            <button class="add-to-cart-btn" id="add-to-cart-btn">Add to Cart</button>
                            <button class="buy-now-btn" id="buy-now-btn">Buy Now</button>
                        </div>

                        <div class="success-message" id="success-message">
                            Product added to cart successfully!
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-features">
                <div class="feature-card">
                    <div class="feature-icon">🚚</div>
                    <div class="feature-title">Free Shipping</div>
                    <div class="feature-text">On orders over $50</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <div class="feature-title">Secure Payment</div>
                    <div class="feature-text">SSL encrypted checkout</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">↩️</div>
                    <div class="feature-title">Easy Returns</div>
                    <div class="feature-text">30-day return policy</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎁</div>
                    <div class="feature-title">Gift Wrapping</div>
                    <div class="feature-text">Available at checkout</div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productId = <?php echo $product_id; ?>;
            const loadingElement = document.getElementById('loading');
            const errorElement = document.getElementById('error-state');
            const containerElement = document.getElementById('product-content');

            let currentProduct = null;

            // Load product data
            fetch('fetch_products.php?id=' + productId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(product => {
                    if (product.error) {
                        throw new Error(product.error);
                    }

                    currentProduct = product;
                    populateProductDetails(product);
                    
                    // Hide loading, show content
                    loadingElement.style.display = 'none';
                    containerElement.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching product:', error);
                    loadingElement.style.display = 'none';
                    errorElement.style.display = 'block';
                });

            function populateProductDetails(product) {
                // Update page title
                document.title = `${product.name} - Perfumis`;
                
                // Update breadcrumb
                document.getElementById('breadcrumb-product').textContent = product.name;
                
                // Update main content
                document.getElementById('product-name').textContent = product.name;
                document.getElementById('product-price').textContent = `$${parseFloat(product.price || 0).toFixed(2)}`;
                
                // Update image
                const mainImage = document.getElementById('main-product-image');
                mainImage.src = product.image_url || 'images/placeholder.jpg';
                mainImage.alt = product.name;
                
                // Update description
                const descriptionContainer = document.getElementById('product-description');
                if (product.description) {
                    descriptionContainer.innerHTML = `
                        <h3>About This Fragrance</h3>
                        <p>${product.description}</p>
                    `;
                } else {
                    descriptionContainer.innerHTML = `
                        <h3>About This Fragrance</h3>
                        <p>Experience the luxury and elegance of this exquisite fragrance, carefully crafted with premium ingredients to create a memorable scent that lasts all day.</p>
                    `;
                }
                
                // Update stock status
                const stockStatus = document.getElementById('stock-status');
                const addToCartBtn = document.getElementById('add-to-cart-btn');
                const buyNowBtn = document.getElementById('buy-now-btn');
                const quantityInput = document.getElementById('quantity');
                
                if (product.stock > 0) {
                    stockStatus.className = 'stock-status in-stock';
                    stockStatus.innerHTML = `
                        <div class="stock-dot"></div>
                        <span>In Stock (${product.stock} available)</span>
                    `;
                    addToCartBtn.textContent = 'Add to Cart';
                    addToCartBtn.disabled = false;
                    buyNowBtn.textContent = 'Buy Now';
                    buyNowBtn.disabled = false;
                    quantityInput.max = product.stock;
                } else {
                    stockStatus.className = 'stock-status out-of-stock';
                    stockStatus.innerHTML = `
                        <div class="stock-dot"></div>
                        <span>Out of Stock</span>
                    `;
                    addToCartBtn.textContent = 'Out of Stock';
                    addToCartBtn.disabled = true;
                    buyNowBtn.textContent = 'Out of Stock';
                    buyNowBtn.disabled = true;
                    quantityInput.disabled = true;
                }
            }

            // Quantity controls
            document.getElementById('decrease-qty').addEventListener('click', function() {
                const qtyInput = document.getElementById('quantity');
                const currentQty = parseInt(qtyInput.value);
                if (currentQty > 1) {
                    qtyInput.value = currentQty - 1;
                }
            });

            document.getElementById('increase-qty').addEventListener('click', function() {
                const qtyInput = document.getElementById('quantity');
                const currentQty = parseInt(qtyInput.value);
                const maxQty = parseInt(qtyInput.max) || 10;
                if (currentQty < maxQty) {
                    qtyInput.value = currentQty + 1;
                }
            });

            // Add to cart functionality
            document.getElementById('add-to-cart-btn').addEventListener('click', function() {
                if (!currentProduct || currentProduct.stock <= 0) {
                    showMessage('This product is out of stock.', 'error');
                    return;
                }

                const quantity = parseInt(document.getElementById('quantity').value);
                
                if (quantity <= 0 || quantity > currentProduct.stock) {
                    showMessage(`Please enter a valid quantity (1-${currentProduct.stock}).`, 'error');
                    return;
                }

                // Add to cart
                addToCart(currentProduct, quantity);
                
                // Show success message briefly, then redirect
                showMessage(`${currentProduct.name} (${quantity}) added to cart! Redirecting...`, 'success');
                
                // Redirect to cart page after 1.5 seconds
                setTimeout(() => {
                    window.location.href = 'cart.php';
                }, 1500);
            });

            // Buy now functionality
            document.getElementById('buy-now-btn').addEventListener('click', function() {
                if (!currentProduct || currentProduct.stock <= 0) {
                    showMessage('This product is out of stock.', 'error');
                    return;
                }

                const quantity = parseInt(document.getElementById('quantity').value);
                
                if (quantity <= 0 || quantity > currentProduct.stock) {
                    showMessage(`Please enter a valid quantity (1-${currentProduct.stock}).`, 'error');
                    return;
                }

                // Add to cart first
                addToCart(currentProduct, quantity);
                
                // Show brief message, then redirect to checkout
                showMessage(`${currentProduct.name} added to cart! Proceeding to checkout...`, 'success');
                
                // Redirect to checkout page after 1 second
                setTimeout(() => {
                    window.location.href = 'checkout.php';
                }, 1000);
            });

            // Helper function to add items to cart
            function addToCart(product, quantity) {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                const cartItem = cart.find(item => item.id === product.id);
                
                if (cartItem) {
                    const newQuantity = cartItem.quantity + quantity;
                    if (newQuantity > product.stock) {
                        showMessage(`Cannot add ${quantity} items. Only ${product.stock - cartItem.quantity} more available.`, 'error');
                        return false;
                    }
                    cartItem.quantity = newQuantity;
                } else {
                    cart.push({
                        id: product.id,
                        name: product.name,
                        price: product.price,
                        image: product.image_url,
                        image_url: product.image_url,
                        quantity: quantity
                    });
                }
                
                localStorage.setItem('cart', JSON.stringify(cart));
                
                // Refresh cart counter if function exists
                if (window.refreshCartCounter) {
                    window.refreshCartCounter();
                }
                
                return true;
            }

            // Enhanced message display function
            function showMessage(message, type = 'success') {
                // Remove any existing message
                const existingMessage = document.querySelector('.temp-message');
                if (existingMessage) {
                    existingMessage.remove();
                }

                // Create new message element
                const messageElement = document.createElement('div');
                messageElement.className = `temp-message ${type}`;
                messageElement.textContent = message;
                messageElement.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: ${type === 'success' ? '#4CAF50' : '#f44336'};
                    color: white;
                    padding: 15px 25px;
                    border-radius: 10px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                    z-index: 1000;
                    font-weight: 600;
                    max-width: 350px;
                    animation: slideInRight 0.3s ease-out;
                `;

                // Add slide-in animation
                const style = document.createElement('style');
                style.textContent = `
                    @keyframes slideInRight {
                        from {
                            opacity: 0;
                            transform: translateX(100%);
                        }
                        to {
                            opacity: 1;
                            transform: translateX(0);
                        }
                    }
                `;
                document.head.appendChild(style);

                document.body.appendChild(messageElement);
                
                // Auto-remove after 3 seconds if not success (success messages are removed by redirect)
                if (type !== 'success') {
                    setTimeout(() => {
                        if (messageElement.parentNode) {
                            messageElement.remove();
                        }
                    }, 3000);
                }
            }
        });
    </script>
</body>

</html>