<?php
session_start(); // Start the session

require 'vendor/autoload.php';
use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Database connection settings
$servername = $_ENV['DB_SERVERNAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the email and password from POST
$email = $_POST['email'];
$plainPassword = $_POST['password']; // Store the original password

// Hash the password
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// Check if the email already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Email already exists
    echo "Email already registered!";
} else {
    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashedPassword);
    if ($stmt->execute()) {
        // Set session variables and log the user in
        $_SESSION['user_id'] = $stmt->insert_id;
        echo "Signup successful! Redirecting...";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close connection
$stmt->close();
$conn->close();
?>
