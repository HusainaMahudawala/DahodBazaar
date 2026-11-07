
<?php
$pageTitle = "Dahod Nearby | Local Business Directory";

require_once __DIR__ . "/db.php";

$businesses = [];

$sql = "SELECT b.*, c.category_name
        FROM businesses b
        LEFT JOIN categories c ON b.category_id = c.category_id
        WHERE b.status = 'approved'
        ORDER BY b.created_at DESC";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $businesses[] = [
        "id" => $row["business_id"],
        "category" => $row["category_name"] ?? "Other",
        "imageClass" => $row["image_class"] ?? "",
        "icon" => $row["icon_class"] ?: "fa-store",
        "tag" => $row["tag"] ?: ($row["category_name"] ?? "Local Business"),
        "name" => $row["business_name"],
        "location" => trim(($row["area"] ?? "") . ", " . ($row["city"] ?? "Dahod"), ", "),
        "phone" => $row["phone"],
        "hours" => $row["opening_hours"] ?? "Contact for timings",
        "description" => $row["description"] ?? ""
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <meta name="description"
          content="Discover shops, restaurants and local services in Dahod.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <a href="#" class="logo">
            <span class="logo-icon">
                <i class="fa-solid fa-location-dot"></i>
            </span>
            Dahod<span class="logo-highlight">Nearby</span>
        </a>

        <nav class="nav-links">
            <a href="#categories">Categories</a>
            <a href="#businesses">Explore Businesses</a>
            <a href="Owner.php">Owner Login</a>
            <a href="Register-business.php">Register Your Business</a>
        </nav>

        <a href="#businesses" class="add-business">
            <i class="fa-solid fa-plus"></i> Find Local Businesses
        </a>
    </header>

    <!-- HERO -->
    <main>
        <section class="hero">
            <div class="hero-content">
                <span class="eyebrow">
                    <i class="fa-solid fa-location-dot"></i>
                    YOUR CITY, YOUR PEOPLE
                </span>

                <h1>Discover the best of <span>Dahod.</span></h1>

                <p>
                    Find trusted shops, services and places
                    around your city — all in one place.
                </p>

                <form class="search-box" id="searchForm">
                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input
                        type="search"
                        id="searchInput"
                        placeholder="Doctors, restaurants, salons..."
                        aria-label="Search local businesses">

                    <button type="submit">Search</button>
                </form>

                <div class="popular-searches">
                    <span>Popular:</span>
                    <button type="button" data-search="Doctors">Doctors</button>
                    <button type="button" data-search="Restaurants">Restaurants</button>
                    <button type="button" data-search="Salons">Salons</button>
                </div>
            </div>

            <div class="hero-decoration decoration-one">
                <i class="fa-solid fa-shop"></i>
            </div>
            <div class="hero-decoration decoration-two">
                <i class="fa-solid fa-utensils"></i>
            </div>
        </section>

        <!-- CATEGORIES -->
        <section class="section categories-section" id="categories">
            <div class="section-heading">
                <div>
                    <span class="section-label">EXPLORE DAHOD</span>
                    <h2>What are you looking for?</h2>
                    <p>Find the right service for your needs.</p>
                </div>
                <a href="#businesses" class="text-link">
                    Explore all <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="category-grid">
                <button class="category-card" data-search="Doctors">
                    <span class="category-icon blue">
                        <i class="fa-solid fa-user-doctor"></i>
                    </span>
                    <strong>Doctors</strong>
                    <small>Healthcare</small>
                </button>

                <button class="category-card" data-search="Restaurants">
                    <span class="category-icon orange">
                        <i class="fa-solid fa-utensils"></i>
                    </span>
                    <strong>Restaurants</strong>
                    <small>Food & dining</small>
                </button>

                <button class="category-card" data-search="Salons">
                    <span class="category-icon pink">
                        <i class="fa-solid fa-scissors"></i>
                    </span>
                    <strong>Salons</strong>
                    <small>Beauty & care</small>
                </button>

                <button class="category-card" data-search="Shopping">
                    <span class="category-icon purple">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </span>
                    <strong>Shopping</strong>
                    <small>Shops & stores</small>
                </button>

                <button class="category-card" data-search="Education">
                    <span class="category-icon green">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </span>
                    <strong>Education</strong>
                    <small>Classes & colleges</small>
                </button>

                <button class="category-card" data-search="Hotels">
                    <span class="category-icon yellow">
                        <i class="fa-solid fa-hotel"></i>
                    </span>
                    <strong>Hotels</strong>
                    <small>Stay & travel</small>
                </button>

                <button class="category-card" data-search="Electronics">
                    <span class="category-icon teal">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                    </span>
                    <strong>Electronics</strong>
                    <small>Devices & repairs</small>
                </button>

                <button class="category-card" data-search="Home Services">
                    <span class="category-icon red">
                        <i class="fa-solid fa-house"></i>
                    </span>
                    <strong>Home Services</strong>
                    <small>Everyday needs</small>
                </button>
            </div>
        </section>

        <!-- BUSINESS LISTINGS -->
        <section class="section businesses-section" id="businesses">
            <div class="section-heading">
                <div>
                    <span class="section-label">LOCAL DISCOVERY</span>
                    <h2>Explore local businesses</h2>
                    <p>Discover approved businesses in Dahod.</p>
                </div>
            </div>

            <div class="business-carousel">
                <button type="button"
                        class="carousel-button"
                        id="prevBusinesses"
                        aria-label="Previous businesses">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <div class="business-grid" id="businessGrid">
                    <?php foreach ($businesses as $id => $business): ?>
                        <article class="business-card"
                                 data-category="<?= htmlspecialchars($business['category'], ENT_QUOTES, 'UTF-8') ?>">

                            <div class="business-image <?= htmlspecialchars($business['imageClass'], ENT_QUOTES, 'UTF-8') ?>">
                                <i class="fa-solid <?= htmlspecialchars($business['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                                <span class="listing-tag">
                                    <?= htmlspecialchars($business['tag'], ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </div>

                            <div class="business-info">
                                <h3><?= htmlspecialchars($business['name'], ENT_QUOTES, 'UTF-8') ?></h3>

                                <p>
                                    <i class="fa-solid fa-location-dot"></i>
                                    <?= htmlspecialchars($business['location'], ENT_QUOTES, 'UTF-8') ?>
                                </p>

                                <p>
                                    <i class="fa-solid fa-phone"></i>
                                    <?= htmlspecialchars($business['phone'], ENT_QUOTES, 'UTF-8') ?>
                                </p>

                                <p>
                                    <i class="fa-regular fa-clock"></i>
                                    <?= htmlspecialchars($business['hours'], ENT_QUOTES, 'UTF-8') ?>
                                </p>

                                <p class="business-description">
                                    <?= htmlspecialchars($business['description'], ENT_QUOTES, 'UTF-8') ?>
                                </p>

                                <div class="business-actions">
                                    <span class="sample-label">Local business</span>
                                    <a href="Business.php?id=<?= urlencode($business['id']) ?>" class="outline-button">
                                        Explore
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <button type="button"
                        class="carousel-button"
                        id="nextBusinesses"
                        aria-label="Next businesses">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

            <p id="carouselStatus" class="carousel-status" aria-live="polite"></p>
            <p id="searchMessage" class="search-message" aria-live="polite"></p>
        </section>

        <!-- CALL TO ACTION -->
        <section class="business-cta">
            <div>
                <span class="section-label">BUILT FOR DAHOD</span>
                <h2>Know a great local business?</h2>
                <p>Help people discover the services available in our city.</p>
            </div>
            <a href="mailto:hello@example.com" class="cta-button">
                Get in touch <i class="fa-solid fa-arrow-right"></i>
            </a>
        </section>
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
