<?php
$pageTitle = "Register Your Business | DahodBazaar";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

   <link rel="stylesheet" href="./style.css?v=2">
</head>
<body>

<header class="navbar">
    <a href="index.php" class="logo">
        <span class="logo-icon">
            <i class="fa-solid fa-location-dot"></i>
        </span>
        Dahod<span class="logo-highlight">Nearby</span>
    </a>

    <nav class="nav-links">
        <a href="index.php#categories">Categories</a>
        <a href="index.php#businesses">Explore Businesses</a>
    </nav>
</header>

<main class="register-business-page">
    <section class="register-business-heading">
        <h1>Register Your Business</h1>
        <p>
            Have a business in Dahod? Add your business to DahodBazaar
            and help local customers discover your services.
        </p>
    </section>

    <section class="register-business-card">
        <form action="" method="POST">

            <div class="form-group">
                <label for="business_name">Business Name *</label>
                <input
                    type="text"
                    id="business_name"
                    name="business_name"
                    placeholder="Enter your business name"
                    required
                >
            </div>

            <div class="form-group">
                <label for="category">Business Category *</label>
                <select id="category" name="category" required>
                    <option value="">Select a category</option>
                    <option value="Doctors">Doctors</option>
                    <option value="Restaurants">Restaurants</option>
                    <option value="Salons">Salons</option>
                    <option value="Shopping">Shopping</option>
                    <option value="Education">Education</option>
                    <option value="Hotels">Hotels</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Home Services">Home Services</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="owner_name">Owner Name *</label>
                <input
                    type="text"
                    id="owner_name"
                    name="owner_name"
                    placeholder="Enter owner's name"
                    required
                >
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="Enter phone number"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Enter email address"
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="address">Business Address *</label>
                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    placeholder="Enter your business address in Dahod"
                    required
                ></textarea>
            </div>

            <div class="form-group">
                <label for="services">Services Offered *</label>
                <input
                    type="text"
                    id="services"
                    name="services"
                    placeholder="e.g. Haircut, Facial, Hair Styling"
                    required
                >
                <small>Separate multiple services with commas.</small>
            </div>

            <div class="form-group">
                <label for="description">Business Description *</label>
                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Describe your business and what makes it special"
                    required
                ></textarea>
            </div>

            <div class="form-group">
                <label for="hours">Business Hours</label>
                <input
                    type="text"
                    id="hours"
                    name="hours"
                    placeholder="e.g. Monday–Saturday, 9 AM–8 PM"
                >
            </div>

            <div class="form-group">
                <label for="image_url">Business Image URL (Optional)</label>
                <input
                    type="url"
                    id="image_url"
                    name="image_url"
                    placeholder="https://example.com/business-image.jpg"
                >
            </div>

            <button type="submit" class="register-submit-button">
                Submit Business
            </button>

            <p class="register-form-note">
                This is a demo form. Your information will not be saved yet.
            </p>

        </form>
    </section>
</main>
<footer class="footer">
    <a href="index.php" class="logo">
        <i class="fa-solid fa-location-dot"></i>
        Dahod<span class="logo-highlight">Nearby</span>
    </a>
    <p>Discover local. Support local.</p>
    <span>© 2026 Dahod Nearby</span>
</footer>
</body>
</html>
