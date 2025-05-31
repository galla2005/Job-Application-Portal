<?php
// database.php - Contains database connection details

$servername = "localhost";
$username = "root";  // Use your database username
$password = "";      // Use your database password
$dbname = "job_application";  // Your database name

try {
    // Establishing the database connection using PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; // Uncomment for debugging
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
