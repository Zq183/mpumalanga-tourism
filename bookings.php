<?php
session_start();
require_once "db.php";

// Redirect guests to Register page
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: register.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $place = trim($_POST['place']);

    $user_id = $_SESSION['user_id']; // link booking to logged-in user

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, name, email, place) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $name, $email, $place);

    if ($stmt->execute()) {
        $message = "✅ Booking saved!";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head><title>Bookings</title><link rel="stylesheet" href="style.css"></head>
<body>
  <h1>Book a Trip</h1>
  <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_username']); ?>!</p>
  <?php if($message): ?><p><?php echo $message; ?></p><?php endif; ?>

  <form method="post">
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="place" placeholder="Place" required><br><br>
    <button type="submit">Book</button>
  </form>

  <p><a href="user_dashboard.php">⬅ Back to Dashboard</a></p>
</body>
</html>


