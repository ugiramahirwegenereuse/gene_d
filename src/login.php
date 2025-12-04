<?php
// login.php
session_start();

$db_host = '25rp19942_db';
$db_user = 'root';
$db_pass = 'rootpassword';
$db_name = '25rp19942_shareride_db';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $errors[] = "Please enter both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT user_id, user_password, user_firstname FROM tbl_users WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hash, $firstname);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_firstname'] = $firstname;
                header("Location: dashboard.php");
                exit;
            } else {
                $errors[] = "Invalid credentials.";
            }
        } else {
            $errors[] = "Invalid credentials.";
        }
        $stmt->close();
    }
}
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login - ShareRide</title>
</head>
<body>
  <h1>Login</h1>
  <?php if ($errors): ?>
    <div style="color:red;">
      <ul><?php foreach($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
  <?php endif; ?>
  <form method="post" action="">
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Login</button>
  </form>
  <p><a href="index.php">Back</a></p>
</body>
</html>
