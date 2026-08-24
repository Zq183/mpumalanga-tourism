<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Attractions - Mpumalanga Tourism</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .gallery {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 20px;
    }
    .card {
      background: white;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      text-align: center;
    }
    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .card h3 { margin: 10px 0; }
  </style>
</head>
<body>
  <header>
    <h1>Top Attractions</h1>
    <nav>
      <a href="index.php">Home</a>
	  <a href="about.php">About Us</a>
      <a href="attractions.php">Attractions</a>
      <a href="bookings.php">Bookings</a>
      <a href="register.php">Register</a>
      <a href="user_login.php">User Login</a>
    </nav>
  </header>

  <main>
    <div class="gallery">
      <div class="card">
        <img src="images/blyde.png" alt="Blyde River Canyon">
        <h3>Blyde River Canyon</h3>
      </div>
      <div class="card">
        <img src="images/kruger.png" alt="Kruger National Park">
        <h3>Kruger National Park</h3>
      </div>
      <div class="card">
        <img src="images/godswindow.png" alt="God’s Window">
        <h3>God’s Window</h3>
      </div>
      <div class="card">
        <img src="images/pilgrimsrest.png" alt="Pilgrim’s Rest">
        <h3>Pilgrim’s Rest</h3>
      </div>
    </div>
  </main>
</body>
</html>
