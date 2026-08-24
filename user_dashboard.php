<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: user_login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

/* ✅ Handle new booking */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_booking'])) {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $place = trim($_POST['place']);

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, name, email, place) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $name, $email, $place);

    if ($stmt->execute()) {
        $message = "✅ Booking saved!";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}

/* ✅ Handle cancel booking */
if (isset($_GET['cancel'])) {
    $booking_id = intval($_GET['cancel']);
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $booking_id, $user_id);
    $stmt->execute();
    $stmt->close();
    $message = "✅ Booking cancelled.";
}

/* ✅ Handle edit booking */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_booking'])) {
    $booking_id = intval($_POST['booking_id']);
    $place = trim($_POST['place']);

    $stmt = $conn->prepare("UPDATE bookings SET place=? WHERE id=? AND user_id=?");
    $stmt->bind_param("sii", $place, $booking_id, $user_id);
    if ($stmt->execute()) {
        $message = "✅ Booking updated.";
    } else {
        $message = "❌ Error updating booking.";
    }
    $stmt->close();
}

/* ✅ Fetch user’s bookings */
$stmt = $conn->prepare("SELECT id, name, email, place, created_at FROM bookings WHERE user_id=? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_username']); ?>!</h1>
  <a href="logout.php">Logout</a>

  <?php if($message): ?>
    <p><?php echo $message; ?></p>
  <?php endif; ?>

  <!-- ✅ New Booking Form -->
  <div class="form-container">
    <h2>Book a New Trip</h2>
    <form method="post">
      <input type="hidden" name="new_booking" value="1">
      <input type="text" name="name" placeholder="Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="place" placeholder="Place to Visit" required>
      <button type="submit">Book</button>
    </form>
  </div>

  <!-- ✅ Bookings Table -->
  <div class="table-container">
    <h2>Your Bookings</h2>
    <?php if ($result->num_rows > 0): ?>
      <table>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Place</th><th>Date</th><th>Actions</th></tr>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
              <!-- ✅ Update Place Form -->
              <form method="post" style="display:inline;">
                <input type="hidden" name="edit_booking" value="1">
                <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
                <input type="text" name="place" value="<?php echo htmlspecialchars($row['place']); ?>" required>
                <button type="submit">Update</button>
              </form>
            </td>
            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
            <td>
              <a href="user_dashboard.php?cancel=<?php echo $row['id']; ?>" 
                 onclick="return confirm('Are you sure you want to cancel this booking?');">
                 Cancel
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php else: ?>
      <p>You have no bookings yet.</p>
    <?php endif; ?>
  </div>
</body>
</html>
