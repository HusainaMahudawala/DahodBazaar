<?php
$pageTitle = "Owner Login | Dahod Nearby";
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

   <link rel="stylesheet" href="./style.css?v=3">
</head>

<body>

    <!-- Navbar -->
    <header class="main-header">
        <div class="main-header-container">

            <a href="index.php" class="brand-logo">
                <i class="fa-solid fa-location-dot brand-location"></i>
                <span>Dahod <span class="brand-highlight">Nearby</span></span>
            </a>

            <nav class="main-navbar">
                <a href="index.php#categories">Categories</a>
                <a href="index.php#businesses">Explore Businesses</a>
            </nav>

        </div>
    </header>

    <!-- Owner Login -->
    <main class="owner-login-page">

        <div class="owner-login-heading">
            <div class="owner-login-icon">
                <i class="fa-solid fa-store"></i>
            </div>

            <h1>Welcome Back!</h1>

            <p>
                Log in to your business owner account
                and manage your listing.
            </p>
        </div>

        <div class="owner-login-card">

            <h2>Owner Login</h2>
            <p class="owner-login-subtitle">
                Enter your account details to continue.
            </p>

            <form action="" method="POST">

                <div class="owner-form-group">
                    <label for="email">Email Address</label>

                    <div class="owner-input-wrapper">
                        <i class="fa-regular fa-envelope"></i>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email address"
                            required
                        >
                    </div>
                </div>

                <div class="owner-form-group">
                    <label for="password">Password</label>

                    <div class="owner-input-wrapper">
                        <i class="fa-solid fa-lock"></i>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >
                    </div>
                </div>

                <div class="owner-login-options">
                    <label class="owner-remember">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>

                    <a href="#" class="owner-forgot-link">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="owner-login-button">
                    Log In <i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>

            <div class="owner-login-divider">
                <span>New to Dahod Nearby?</span>
            </div>

            <a href="register-business.php"
               class="owner-register-button">
                <i class="fa-solid fa-plus"></i>
                Register Your Business
            </a>

        </div>

        <p class="owner-login-footer">
            Looking for local businesses?
            <a href="index.php">Explore Dahod Nearby</a>
        </p>

    </main>
      <!-- FOOTER -->
    <footer class="footer">
        <a href="#" class="logo">
            <i class="fa-solid fa-location-dot"></i>
            Dahod<span class="logo-highlight">Nearby</span>
        </a>
        <p>Discover local. Support local.</p>
        <span>© 2026 Dahod Nearby</span>
    </footer>

</body>
</html>