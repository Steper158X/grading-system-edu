<?php

// Include the configuration file
// It's crucial this file exists and is readable.
// Using require_once ensures it's included only once if multiple files try to include it.
require_once 'config.php'; 

try {
    // Construct DSN (Data Source Name) using constants from config.php
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    
    // Create a new PDO instance
    $connect = new PDO($dsn, DB_USER, DB_PASS);
    
    // Set PDO attributes for error handling and other features
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optional: It's good practice to disable emulated prepares for security with modern MySQL versions.
    // $connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // Optional: Set default fetch mode if desired (e.g., to PDO::FETCH_ASSOC)
    // $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Log the detailed error to the server's error log.
    // Be cautious about what information is logged, especially credentials.
    // $e->getMessage() is generally safe as it describes the error, not the connection parameters directly.
    error_log("FATAL: Database Connection Failed. DB Host: " . DB_HOST . ", DB Name: " . DB_NAME . ", DB User: " . DB_USER . ". Error: " . $e->getMessage());
    
    // Send a generic HTTP 503 Service Unavailable status code to the client
    http_response_code(503); 
    
    // Display a user-friendly error message and terminate script execution.
    // Avoid showing detailed technical errors to the end-user.
    die("<h3>Service Temporarily Unavailable</h3><p>We are currently experiencing technical difficulties connecting to the database. Please try again later. If the problem persists, please contact the website administrator.</p>");
}

// The $connect PDO object will be available to any script that includes this database.php file.
?>
