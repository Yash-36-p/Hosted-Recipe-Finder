 <?php
$servername = "sql311.infinityfree.com";
$username = "if0_39947577";  // removed extra space
$password = "1241Yash";
$dbname = "if0_39947577_recipefinder";

// Connect to MySQL server
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create tables if missing
$tables = [
    "users" => "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB",

    "favorites" => "CREATE TABLE IF NOT EXISTS favorites (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        recipe_title VARCHAR(255),
        recipe_url VARCHAR(255),
        recipe_image VARCHAR(255),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB"
];

foreach ($tables as $name => $query) {
    if ($conn->query($query) !== TRUE) {
        die("Error creating $name table: " . $conn->error);
    }
}
?>