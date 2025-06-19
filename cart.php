<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart - Perfumis</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .breadcrumb-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            padding: 15px 0;
            margin-top: 20px;
        }

        .breadcrumb-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .breadcrumb-container a {
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .breadcrumb-container a:hover {
            color: #bf2e1a;
        }

        .breadcrumb-separator {
            color: #cbd5e1;
        }

        .page-header {
            padding: 40px 0 20px;
            text-align: center;
        }

        .page-title {
            font-family: 'Dancing Script', cursive;
            font-size: 3.5rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 10px 0;
            background: linear-gradient(135deg, #1e293b 0%, #64748b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            font-weight: 400;
            margin: 0;
        }

        .cart-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px 80px;
        }

        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 40px;
            align-items: start;
        }

        .cart-items-section {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 30px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            color: #bf2e1a;
            font-size: 1.2rem;
        }

        .empty-cart {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-cart-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #cbd5e1;
            border: 3px solid rgba(203, 213, 225, 0.3);
        }

        .empty-cart h3 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #475569;
            margin: 0 0 15px 0;
        }

        .empty-cart p {
            color: #64748b;
            font-size: 1rem;
            margin: 0 0 40px 0;
            line-height: 1.6;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .continue-shopping {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 32px;
            background: linear-gradient(135deg, #bf2e1a 0%, #dc2626 100%);
            color: white;
            text-decoration: none;
            border-radius: 16px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(191, 46, 26, 0.3);
        }

        .continue-shopping:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(191, 46, 26, 0.4);
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 30px 0;
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            position: relative;
            transition: all 0.3s ease;
            border-radius: 16px;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item:hover {
            background: rgba(248, 250, 252, 0.8);
            padding: 30px 20px;
            margin: 0 -20px;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .item-image {
            width: 100px;
            height: 100px;
            border-radius: 16px;
            overflow: hidden;
            flex-shrink: 0;
            background: #f8fafc;
            border: 2px solid rgba(226, 232, 240, 0.6);
            position: relative;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .item-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .cart-item:hover .item-image::after {
            opacity: 1;
        }

        .item-details {
            flex: 1;
            margin-left: 24px;
        }

        .item-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 8px 0;
            line-height: 1.4;
        }

        .item-category {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
            margin: 0 0 12px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .item-price {
            font-size: 1.1rem;
            color: #bf2e1a;
            font-weight: 700;
            margin: 0 0 16px 0;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .quantity-label {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .quantity-wrapper {
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            background: #bf2e1a;
            color: white;
        }

        .quantity-display {
            width: 50px;
            text-align: center;
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
            background: white;
            border: none;
            padding: 0;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-total {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .remove-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 32px;
            height: 32px;
            border: none;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0;
            transform: scale(0.8);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item:hover .remove-btn {
            opacity: 1;
            transform: scale(1);
        }

        .remove-btn:hover {
            background: #ef4444;
            color: white;
            transform: scale(1.1);
        }

        .cart-summary {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 40px;
            border: 1px solid rgba(226, 232, 240, 0.6);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 40px;
            height: fit-content;
        }

        .summary-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 30px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        }

        .summary-row:last-of-type {
            border-bottom: none;
            margin-top: 12px;
            padding-top: 24px;
            border-top: 2px solid #e2e8f0;
        }

        .summary-label {
            color: #64748b;
            font-weight: 500;
        }

        .summary-value {
            font-weight: 600;
            color: #1e293b;
        }

        .total-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: #bf2e1a;
        }

        .promo-section {
            margin: 30px 0;
            padding: 20px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 16px;
            border: 1px solid #fbbf24;
        }

        .promo-input {
            display: flex;
            gap: 12px;
            margin-top: 12px;
        }

        .promo-input input {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            background: white;
        }

        .promo-input button {
            padding: 12px 20px;
            background: #1e293b;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkout-btn {
            width: 100%;
            padding: 20px;
            background: linear-gradient(135deg, #bf2e1a 0%, #dc2626 100%);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-top: 30px;
            box-shadow: 0 10px 15px -3px rgba(191, 46, 26, 0.3);
        }

        .checkout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(191, 46, 26, 0.4);
        }

        .checkout-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .continue-shopping-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 12px;
            border-radius: 12px;
        }

        .continue-shopping-link:hover {
            color: #bf2e1a;
            background: rgba(191, 46, 26, 0.05);
        }

        .security-badges {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid rgba(226, 232, 240, 0.6);
        }

        .security-badge {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 16px 8px;
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px;
            text-align: center;
        }

        .security-badge i {
            color: #10b981;
            font-size: 1.2rem;
        }

        .security-badge span {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .message-toast {
            position: fixed;
            top: 30px;
            right: 30px;
            background: white;
            color: #1e293b;
            padding: 20px 24px;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-left: 4px solid #10b981;
            display: none;
            z-index: 1000;
            animation: slideInRight 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.6);
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .cart-layout {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .cart-summary {
                position: static;
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2.5rem;
            }
            
            .cart-container {
                padding: 20px 15px 60px;
            }
            
            .cart-items-section,
            .cart-summary {
                padding: 30px 20px;
            }
            
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
                text-align: left;
            }
            
            .item-details {
                margin-left: 0;
                width: 100%;
            }
            
            .remove-btn {
                position: static;
                opacity: 1;
                transform: scale(1);
                align-self: flex-end;
                margin-top: 12px;
            }
            
            .security-badges {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            .security-badge {
                flex-direction: row;
                justify-content: center;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="breadcrumb-section">
        <div class="breadcrumb-container">
            <a href="index.php"><i class="fas fa-home"></i> Home</a>
            <span class="breadcrumb-separator">></span>
            <a href="collections.php">Collections</a>
            <span class="breadcrumb-separator">></span>
            <span>Shopping Cart</span>
        </div>
    </div>

    <div class="page-header">
        <h1 class="page-title">Shopping Cart</h1>
        <p class="page-subtitle">Review your selections and proceed to checkout</p>
    </div>

    <main>
        <div class="cart-container">
            <div class="cart-layout">
                <div class="cart-items-section">
                    <h2 class="section-title">
                        <i class="fas fa-shopping-bag"></i>
                        Your Items
                    </h2>
                    <div id="cart-items">
                        <!-- Cart items will be dynamically inserted here -->
                    </div>
                </div>
                
                <div class="cart-summary">
                    <h3 class="summary-title">
                        <i class="fas fa-receipt"></i>
                        Order Summary
                    </h3>
                    
                    <div class="summary-row">
                        <span class="summary-label">Total Items:</span>
                        <span class="summary-value" id="total-items">0</span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="summary-label">Subtotal:</span>
                        <span class="summary-value" id="subtotal">$0.00</span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="summary-label">Shipping:</span>
                        <span class="summary-value" style="color: #10b981;">Free</span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="summary-label">Total:</span>
                        <span class="summary-value total-value" id="total-price">$0.00</span>
                    </div>

                    <div class="promo-section">
                        <label style="color: #92400e; font-weight: 600; font-size: 0.875rem;">Have a promo code?</label>
                        <div class="promo-input">
                            <input type="text" placeholder="Enter code" id="promo-code">
                            <button type="button">Apply</button>
                        </div>
                    </div>
                    
                    <button class="checkout-btn" id="checkout-btn">
                        <i class="fas fa-lock"></i>
                        Secure Checkout
                    </button>
                    
                    <a href="collections.php" class="continue-shopping-link">
                        <i class="fas fa-arrow-left"></i>
                        Continue Shopping
                    </a>
                    
                    <div class="security-badges">
                        <div class="security-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>Secure Payment</span>
                        </div>
                        <div class="security-badge">
                            <i class="fas fa-truck"></i>
                            <span>Free Shipping</span>
                        </div>
                        <div class="security-badge">
                            <i class="fas fa-undo"></i>
                            <span>Easy Returns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="message-toast" id="message-toast"></div>
    </main>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartItemsContainer = document.getElementById('cart-items');
            const totalItemsElement = document.getElementById('total-items');
            const subtotalElement = document.getElementById('subtotal');
            const totalPriceElement = document.getElementById('total-price');
            const checkoutBtn = document.getElementById('checkout-btn');
            const messageToast = document.getElementById('message-toast');

            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            function updateCartDisplay() {
                if (cart.length === 0) {
                    cartItemsContainer.innerHTML = `
                        <div class="empty-cart">
                            <div class="empty-cart-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h3>Your cart is empty</h3>
                            <p>Discover our exclusive collection of premium fragrances and find your perfect scent that tells your unique story.</p>
                            <a href="collections.php" class="continue-shopping">
                                <i class="fas fa-sparkles"></i>
                                Explore Fragrances
                            </a>
                        </div>
                    `;
                    checkoutBtn.disabled = true;
                    return;
                }

                cartItemsContainer.innerHTML = '';
                let totalItems = 0;
                let totalPrice = 0;

                cart.forEach(item => {
                    const itemTotal = parseFloat(item.price) * parseInt(item.quantity);
                    totalItems += parseInt(item.quantity);
                    totalPrice += itemTotal;

                    const cartItem = document.createElement('div');
                    cartItem.classList.add('cart-item');
                    cartItem.innerHTML = `
                        <div class="item-image">
                            <img src="${item.image || item.image_url || 'images/placeholder.jpg'}" alt="${item.name}" onerror="this.src='images/placeholder.jpg'">
                        </div>
                        
                        <div class="item-details">
                            <h4 class="item-name">${item.name}</h4>
                            <div class="item-category">Premium Fragrance</div>
                            <div class="item-price">$${parseFloat(item.price).toFixed(2)} each</div>
                            
                            <div class="quantity-controls">
                                <span class="quantity-label">Quantity:</span>
                                <div class="quantity-wrapper">
                                    <button class="quantity-btn decrease-quantity" data-id="${item.id}">-</button>
                                    <div class="quantity-display">${item.quantity}</div>
                                    <button class="quantity-btn increase-quantity" data-id="${item.id}">+</button>
                                </div>
                            </div>
                            
                            <div class="item-total">Total: $${itemTotal.toFixed(2)}</div>
                        </div>
                        
                        <button class="remove-btn" data-id="${item.id}" title="Remove item">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    cartItemsContainer.appendChild(cartItem);
                });

                totalItemsElement.textContent = totalItems;
                subtotalElement.textContent = `$${totalPrice.toFixed(2)}`;
                totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
                
                checkoutBtn.disabled = false;
            }

            function updateCartStorage() {
                localStorage.setItem('cart', JSON.stringify(cart));
                
                // Update cart counter if function exists
                if (window.refreshCartCounter) {
                    window.refreshCartCounter();
                }
            }

            function showMessage(message, type = 'success') {
                messageToast.textContent = message;
                messageToast.style.borderLeftColor = type === 'success' ? '#10b981' : '#ef4444';
                messageToast.style.display = 'block';
                
                setTimeout(() => {
                    messageToast.style.display = 'none';
                }, 3000);
            }

            // Event delegation for cart actions
            cartItemsContainer.addEventListener('click', function(event) {
                const target = event.target.closest('button');
                if (!target) return;

                const itemId = target.getAttribute('data-id');
                const item = cart.find(item => item.id == itemId);

                if (!item) return;

                if (target.classList.contains('decrease-quantity')) {
                    if (item.quantity > 1) {
                        item.quantity -= 1;
                        updateCartStorage();
                        updateCartDisplay();
                        showMessage(`Quantity updated for ${item.name}`);
                    }
                }

                if (target.classList.contains('increase-quantity')) {
                    item.quantity += 1;
                    updateCartStorage();
                    updateCartDisplay();
                    showMessage(`Quantity updated for ${item.name}`);
                }

                if (target.classList.contains('remove-btn') || target.parentElement.classList.contains('remove-btn')) {
                    cart = cart.filter(cartItem => cartItem.id != itemId);
                    updateCartStorage();
                    updateCartDisplay();
                    showMessage(`${item.name} removed from cart`);
                }
            });

            checkoutBtn.addEventListener('click', function() {
                if (cart.length === 0) {
                    showMessage('Your cart is empty!', 'error');
                    return;
                }
                window.location.href = 'checkout.php';
            });

            // Initial cart display
            updateCartDisplay();
        });
    </script>
</body>
</html>