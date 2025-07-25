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
            'DB_HOST' => 'localhost',
            'DB_USER' => 'root',
            'DB_PASS' => '',
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

// Database connection settings from .env file
$servername = $_ENV['DB_HOST'] ?? '127.0.0.1';
$username   = $_ENV['DB_USER'] ?? 'root';
$password   = $_ENV['DB_PASS'] ?? '';
$dbname     = $_ENV['DB_NAME'] ?? 'perfumis_db';

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Validate input
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        throw new Exception("Email and password are required!");
    }

    $email = trim($_POST['email']);
    $plainPassword = $_POST['password'];

    // Basic validation
    if (empty($email) || empty($plainPassword)) {
        throw new Exception("Email and password cannot be empty!");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format!");
    }

    if (strlen($plainPassword) < 6) {
        throw new Exception("Password must be at least 6 characters long!");
    }

    // Hash the password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    if (!$stmt) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email already registered! Please use a different email or login instead.";
    } else {
        // Insert the new user into the database
        $insertStmt = $conn->prepare("INSERT INTO users (email, password, created_at) VALUES (?, ?, NOW())");
        if (!$insertStmt) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $insertStmt->bind_param("ss", $email, $hashedPassword);
        
        if ($insertStmt->execute()) {
            // Set session variables and log the user in
            $_SESSION['user_id'] = $insertStmt->insert_id;
            $_SESSION['user_email'] = $email;
            echo "Signup successful! Redirecting...";
        } else {
            throw new Exception("Error creating account: " . $insertStmt->error);
        }
        
        $insertStmt->close();
    }

    $stmt->close();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Close connection if it exists
    if (isset($conn) && $conn) {
        $conn->close();
    }
}
?>