 <?php
// Include database connection
include 'db.php';

// Enable error reporting (for debugging, can remove later)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch favorites
$sql = "SELECT * FROM favorites ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Favorite Recipes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>💖 Favorite Recipes</h1>
        <p>Recipes you saved are listed here.</p>
        <a href="index.php"><button>🔙 Back to Search</button></a>
    </header>

    <div class="container">
        <div id="recipes">
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='recipe-card'>
                            <img src='{$row['recipe_image']}' alt='{$row['recipe_title']}'>
                            <h3>{$row['recipe_title']}</h3>
                            <a href='{$row['recipe_url']}' target='_blank'>View Recipe</a>
                          </div>";
                }
            } else {
                echo "<p>No favorites saved yet!</p>";
            }
            ?>
        </div>
    </div>

    <footer class="footer_text">
        <p>&copy; 2025 Recipe Finder</p>
    </footer>
</body>
</html>