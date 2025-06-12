<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) {
    header("Location: login.html"); // Redirect to the login page
    exit(); // Stop further execution to prevent loading the cart page content
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .product-details-container {
            display: flex;
            flex-direction: row;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-details-image {
            flex: 1;
            max-width: 50%;
            padding: 10px;
        }

        .product-details-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product-details-info {
            flex: 2;
            padding: 10px;
        }

        .product-details-info h1 {
            font-size: 2rem;
            margin: 20px 0;
        }

        .product-details-info p,
        .product-details-info ul {
            font-size: 1rem;
            color: #666;
            margin: 20px 0;
            text-align: left;
        }

        .product-details-info form {
            margin: 20px 0;
        }

        .product-details-info label {
            font-size: 1rem;
            margin-right: 10px;
        }

        .product-details-info input[type="number"] {
            width: 60px;
            padding: 5px;
            font-size: 1rem;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .product-details-info button {
            padding: 10px 20px;
            font-size: 1rem;
            background-color: #bf2e1a;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .product-details-info button:hover {
            background-color: #b95950;
        }

        .product-details-info a {
            display: inline-block;
            margin: 10px;
            color: #bf2e1a;
            text-decoration: none;
        }

        .product-details-info a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main id="product-details-main">
        <div class="product-details-container">
            <div class="product-details-image">
                <img id="product-image" src="" alt="">
            </div>
            <div class="product-details-info">
                <h1 id="product-name"></h1>
                <div id="product-description"></div>
                <form id="cartForm">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
<?php include 'footer.php'; ?>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('id');

            if (productId) {
                fetch('fetch_products.php?id=' + productId)
                    .then(response => response.json())
                    .then(product => {
                        document.getElementById('product-image').src = product.image;
                        document.getElementById('product-name').textContent = product.name;
                        document.getElementById('product-description').innerHTML = product.description; // Use innerHTML to render HTML content

                        document.getElementById('cartForm').addEventListener('submit', function (event) {
                            event.preventDefault();
                            const quantity = document.getElementById('quantity').value;
                            addToCart(product, quantity);
                            window.location.href = 'cart.php'; // Redirect to the cart page
                        });
                    })
                    .catch(error => console.error('Error fetching product:', error));
            } else {
                console.error('No product ID provided');
            }

            function addToCart(product, quantity) {
                const cart = JSON.parse(localStorage.getItem('cart')) || [];
                const cartItem = cart.find(item => item.id === product.id);
                if (cartItem) {
                    cartItem.quantity += parseInt(quantity, 10);
                } else {
                    cart.push({ ...product, quantity: parseInt(quantity, 10) });
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                alert(`${product.name} has been added to your cart.`);
            }
        });
    </script>
</body>

</html>
