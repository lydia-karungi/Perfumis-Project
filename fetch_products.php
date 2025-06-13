<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to JSON at the beginning
header('Content-Type: application/json');

try {
    // Load environment variables from .env file manually
    function loadEnv($path) {
        if (!file_exists($path)) {
            throw new Exception('.env file not found');
        }
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; // Skip comments
            }
            
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
    
    // Load .env file
    loadEnv(__DIR__ . '/.env');

    // Database connection settings from .env file
    $servername = $_ENV['DB_SERVERNAME'] ?? '127.0.0.1';
    $username = $_ENV['DB_USERNAME'] ?? 'root';
    $password = $_ENV['DB_PASSWORD'] ?? '';
    $dbname = $_ENV['DB_NAME'] ?? 'perfumis_db';

    // Create a new database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the database connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
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
            echo json_encode(['error' => 'User not logged in']);
            exit;
        }

        // Retrieve form data for the order
        $name = $_POST['name'] ?? '';
        $cardNumber = $_POST['cardNumber'] ?? '';
        $expiryDate = $_POST['expiryDate'] ?? '';
        $cvv = $_POST['cvv'] ?? '';
        $paymentMethod = $_POST['paymentMethod'] ?? '';
        $shippingAddress = $_POST['shippingAddress'] ?? '';
        $billingAddress = $_POST['billingAddress'] ?? '';
        $additionalNotes = $_POST['additionalNotes'] ?? '';
        $totalAmount = $_POST['totalAmount'] ?? 0;

        // Insert order data into the database (using your schema)
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, order_type, channel) VALUES (?, ?, 'Online', 'web')");
        $stmt->bind_param("id", $user_id, $totalAmount);
        $stmt->execute();

        // Check if the order was successfully placed
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => 'Order placed successfully!']);
        } else {
            echo json_encode(['error' => 'Error placing order: ' . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
        exit;
    }

    // Handle form submission for support tickets
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
        // Retrieve form data for the ticket
        $ticketName = $_POST['name'];
        $ticketEmail = $_POST['email'];
        $ticketMessage = $_POST['message'];

        // Insert ticket data into the database (using your schema)
        $stmt = $conn->prepare("INSERT INTO tickets (user_id, subject, description) VALUES (?, 'General Inquiry', ?)");
        $stmt->bind_param("is", $user_id, $ticketMessage);
        $stmt->execute();

        // Check if the ticket was successfully submitted
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => 'Ticket submitted successfully!']);
        } else {
            echo json_encode(['error' => 'Error submitting ticket: ' . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
        exit;
    }

    // Only handle GET requests for fetching products from this point
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        echo json_encode(['error' => 'Method not allowed']);
        exit;
    }

    // Fetch products based on the provided filters
    $product_id = isset($_GET['id']) ? intval($_GET['id']) : null;
    $minPrice = isset($_GET['minPrice']) ? floatval($_GET['minPrice']) : 0;
    $maxPrice = isset($_GET['maxPrice']) ? floatval($_GET['maxPrice']) : 999999;
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';
    $availability = isset($_GET['availability']) ? trim($_GET['availability']) : '';

    // Fetch a single product by ID
    if ($product_id) {
        $stmt = $conn->prepare("SELECT product_id as id, name, description, price, stock, category_id, image_url FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
        $conn->close();

        if ($product) {
            // Database already has correct image URLs, no need to modify
            echo json_encode($product);
        } else {
            echo json_encode(['error' => 'Product not found']);
        }
        exit;
    }

    // Base query to fetch products (using your actual schema column names)
    $query = "SELECT p.product_id as id, p.name, p.description, p.price, p.stock, p.category_id, p.image_url 
              FROM products p WHERE p.price >= ? AND p.price <= ?";
    $types = 'dd';
    $params = [$minPrice, $maxPrice];

    // Add additional filters based on category and availability
    if ($category) {
        // Map common category names to your database values
        $categoryMapping = [
            'men' => "Men's Fragrance",
            'women' => "Women's Fragrance", 
            'unisex' => 'Unisex',
            'luxury' => 'Luxury Scents',
            'bestsellers' => 'Best Sellers',
            'new-arrivals' => 'New Arrivals',
            'gifts' => 'Gift Sets',
            'everyday' => 'Everyday Wear'
        ];
        
        $dbCategory = $categoryMapping[strtolower($category)] ?? $category;
        
        // Fetch products by category name
        $query .= " AND p.category_id = (SELECT category_id FROM categories WHERE category_name = ?)";
        $types .= 's';
        $params[] = $dbCategory;
        
        if ($availability) {
            $query .= $availability === 'available' ? " AND p.stock > 0" : " AND p.stock = 0";
        }
    } else {
        // Add availability filter if no category is specified
        if ($availability) {
            $query .= $availability === 'available' ? " AND p.stock > 0" : " AND p.stock = 0";
        }
    }

    // Add ORDER BY clause to get consistent results
    $query .= " ORDER BY p.product_id ASC";

    // Prepare and execute the query
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Bind parameters to the prepared statement
    if ($category) {
        $stmt->bind_param($types, $minPrice, $maxPrice, $dbCategory);
    } else {
        $stmt->bind_param('dd', $minPrice, $maxPrice);
    }

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    // Fetch all matching products
    $products = [];
    while ($row = $result->fetch_assoc()) {
        // Database already has correct image URLs, no need to modify
        $products[] = $row;
    }

    $stmt->close();
    $conn->close();

    // Return the products as a JSON response
    echo json_encode($products);

} catch (Exception $e) {
    // Handle any errors
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>