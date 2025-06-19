<?php
// save_quiz_results.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set content type to JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

try {
    // Load environment variables from .env file
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

    // Database connection
    $servername = $_ENV['DB_SERVERNAME'] ?? '127.0.0.1';
    $username = $_ENV['DB_USERNAME'] ?? 'root';
    $password = $_ENV['DB_PASSWORD'] ?? '';
    $dbname = $_ENV['DB_NAME'] ?? 'perfumis_db';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get JSON input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!$data) {
        throw new Exception('Invalid JSON data');
    }

    // Log the received data for debugging
    error_log("Quiz data received: " . print_r($data, true));

    $user_id = $_SESSION['user_id'];
    $profile = $data['profile'] ?? '';
    $answers = json_encode($data['answers'] ?? []);
    $recommendations = json_encode($data['recommendations'] ?? []);

    // First, check if quiz_results table exists, if not create it
    $tableCheck = $conn->query("SHOW TABLES LIKE 'quiz_results'");
    if ($tableCheck->num_rows == 0) {
        $createTable = "
            CREATE TABLE quiz_results (
                result_id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                quiz_answers JSON,
                recommended_scent_profile VARCHAR(100),
                recommended_products JSON,
                quiz_completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_user_id (user_id)
            )
        ";
        
        if (!$conn->query($createTable)) {
            throw new Exception('Failed to create quiz_results table: ' . $conn->error);
        }
    }

    // Insert quiz results
    $stmt = $conn->prepare("
        INSERT INTO quiz_results (user_id, quiz_answers, recommended_scent_profile, recommended_products, quiz_completed_at) 
        VALUES (?, ?, ?, ?, NOW())
    ");
    
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }
    
    $stmt->bind_param("isss", $user_id, $answers, $profile, $recommendations);
    
    if ($stmt->execute()) {
        $result_id = $conn->insert_id;
        
        // Log success
        error_log("Quiz results saved successfully. Result ID: $result_id, User ID: $user_id");
        
        echo json_encode([
            'success' => true,
            'message' => 'Quiz results saved successfully',
            'result_id' => $result_id,
            'user_id' => $user_id,
            'profile' => $profile
        ]);
    } else {
        throw new Exception('Failed to save quiz results: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    // Log the error
    error_log("Quiz save error: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}
?>