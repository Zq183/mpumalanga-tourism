<?php
session_start();
require_once "db";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $place = trim($_POST['place']);

    // Default user_id is NULL (for guests)
    $user_id = isset($_SESSION['user_logged_in']) ? $_SESSION['user_id'] : NULL;

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
  <?php if($message): ?><p><?php echo $message; ?></p><?php endif; ?>
  <form method="post">
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="place" placeholder="Place" required><br><br>
    <button type="submit">Book</button>
  </form>
</body>
</html>

