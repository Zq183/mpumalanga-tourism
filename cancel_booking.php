<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['user_logged_in'])) {
    header("Location: user_login.php");
    exit;
}

if (isset($_GET['id'])) {
    $booking_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    // Delete only if the booking belongs to the logged-in user
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $booking_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Booking cancelled successfully.";
    } else {
        $_SESSION['message'] = "❌ Error cancelling booking.";
    }

    $stmt->close();
}

header("Location: user_dashboard.php");
exit;
