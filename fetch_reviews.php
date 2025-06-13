<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to JSON
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

    // Check what type of request this is
    $fetch_type = $_GET['fetch'] ?? '';

    if ($fetch_type === 'reviews') {
        // Fetch reviews with user names and product names
        $query = "SELECT 
                    r.review_id,
                    r.rating,
                    r.comment as review_text,
                    r.created_at,
                    COALESCE(u.name, 'Guest Customer') as reviewer_name,
                    p.name as product_name
                  FROM reviews r
                  LEFT JOIN users u ON r.user_id = u.user_id
                  LEFT JOIN products p ON r.product_id = p.product_id
                  ORDER BY r.created_at DESC
                  LIMIT 20";

        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $reviews = [];

        while ($row = $result->fetch_assoc()) {
            $reviews[] = [
                'review_id' => $row['review_id'],
                'reviewer_name' => $row['reviewer_name'] ?: 'Anonymous Customer',
                'product_name' => $row['product_name'] ?: 'Product',
                'rating' => (int)$row['rating'],
                'review_text' => $row['review_text'],
                'created_at' => $row['created_at']
            ];
        }

        $stmt->close();
        $conn->close();

        echo json_encode($reviews);

    } elseif ($fetch_type === 'products') {
        // Fetch products for the review dropdown
        $query = "SELECT product_id, name FROM products ORDER BY name ASC";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = [
                'product_id' => $row['product_id'],
                'name' => $row['name']
            ];
        }

        $stmt->close();
        $conn->close();

        echo json_encode($products);
    } else {
        // Invalid fetch type
        echo json_encode(['error' => 'Invalid fetch type']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>