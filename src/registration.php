<?php
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
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname  = trim($_POST['lastname'] ?? '');
    $gender    = trim($_POST['gender'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = $_POST['password'] ?? '';

    if (!$firstname || !$lastname || !$email || !$password) {
        $errors[] = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($errors)) {
        // check if email exists
        $stmt = $conn->prepare("SELECT user_id FROM tbl_users WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Email already registered.";
        } else {
            $stmt->close();
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO tbl_users (user_firstname, user_lastname, user_gender, user_email, user_password) VALUES (?,?,?,?,?)");
            $stmt->bind_param("sssss", $firstname, $lastname, $gender, $email, $hashed);
            if ($stmt->execute()) {
                $success = "Registration successful. You may <a href='login.php'>login</a> now.";
            } else {
                $errors[] = "Registration failed: " . $conn->error;
            }
            $stmt->close();
        }
    }
}

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register - ShareRide</title>
</head>
<body>
  <h1>Register</h1>
  <?php if ($errors): ?>
    <div style="color:red;">
      <ul><?php foreach($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div style="color:green;"><?php echo $success; ?></div>
  <?php endif; ?>
  <form method="post" action="">
    <label>First name: <input type="text" name="firstname" required></label><br>
    <label>Last name:  <input type="text" name="lastname" required></label><br>
    <label>Gender:
      <select name="gender">
        <option value="">Select</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>
    </label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Register</button>
  </form>
  <p><a href="index.php">Back</a></p>
</body>
</html>
