<?php
require 'php/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Housing & Rental System</title>
<link rel="stylesheet" href="css/styles.css" />
</head>
<body>

 <!-- ====== Header / Navigation ====== -->
<header class="site-header">
<div class="container nav">
<h1>Housing & Rental</h1>
<nav>
<a href="homepage.php">Home</a>
<a href="#about">About</a>

<a href="#contact">Contact</a>
<a href="login.html">Login</a>
</nav>
</div>
</header>


  <!-- ====== Hero Section ====== -->
  <section class="hero" style="background-image: url('uploads/apartment20.jpg');">
  <div class="hero-content">
  <h2>Find Your Next Home</h2>
  <p>Whether you're buying, selling, or renting — we make it simple.</p>
  </div>
  </section>

  <!-- ====== Featured Properties ====== -->
  <section class="properties">
    <div class="container">
      <h3>Available Properties</h3>
      <div class="property-list">
        <?php
        $query = "SELECT properties.*, users.username, users.phone FROM properties 
                  JOIN users ON properties.user_id = users.id 
                  ORDER BY properties.created_at DESC LIMIT 10";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $phone = preg_replace('/^0/', '+250', $row['contact_phone']);
                $whatsappLink = "https://wa.me/" . preg_replace('/[^0-9]/', '', $phone);
                
                echo "<div class='property-card'>";
                if (!empty($row['image']) && file_exists('uploads/' . $row['image'])) {
                    echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Property Image' />";
                } else {
                    echo "<img src='uploads/default.jpg' alt='No Image' />";
                }
                echo "<div class='title-type'>
                        <h4>" . htmlspecialchars($row['title']) . "</h4>
                        <span class='listing-type'>" . ucfirst(htmlspecialchars($row['type'])) . "</span>
                      </div>";
                echo "<p>💰 $" . htmlspecialchars($row['price']) . "</p>";
                echo "<p>📍 " . htmlspecialchars($row['location']) . "</p>";
                echo "<p><strong>Owner:</strong> " . htmlspecialchars($row['username']) . "</p>";
                echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone']) . "</p>";
                echo "<a href='" . $whatsappLink . "' target='_blank' class='whatsapp-button'>
                        <img src='uploads/whatsapp-icon.svg' alt='WhatsApp' class='whatsapp-icon' />
                        WhatsApp
                      </a>";
                echo "</div>";
            }
        } else {
            echo "<p>No properties found at the moment.</p>";
        }
        ?>
      </div>
    </div>
  </section>

  <section class="info-section">
  <div class="info-grid">

    <!-- Contact Us Section -->
    <div class="info-block contact-block" id="contact">
      <h3>Contact Us</h3>
      <p>Got questions? Reach out below.</p>

      <?php if (isset($_GET['success']) && $_GET['success'] === '1' && basename($_SERVER['HTTP_REFERER']) === 'index.php'): ?>
        <p class="success-message">Message sent successfully!</p>
      <?php endif; ?>

      <form action="php/save_message.php" method="post" class="contact-form">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <textarea name="message" rows="3" placeholder="Your Message" required></textarea>
        <button type="submit" class="send-btn">Send</button>
      </form>
    </div>

    <!-- About Us -->
    <div class="info-block" id="about">
      <h3>About Us</h3>
      <p>
        We are a Rwanda-based digital platform dedicated to transforming how people find, rent, and buy property. Our mission is to bridge the gap between property owners and seekers by providing a user-friendly, reliable, and secure space where anyone can manage housing transactions independently.

         Unlike traditional systems where only admins can upload property listings, our platform empowers property owners to register, log in, and post their properties themselves—whether for rent or sale. This approach eliminates unnecessary delays, ensures real-time availability, and promotes transparency.
      </p>
    </div>

    <!-- Testimonials -->
    <div class="info-block">
      <h3>What others say about us</h3>
      <blockquote>“I found my apartment in two days!”<br><span>– Aline, Kigali</span></blockquote>
      <blockquote>“Got calls after listing. Awesome!”<br><span>– Jean Claude, Kicukiro</span></blockquote>
    </div>

    <!-- Call to Action -->
    <div class="info-block">
      <h3>Ready to list Your Property?</h3>
      <p>Join now and reach potential renters fast.</p>
      <a href="login.html" class="cta-btn">Get Started</a>
    </div>
    </div> <!-- Close of .info-wrapper -->

<!-- Footer Info Inside Info Section -->
<div class="footer-inside-info">
  <p>📞 Contact: +250 788 959 444 | ✉️ Email: uwizeyemagnifiquehouses@gmail.com</p>
  <p>© 2025 Housing & Rental System</p>
</div>

  </div>
</section>


  <script src="js/main.js"></script>
</body>
</html>
