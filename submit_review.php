<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to JSON
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

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

    // Start session to get user ID
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Get the JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!$data) {
        throw new Exception('Invalid JSON data');
    }

    // Validate required fields
    $name = trim($data['name'] ?? '');
    $rating = intval($data['rating'] ?? 0);
    $review = trim($data['review'] ?? '');

    if (empty($name)) {
        echo json_encode(['error' => 'Name is required']);
        exit;
    }

    if ($rating < 1 || $rating > 5) {
        echo json_encode(['error' => 'Rating must be between 1 and 5']);
        exit;
    }

    if (empty($review)) {
        echo json_encode(['error' => 'Review text is required']);
        exit;
    }

    // Get user ID from session (if logged in) or set to NULL
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    // For demonstration, we'll use a default product_id (you can modify this logic)
    // In a real scenario, you might want to pass product_id from the frontend
    // or have a general review section
    $product_id = intval($data['product_id'] ?? 1); // Default to product 1

    // If no user is logged in, create a guest review with just the name
    if (!$user_id) {
        // Check if we need to create a temporary user or handle guest reviews
        // For now, let's allow guest reviews by setting user_id to NULL
        // But first, let's see if your reviews table allows NULL user_id
        
        // Insert the review with NULL user_id for guest reviews
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, product_id, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiis", $user_id, $product_id, $rating, $review);
    } else {
        // User is logged in, use their user_id
        $stmt = $conn->prepare("INSERT INTO reviews (user_id, product_id, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiis", $user_id, $product_id, $rating, $review);
    }

    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    if ($stmt->affected_rows > 0) {
        $review_id = $conn->insert_id;
        
        // Get the newly created review with user name for immediate display
        $fetch_stmt = $conn->prepare("
            SELECT 
                r.review_id,
                r.rating,
                r.comment as review_text,
                r.created_at,
                COALESCE(u.name, ?) as reviewer_name,
                p.name as product_name
            FROM reviews r
            LEFT JOIN users u ON r.user_id = u.user_id
            LEFT JOIN products p ON r.product_id = p.product_id
            WHERE r.review_id = ?
        ");
        
        $fetch_stmt->bind_param("si", $name, $review_id);
        $fetch_stmt->execute();
        $result = $fetch_stmt->get_result();
        $new_review = $result->fetch_assoc();
        
        $fetch_stmt->close();
        
        echo json_encode([
            'success' => true,
            'message' => 'Review submitted successfully!',
            'review' => $new_review
        ]);
    } else {
        echo json_encode(['error' => 'Failed to submit review']);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    // Handle any errors
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>