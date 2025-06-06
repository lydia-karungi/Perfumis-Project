<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Autoload dependencies using Composer
require 'vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env file to manage environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database connection settings from .env file
$servername = $_ENV['DB_SERVERNAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get user ID from session, if available
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Handle order placement
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cardNumber'])) {
    // Check if the user is logged in
    if (!$user_id) {
        echo "Error: User not logged in.";
        exit;
    }

    // Retrieve form data for the order
    $name = $_POST['name'];
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];
    $paymentMethod = $_POST['paymentMethod'];
    $shippingAddress = $_POST['shippingAddress'];
    $billingAddress = $_POST['billingAddress'];
    $additionalNotes = $_POST['additionalNotes'];
    $totalAmount = $_POST['totalAmount'];

    // Insert order data into the database
    $stmt = $conn->prepare("INSERT INTO orders (id, order_date, total_amount, status, payment_method, shipping_address, billing_address, additional_notes) VALUES (?, NOW(), ?, 'pending', ?, ?, ?, ?)");
    $stmt->bind_param("idssss", $user_id, $totalAmount, $paymentMethod, $shippingAddress, $billingAddress, $additionalNotes);
    $stmt->execute();

    // Check if the order was successfully placed
    if ($stmt->affected_rows > 0) {
        echo "Order placed successfully!";
    } else {
        echo "Error placing order: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Stop further execution to prevent mixed output
    exit;
}

// Handle form submission for support tickets
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    // Retrieve form data for the ticket
    $ticketName = $_POST['name'];
    $ticketEmail = $_POST['email'];
    $ticketMessage = $_POST['message'];

    // Insert ticket data into the database
    $stmt = $conn->prepare("INSERT INTO ticket (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $ticketName, $ticketEmail, $ticketMessage);
    $stmt->execute();

    // Check if the ticket was successfully submitted
    if ($stmt->affected_rows > 0) {
        echo "Ticket submitted successfully!";
    } else {
        echo "Error submitting ticket: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Stop further execution to prevent mixed output
    exit;
}

// Fetch products based on the provided filters
$product_id = isset($_GET['id']) ? $_GET['id'] : null;
$minPrice = isset($_GET['minPrice']) ? $_GET['minPrice'] : 0;
$maxPrice = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : 999999;
$category = isset($_GET['category']) ? $_GET['category'] : '';
$availability = isset($_GET['availability']) ? $_GET['availability'] : '';

// Fetch a single product by ID
if ($product_id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    // Return the product as a JSON response
    header('Content-Type: application/json');
    echo json_encode($product);
    exit;
}

// Base query to fetch products
$query = "SELECT p.* FROM products p WHERE p.price >= ? AND p.price <= ?";
$types = 'dd';
$params = [$minPrice, $maxPrice];

// Add additional filters based on category and availability
if ($category) {
    if ($category === 'collections') {
        // Fetch products from collections
        $query = "SELECT p.* FROM products p
                  JOIN collection_products cp ON p.id = cp.product_id
                  JOIN collections c ON cp.collection_id = c.id
                  WHERE p.price >= ? AND p.price <= ?";
        if ($availability) {
            $query .= $availability === 'available' ? " AND p.stock > 0" : " AND p.stock = 0";
        }
    } else {
        // Fetch products by category
        $query .= " AND p.category_id = (SELECT id FROM categories WHERE name = ?)";
        $types .= 's';
        $params[] = $category;
        if ($availability) {
            $query .= $availability === 'available' ? " AND p.stock > 0" : " AND p.stock = 0";
        }
    }
} else {
    // Add availability filter if no category is specified
    if ($availability) {
        $query .= $availability === 'available' ? " AND p.stock > 0" : " AND p.stock = 0";
    }
}

// Prepare and execute the query
$stmt = $conn->prepare($query);

// Bind parameters to the prepared statement
if ($category === 'collections') {
    $stmt->bind_param($types, $minPrice, $maxPrice);
} elseif ($category) {
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param("dd", $minPrice, $maxPrice);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch all matching products
$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

$stmt->close();
$conn->close();

// Return the products as a JSON response
header('Content-Type: application/json');
echo json_encode($products);
?>
