<?php
session_start();
require_once "db.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $dbuser, $dbhash);
        $stmt->fetch();
        if (password_verify($password, $dbhash)) {
            $_SESSION['user_logged_in'] = true;
			$_SESSION['user_id'] = $id;
            $_SESSION['user_username'] = $dbuser;
            header("Location: user_dashboard.php");
            exit;
        } else {
            $error = "❌ Wrong password.";
        }
    } else {
        $error = "❌ No such user.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>User Login</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="form-container">
  <h1>User Login</h1>
  <?php if($error): ?><p style="color:red;"><?php echo $error; ?></p><?php endif; ?>
  <form method="post">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
  </form>
</body>
</html>
