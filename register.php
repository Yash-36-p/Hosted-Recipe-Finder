 <?php
// Enable error reporting for debugging if needed
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'db.php';

// Initialize message variable
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Hash password before saving
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashedPassword);

        if ($stmt->execute()) {
            $message = "<div class='success-msg'>✅ Registration successful. <a href='login.php'>Login here</a></div>";
        } else {
            $message = "<div class='error-msg'>⚠️ Error: " . htmlspecialchars($stmt->error) . "</div>";
        }
    } else {
        $message = "<div class='error-msg'>⚠️ Please fill in all fields.</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, #ff9966, #ff5e62);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .form-container {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
      text-align: center;
      width: 300px;
      box-sizing: border-box;
    }
    h2 { margin-bottom: 20px; color: #333; }
    input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #ff5e62;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button:hover { background: black; }
    .switch {
      margin-top: 15px;
      font-size: 14px;
    }
    .switch a {
      color: #667eea;
      text-decoration: none;
      font-weight: bold;
    }
    /* Success message style */
    .success-msg {
      background: #e0ffe0;
      border: 1px solid #3cc47c;
      color: #267a4e;
      padding: 12px 16px;
      margin-bottom: 15px;
      border-radius: 6px;
      text-align: left;
    }
    /* Error message style */
    .error-msg {
      background: #ffe0e0;
      border: 1px solid #cc3c3c;
      color: #7a2626;
      padding: 12px 16px;
      margin-bottom: 15px;
      border-radius: 6px;
      text-align: left;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Create Account</h2>
    <?php echo $message; ?>
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Register</button>
    </form>
    <div class="switch">
      Already have an account? <a href="login.php">Login</a>
    </div>
  </div>
</body>
</html>