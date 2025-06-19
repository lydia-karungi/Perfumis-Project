<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Simple function to load .env file manually (no Composer needed)
function loadEnv($path) {
    if (!file_exists($path)) {
        // If no .env file, use default values
        return [
            'DB_SERVERNAME' => 'localhost',
            'DB_USERNAME' => 'root',
            'DB_PASSWORD' => '',
            'DB_NAME' => 'perfumis_db'
        ];
    }
    
    $env = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $env[trim($name)] = trim($value);
        }
    }
    
    return $env;
}

// Load environment variables
$env = loadEnv(__DIR__ . '/.env');

// Database connection settings
$servername = $env['DB_SERVERNAME'] ?? 'localhost';
$username = $env['DB_USERNAME'] ?? 'root';
$password = $env['DB_PASSWORD'] ?? '';
$dbname = $env['DB_NAME'] ?? 'perfumis_db';

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the email and password from POST
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $plainPassword = isset($_POST['password']) ? $_POST['password'] : '';

        if (empty($email) || empty($plainPassword)) {
            echo "Please enter both email and password.";
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
            exit;
        }

        // Check if user exists and get password
        // Try both 'user_id' and 'id' to be compatible with different schemas
        $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ? LIMIT 1");
        if (!$stmt) {
            // If user_id doesn't exist, try with 'id'
            $stmt = $conn->prepare("SELECT id as user_id, password FROM users WHERE email = ? LIMIT 1");
        }
        
        if (!$stmt) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists, verify password
            $row = $result->fetch_assoc();
            
            if (password_verify($plainPassword, $row['password'])) {
                // Password is correct, login successful
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_email'] = $email;
                
                echo "Login successful! Redirecting...";
            } else {
                // Password is incorrect
                echo "Invalid email or password!";
            }
        } else {
            // User does not exist
            echo "Invalid email or password!";
        }

        $stmt->close();
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Close connection if it exists
    if (isset($conn) && $conn) {
        $conn->close();
    }
}
?>