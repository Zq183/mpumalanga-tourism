<?php
require_once "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $msg = trim($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $msg);

    if ($stmt->execute()) {
        $message = "✅ Thank you for contacting us! We will get back to you soon.";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - Mpumalanga Tourism Hub</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .contact-container {
      max-width: 600px;
      margin: 20px auto;
      padding: 20px;
      background: #f9f9f9;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .contact-container h2 {
      color: #006400;
    }
    .contact-container input, .contact-container textarea {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .contact-container button {
      background: #006400;
      color: white;
      border: none;
      padding: 10px 15px;
      cursor: pointer;
      border-radius: 5px;
    }
    .contact-container button:hover {
      background: #228B22;
    }
  </style>
</head>
<body>
  <header>
    <h1>Mpumalanga Tourism Hub</h1>
    <nav>
      <a href="index.php">Home</a>
      <a href="attractions.php">Attractions</a>
      <a href="bookings.php">Bookings</a>
      <a href="about.php">About Us</a>
      <a href="contact.php">Contact</a>
      <a href="register.php">Register</a>
      <a href="user_login.php">Login</a>
    </nav>
  </header>

  <main>
    <div class="contact-container">
      <h2>Contact Us</h2>
      <?php if($message): ?><p><?php echo $message; ?></p><?php endif; ?>
      <form method="post">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>
  </main>

  <footer>
    © 2025 Mpumalanga Tourism Hub. All rights reserved.
  </footer>
</body>
</html>
