<?php
// fetch_quiz_recommendations.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

try {
    // Load environment variables
    function loadEnv($path) {
        if (!file_exists($path)) {
            throw new Exception('.env file not found');
        }
        
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
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
    
    loadEnv(__DIR__ . '/.env');

    // Database connection settings from .env file
    $servername = $_ENV['DB_HOST'] ?? '127.0.0.1';
    $username   = $_ENV['DB_USER'] ?? 'root';
    $password   = $_ENV['DB_PASS'] ?? '';
    $dbname     = $_ENV['DB_NAME'] ?? 'perfumis_db';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get the scent profile from request
    $profile = $_GET['profile'] ?? '';
    
    if (empty($profile)) {
        throw new Exception('Profile parameter is required');
    }

    // Map scent profiles to category preferences and search terms
    $profileMappings = [
        'Fresh & Clean' => [
            'categories' => ["Men's Fragrance", "Women's Fragrance", "Unisex"],
            'keywords' => ['fresh', 'clean', 'citrus', 'ocean', 'breeze', 'light', 'aqua', 'marine'],
            'avoid_keywords' => ['dark', 'heavy', 'intense', 'bold']
        ],
        'Romantic & Feminine' => [
            'categories' => ["Women's Fragrance", "Unisex"],
            'keywords' => ['rose', 'floral', 'garden', 'bloom', 'sweet', 'romantic', 'velvet', 'soft'],
            'avoid_keywords' => ['woody', 'masculine', 'intense']
        ],
        'Bold & Confident' => [
            'categories' => ["Men's Fragrance", "Unisex", "Luxury Scents"],
            'keywords' => ['bold', 'intense', 'dark', 'midnight', 'strong', 'oud', 'black', 'statement'],
            'avoid_keywords' => ['light', 'delicate', 'soft']
        ],
        'Warm & Sophisticated' => [
            'categories' => ["Men's Fragrance", "Women's Fragrance", "Luxury Scents"],
            'keywords' => ['warm', 'amber', 'wood', 'sandalwood', 'spice', 'vanilla', 'sophisticated'],
            'avoid_keywords' => ['fresh', 'citrus', 'light']
        ]
    ];

    $mapping = $profileMappings[$profile] ?? $profileMappings['Fresh & Clean'];
    
    // Build the SQL query to find matching products
    $categoryConditions = "'" . implode("','", $mapping['categories']) . "'";
    
    // Create keyword matching conditions
    $keywordConditions = [];
    foreach ($mapping['keywords'] as $keyword) {
        $keywordConditions[] = "(p.name LIKE '%$keyword%' OR p.description LIKE '%$keyword%')";
    }
    
    $avoidConditions = [];
    foreach ($mapping['avoid_keywords'] as $avoid) {
        $avoidConditions[] = "(p.name NOT LIKE '%$avoid%' AND p.description NOT LIKE '%$avoid%')";
    }

    $query = "
        SELECT 
            p.product_id as id,
            p.name,
            p.description,
            p.price,
            p.stock,
            p.image_url,
            c.category_name,
            (
                CASE 
                    WHEN " . implode(' OR ', $keywordConditions) . " THEN 2
                    ELSE 1
                END
            ) as relevance_score
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.category_id
        WHERE c.category_name IN ($categoryConditions)
        AND p.stock > 0
        " . (count($avoidConditions) > 0 ? "AND " . implode(' AND ', $avoidConditions) : "") . "
        ORDER BY relevance_score DESC, p.price ASC
        LIMIT 6
    ";

    $result = $conn->query($query);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    $recommendations = [];
    while ($row = $result->fetch_assoc()) {
        $recommendations[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => floatval($row['price']),
            'category' => $row['category_name'],
            'image_url' => $row['image_url'],
            'description' => $row['description'],
            'stock' => $row['stock']
        ];
    }

    // If we don't have enough recommendations, get some popular products
    if (count($recommendations) < 3) {
        $fallbackQuery = "
            SELECT 
                p.product_id as id,
                p.name,
                p.description,
                p.price,
                p.stock,
                p.image_url,
                c.category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.category_id
            WHERE p.stock > 0
            AND c.category_name IN ($categoryConditions)
            ORDER BY p.price ASC
            LIMIT " . (6 - count($recommendations));
        
        $fallbackResult = $conn->query($fallbackQuery);
        
        if ($fallbackResult) {
            while ($row = $fallbackResult->fetch_assoc()) {
                // Check if this product is already in recommendations
                $exists = false;
                foreach ($recommendations as $existing) {
                    if ($existing['id'] == $row['id']) {
                        $exists = true;
                        break;
                    }
                }
                
                if (!$exists) {
                    $recommendations[] = [
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'price' => floatval($row['price']),
                        'category' => $row['category_name'],
                        'image_url' => $row['image_url'],
                        'description' => $row['description'],
                        'stock' => $row['stock']
                    ];
                }
            }
        }
    }

    $conn->close();

    echo json_encode([
        'success' => true,
        'profile' => $profile,
        'recommendations' => $recommendations,
        'total_found' => count($recommendations)
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}
?>