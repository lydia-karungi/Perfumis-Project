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
    <title>Secure Checkout - Perfumis</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Nunito', sans-serif;
        }

        .checkout-hero {
            background: linear-gradient(135deg, #bf2e1a 0%, #d73527 100%);
            color: white;
            padding: 40px 0;
            text-align: center;
            position: relative;
        }

        .checkout-hero h1 {
            font-family: 'Dancing Script', cursive;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .checkout-hero p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .checkout-container {
            max-width: 1200px;
            margin: -20px auto 50px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 40px;
        }

        .checkout-form-section {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
            color: #333;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section {
            margin-bottom: 40px;
        }

        .form-section h3 {
            color: #bf2e1a;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            font-family: 'Nunito', sans-serif;
            transition: all 0.3s ease;
            background: #fff;
            color: #333;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #bf2e1a;
            box-shadow: 0 0 0 4px rgba(191, 46, 26, 0.1);
            transform: translateY(-2px);
        }

        .form-group input.valid {
            border-color: #4caf50;
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
        }

        .form-group input.error,
        .form-group select.error,
        .form-group textarea.error {
            border-color: #f44336;
            box-shadow: 0 0 0 4px rgba(244, 67, 54, 0.1);
        }

        .error-message {
            color: #f44336;
            font-size: 12px;
            margin-top: 5px;
            padding: 5px 10px;
            background: #fce4ec;
            border-radius: 6px;
            border: 1px solid #f8bbd9;
            display: none;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .card-input {
            position: relative;
        }

        .card-input input {
            padding-left: 50px;
        }

        .card-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #666;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .payment-method {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .payment-method:hover {
            border-color: #bf2e1a;
            transform: translateY(-2px);
        }

        .payment-method.selected {
            border-color: #bf2e1a;
            background: rgba(191, 46, 26, 0.05);
        }

        .payment-method img {
            height: 30px;
            object-fit: contain;
        }

        .order-summary {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .summary-title {
            font-family: 'Dancing Script', cursive;
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .order-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item:last-of-type {
            border-bottom: none;
        }

        .order-item img {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
        }

        .order-item-details {
            flex: 1;
        }

        .order-item-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .order-item-price {
            color: #666;
            font-size: 13px;
        }

        .order-item-quantity {
            font-weight: 600;
            color: #bf2e1a;
            font-size: 14px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
            margin-top: 20px;
        }

        .summary-row:last-child {
            border-bottom: none;
            padding-top: 20px;
            margin-top: 10px;
            border-top: 2px solid #bf2e1a;
        }

        .summary-label {
            color: #666;
            font-weight: 500;
        }

        .summary-value {
            font-weight: 600;
            color: #333;
        }

        .total-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #bf2e1a;
        }

        .place-order-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #bf2e1a, #d73527);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 30px;
            position: relative;
            overflow: hidden;
        }

        .place-order-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .place-order-btn:hover::before {
            left: 100%;
        }

        .place-order-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(191, 46, 26, 0.4);
        }

        .place-order-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .security-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            padding: 15px;
            background: rgba(76, 175, 80, 0.1);
            border-radius: 10px;
            color: #2e7d32;
            font-size: 14px;
        }

        .message-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            color: #333;
            padding: 20px 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border-left: 5px solid #4CAF50;
            display: none;
            z-index: 1000;
            animation: slideInRight 0.3s ease-out;
            max-width: 350px;
        }

        .message-toast.error {
            border-left-color: #f44336;
        }

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

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive Design */
        @media (max-width: 968px) {
            .checkout-container {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            
            .order-summary {
                position: static;
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .checkout-hero h1 {
                font-size: 2.5rem;
            }
            
            .checkout-form-section,
            .order-summary {
                padding: 30px 20px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .payment-methods {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <div class="checkout-hero">
        <h1>Secure Checkout</h1>
        <p>Complete your order safely and securely</p>
    </div>

    <main>
        <div class="checkout-container">
            <div class="checkout-form-section">
                <h2 class="section-title">
                    <i class="fas fa-lock"></i> Checkout Details
                </h2>

                <form id="checkoutForm">
                    <!-- Payment Information -->
                    <div class="form-section">
                        <h3><i class="fas fa-credit-card"></i> Payment Method</h3>
                        
                        <div class="payment-methods">
                            <div class="payment-method" data-method="credit_card">
                                <i class="fab fa-cc-visa" style="font-size: 30px; color: #1a1f71;"></i>
                            </div>
                            <div class="payment-method" data-method="credit_card">
                                <i class="fab fa-cc-mastercard" style="font-size: 30px; color: #eb001b;"></i>
                            </div>
                            <div class="payment-method" data-method="paypal">
                                <i class="fab fa-cc-paypal" style="font-size: 30px; color: #003087;"></i>
                            </div>
                            <div class="payment-method" data-method="bank_transfer">
                                <i class="fas fa-university" style="font-size: 24px; color: #333;"></i>
                            </div>
                        </div>

                        <input type="hidden" id="paymentMethod" name="paymentMethod" required>
                        <div class="error-message" id="paymentMethodError">Please select a payment method.</div>

                        <div class="form-group">
                            <label for="name">Cardholder Name</label>
                            <input type="text" id="name" name="name" placeholder="John Doe" required>
                            <div class="error-message" id="nameError">Please enter the cardholder name.</div>
                        </div>

                        <div class="form-group card-input">
                            <label for="cardNumber">Card Number</label>
                            <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19" required>
                            <i class="fas fa-credit-card card-icon"></i>
                            <div class="error-message" id="cardNumberError">Please enter a valid card number.</div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="expiryDate">Expiry Date</label>
                                <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" pattern="(0[1-9]|1[0-2])\/?([0-9]{2})" required>
                                <div class="error-message" id="expiryDateError">Please enter a valid expiry date.</div>
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="4" required>
                                <div class="error-message" id="cvvError">Please enter a valid CVV.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="form-section">
                        <h3><i class="fas fa-shipping-fast"></i> Shipping Information</h3>
                        
                        <div class="form-group">
                            <label for="shippingAddress">Shipping Address</label>
                            <textarea id="shippingAddress" name="shippingAddress" rows="3" placeholder="123 Main Street, Brisbane, QLD 4000" required></textarea>
                            <div class="error-message" id="shippingAddressError">Please enter the shipping address.</div>
                        </div>

                        <div class="form-group">
                            <label for="billingAddress">Billing Address</label>
                            <textarea id="billingAddress" name="billingAddress" rows="3" placeholder="Same as shipping address" required></textarea>
                            <div class="error-message" id="billingAddressError">Please enter the billing address.</div>
                        </div>

                        <div class="form-group">
                            <label for="additionalNotes">Order Notes (Optional)</label>
                            <textarea id="additionalNotes" name="additionalNotes" rows="3" placeholder="Special delivery instructions or gift message..."></textarea>
                        </div>
                    </div>

                    <input type="hidden" id="totalAmount" name="totalAmount">
                </form>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3 class="summary-title">Order Summary</h3>
                
                <div id="order-items">
                    <!-- Order items will be dynamically inserted here -->
                </div>
                
                <div class="summary-row">
                    <span class="summary-label">Subtotal:</span>
                    <span class="summary-value" id="subtotal">$0.00</span>
                </div>
                
                <div class="summary-row">
                    <span class="summary-label">Shipping:</span>
                    <span class="summary-value">Free</span>
                </div>
                
                <div class="summary-row">
                    <span class="summary-label">Tax:</span>
                    <span class="summary-value">$0.00</span>
                </div>
                
                <div class="summary-row">
                    <span class="summary-label">Total:</span>
                    <span class="summary-value total-value" id="total-price">$0.00</span>
                </div>
                
                <button type="submit" form="checkoutForm" class="place-order-btn" id="placeOrderBtn">
                    <span id="btnText"><i class="fas fa-lock"></i> Place Order</span>
                </button>
                
                <div class="security-info">
                    <i class="fas fa-shield-alt"></i>
                    <span>Your payment information is secure and encrypted</span>
                </div>
            </div>
        </div>
        
        <div class="message-toast" id="messageToast"></div>
    </main>

    <footer>
        <?php include 'footer.php'; ?>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const orderItemsContainer = document.getElementById('order-items');
            const subtotalElement = document.getElementById('subtotal');
            const totalPriceElement = document.getElementById('total-price');
            const totalAmountInput = document.getElementById('totalAmount');
            const messageToast = document.getElementById('messageToast');
            const checkoutForm = document.getElementById('checkoutForm');
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const btnText = document.getElementById('btnText');

            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            let totalPrice = 0;

            // Display order items and calculate total
            function displayOrderSummary() {
                if (cart.length === 0) {
                    window.location.href = 'cart.php';
                    return;
                }

                orderItemsContainer.innerHTML = '';
                totalPrice = 0;

                cart.forEach(item => {
                    const itemTotal = parseFloat(item.price) * parseInt(item.quantity);
                    totalPrice += itemTotal;

                    const orderItem = document.createElement('div');
                    orderItem.classList.add('order-item');
                    orderItem.innerHTML = `
                        <img src="${item.image || item.image_url || 'perfume_images/default.jpg'}" alt="${item.name}" onerror="this.src='perfume_images/default.jpg'">
                        <div class="order-item-details">
                            <div class="order-item-name">${item.name}</div>
                            <div class="order-item-price">${parseFloat(item.price).toFixed(2)} each</div>
                        </div>
                        <div class="order-item-quantity">×${item.quantity}</div>
                    `;
                    orderItemsContainer.appendChild(orderItem);
                });

                subtotalElement.textContent = `${totalPrice.toFixed(2)}`;
                totalPriceElement.textContent = `${totalPrice.toFixed(2)}`;
                totalAmountInput.value = totalPrice.toFixed(2);
            }

            // Payment method selection
            document.querySelectorAll('.payment-method').forEach(method => {
                method.addEventListener('click', function() {
                    document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
                    this.classList.add('selected');
                    document.getElementById('paymentMethod').value = this.dataset.method;
                    hideError('paymentMethodError');
                });
            });

            // Card number formatting
            document.getElementById('cardNumber').addEventListener('input', function() {
                let value = this.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                this.value = formattedValue;
            });

            // Expiry date formatting
            document.getElementById('expiryDate').addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                this.value = value;
            });

            // CVV validation
            document.getElementById('cvv').addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });

            // Form validation functions
            function showError(elementId, message) {
                const errorElement = document.getElementById(elementId);
                const inputElement = document.getElementById(elementId.replace('Error', ''));
                
                errorElement.textContent = message;
                errorElement.style.display = 'block';
                if (inputElement) {
                    inputElement.classList.add('error');
                }
            }

            function hideError(elementId) {
                const errorElement = document.getElementById(elementId);
                const inputElement = document.getElementById(elementId.replace('Error', ''));
                
                errorElement.style.display = 'none';
                if (inputElement) {
                    inputElement.classList.remove('error');
                    inputElement.classList.add('valid');
                }
            }

            function showMessage(message, type = 'success') {
                messageToast.textContent = message;
                messageToast.className = `message-toast ${type}`;
                messageToast.style.display = 'block';
                
                setTimeout(() => {
                    messageToast.style.display = 'none';
                }, 5000);
            }

            // Form submission
            checkoutForm.addEventListener('submit', function(event) {
                event.preventDefault();
                
                let isValid = true;

                // Reset all errors
                document.querySelectorAll('.error-message').forEach(error => error.style.display = 'none');
                document.querySelectorAll('input, select, textarea').forEach(input => {
                    input.classList.remove('error', 'valid');
                });

                // Validate payment method
                if (!document.getElementById('paymentMethod').value) {
                    showError('paymentMethodError', 'Please select a payment method.');
                    isValid = false;
                }

                // Validate cardholder name
                const name = document.getElementById('name').value.trim();
                if (!name) {
                    showError('nameError', 'Please enter the cardholder name.');
                    isValid = false;
                }

                // Validate card number
                const cardNumber = document.getElementById('cardNumber').value.replace(/\s+/g, '');
                if (!/^[0-9]{16}$/.test(cardNumber)) {
                    showError('cardNumberError', 'Please enter a valid 16-digit card number.');
                    isValid = false;
                }

                // Validate expiry date
                const expiryDate = document.getElementById('expiryDate').value;
                if (!/^(0[1-9]|1[0-2])\/([0-9]{2})$/.test(expiryDate)) {
                    showError('expiryDateError', 'Please enter a valid expiry date (MM/YY).');
                    isValid = false;
                }

                // Validate CVV
                const cvv = document.getElementById('cvv').value;
                if (!/^[0-9]{3,4}$/.test(cvv)) {
                    showError('cvvError', 'Please enter a valid 3 or 4-digit CVV.');
                    isValid = false;
                }

                // Validate shipping address
                const shippingAddress = document.getElementById('shippingAddress').value.trim();
                if (!shippingAddress) {
                    showError('shippingAddressError', 'Please enter the shipping address.');
                    isValid = false;
                }

                // Validate billing address
                const billingAddress = document.getElementById('billingAddress').value.trim();
                if (!billingAddress) {
                    showError('billingAddressError', 'Please enter the billing address.');
                    isValid = false;
                }

                if (!isValid) {
                    showMessage('Please correct the errors in the form.', 'error');
                    return;
                }

                // Show loading state
                placeOrderBtn.disabled = true;
                btnText.innerHTML = '<span class="loading-spinner"></span>Processing Order...';

                // Submit the form
                const formData = new FormData(checkoutForm);
                
                fetch('fetch_products.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.text())
                .then(responseText => {
                    if (responseText.includes('Order placed successfully!') || responseText.includes('successful')) {
                        // Clear the cart
                        localStorage.removeItem('cart');
                        
                        // Show success message
                        showMessage('Order placed successfully! Redirecting...', 'success');
                        btnText.innerHTML = '<i class="fas fa-check"></i> Order Placed!';
                        placeOrderBtn.style.background = 'linear-gradient(135deg, #4caf50, #45a049)';
                        
                        // Redirect after delay
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 2000);
                    } else {
                        throw new Error(responseText);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('There was an issue placing your order. Please try again.', 'error');
                    
                    // Reset button
                    placeOrderBtn.disabled = false;
                    btnText.innerHTML = '<i class="fas fa-lock"></i> Place Order';
                });
            });

            // Initialize
            displayOrderSummary();
        });
    </script>
</body>
</html>