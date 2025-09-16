 <?php
// Include database connection
include 'db.php'; // make sure db.php has InfinityFree credentials

// Optional: Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['title']) && isset($_POST['url']) && isset($_POST['image'])){
    $title = $_POST['title'];
    $url = $_POST['url'];
    $image = $_POST['image'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO favorites (recipe_title, recipe_url, recipe_image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $url, $image);

    if($stmt->execute()){
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing parameters"]);
}
?>