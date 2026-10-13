<?php
$pageTitle = "Dahod Nearby | Local Business Directory";
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
                    <p>Sample listings to preview your website.</p>
                </div>
            </div>
               
<?php
$businesses = [
    // RESTAURANTS
    [
        "id" => "prabhuan-restaurant",
        "category" => "Restaurants",
        "imageClass" => "food-image",
        "icon" => "fa-utensils",
        "tag" => "Food & Dining",
        "name" => "Prabhuan Restaurant",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Restaurants",
        "description" => "A sample restaurant listing for meals, family dining and food lovers.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 10:00 AM – 10:00 PM",
        "rating" => "4.5",
        "reviews" => "120"
    ],
    [
        "id" => "dahod-family-food-corner",
        "category" => "Restaurants",
        "imageClass" => "food-image",
        "icon" => "fa-burger",
        "tag" => "Fast Food",
        "name" => "Dahod Family Food Corner",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Restaurants",
        "description" => "Sample listing for snacks, fast food and casual family meals.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 11:00 AM – 11:00 PM",
        "rating" => "4.2",
        "reviews" => "85"
    ],

    // DOCTORS AND CLINICS
    [
        "id" => "dahod-general-clinic",
        "category" => "Doctors",
        "imageClass" => "doctor-image",
        "icon" => "fa-user-doctor",
        "tag" => "Healthcare",
        "name" => "Dahod General Clinic",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Doctors",
        "description" => "Demo listing for general medical consultation and primary healthcare.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 9:00 AM – 1:00 PM, 5:00 PM – 8:00 PM",
        "rating" => "4.6",
        "reviews" => "95"
    ],
    [
        "id" => "smile-dental-care",
        "category" => "Doctors",
        "imageClass" => "doctor-image",
        "icon" => "fa-tooth",
        "tag" => "Dental Care",
        "name" => "Smile Dental Care",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Doctors",
        "description" => "Sample dental clinic listing for dental checkups and oral care.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 10:00 AM – 7:00 PM",
        "rating" => "4.4",
        "reviews" => "68"
    ],

    // SALONS
    [
        "id" => "mirror-salon",
        "category" => "Salons",
        "imageClass" => "salon-image",
        "icon" => "fa-scissors",
        "tag" => "Beauty & Care",
        "name" => "Mirror Salon",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Salons",
        "description" => "Sample salon listing for haircuts, styling and grooming services.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 10:00 AM – 9:00 PM",
        "rating" => "4.3",
        "reviews" => "72"
    ],
    [
        "id" => "glow-beauty-studio",
        "category" => "Salons",
        "imageClass" => "salon-image",
        "icon" => "fa-spa",
        "tag" => "Beauty Services",
        "name" => "Glow Beauty Studio",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Salons",
        "description" => "Demo listing for beauty treatments, makeup and personal care.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 10:00 AM – 8:00 PM",
        "rating" => "4.1",
        "reviews" => "54"
    ],

    // SHOPPING
    [
        "id" => "shankar-mega-store",
        "category" => "Shopping",
        "imageClass" => "shopping-image",
        "icon" => "fa-bag-shopping",
        "tag" => "Supermarket",
        "name" => "Shankar Mega Store",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Shopping",
        "description" => "Sample supermarket listing for groceries, household items and daily needs.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 9:00 AM – 9:00 PM",
        "rating" => "4.5",
        "reviews" => "110"
    ],
    [
        "id" => "city-fashion-store",
        "category" => "Shopping",
        "imageClass" => "shopping-image",
        "icon" => "fa-shirt",
        "tag" => "Fashion",
        "name" => "City Fashion Store",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Shopping",
        "description" => "Demo clothing store listing for everyday fashion and accessories.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 10:00 AM – 9:00 PM",
        "rating" => "4.0",
        "reviews" => "47"
    ],

    // EDUCATION
    [
        "id" => "jamali-english-school",
        "category" => "Education",
        "imageClass" => "education-image",
        "icon" => "fa-graduation-cap",
        "tag" => "School",
        "name" => "Jamali English School",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Education",
        "description" => "Sample school-directory entry for an English-medium school.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 8:00 AM – 2:00 PM",
        "rating" => "4.4",
        "reviews" => "90"
    ],
    [
        "id" => "st-marys-school",
        "category" => "Education",
        "imageClass" => "education-image",
        "icon" => "fa-school",
        "tag" => "School",
        "name" => "St. Mary's School",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Education",
        "description" => "Sample education-directory entry for a school.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 8:00 AM – 2:00 PM",
        "rating" => "4.3",
        "reviews" => "76"
    ],

    // HOTELS
    [
        "id" => "prabhuan-hotel",
        "category" => "Hotels",
        "imageClass" => "hotel-image",
        "icon" => "fa-hotel",
        "tag" => "Accommodation",
        "name" => "Prabhuan Hotel",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Hotels",
        "description" => "Sample hotel-directory listing for visitors looking for accommodation.",
        "phone" => "0000000000",
        "hours" => "Demo listing: Contact details to be verified",
        "rating" => "4.2",
        "reviews" => "88"
    ],
    [
        "id" => "dahod-comfort-stay",
        "category" => "Hotels",
        "imageClass" => "hotel-image",
        "icon" => "fa-bed",
        "tag" => "Stay & Travel",
        "name" => "Dahod Comfort Stay",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Hotels",
        "description" => "Demo accommodation listing for travellers and families.",
        "phone" => "0000000000",
        "hours" => "Demo listing: Contact details to be verified",
        "rating" => "4.1",
        "reviews" => "61"
    ],

    // ELECTRONICS
    [
        "id" => "dahod-electronics-store",
        "category" => "Electronics",
        "imageClass" => "electronics-image",
        "icon" => "fa-mobile-screen-button",
        "tag" => "Electronics",
        "name" => "Dahod Electronics Store",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Electronics",
        "description" => "Sample shop listing for electronic devices and household appliances.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 10:00 AM – 8:30 PM",
        "rating" => "4.3",
        "reviews" => "69"
    ],
    [
        "id" => "smart-mobile-repair",
        "category" => "Electronics",
        "imageClass" => "electronics-image",
        "icon" => "fa-screwdriver-wrench",
        "tag" => "Repair Services",
        "name" => "Smart Mobile Repair",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Electronics",
        "description" => "Demo listing for mobile troubleshooting and electronic repair services.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 10:00 AM – 8:00 PM",
        "rating" => "4.0",
        "reviews" => "43"
    ],

    // HOME SERVICES
    [
        "id" => "dahod-plumbing-services",
        "category" => "Home Services",
        "imageClass" => "home-image",
        "icon" => "fa-wrench",
        "tag" => "Plumbing",
        "name" => "Dahod Plumbing Services",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Home Services",
        "description" => "Sample service listing for household plumbing and maintenance.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 9:00 AM – 7:00 PM",
        "rating" => "4.2",
        "reviews" => "38"
    ],
    [
        "id" => "reliable-electrician-services",
        "category" => "Home Services",
        "imageClass" => "home-image",
        "icon" => "fa-bolt",
        "tag" => "Electrical Services",
        "name" => "Reliable Electrician Services",
        "location" => "Dahod, Gujarat",
        "searchTerm" => "Home Services",
        "description" => "Demo listing for home electrical repairs and maintenance.",
        "phone" => "0000000000",
        "hours" => "Demo hours: 9:00 AM – 7:00 PM",
        "rating" => "4.4",
        "reviews" => "51"
    ]
];
?>

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

                    <div class="business-rating">
                        <i class="fa-solid fa-star"></i>
                        <?= htmlspecialchars($business['rating'], ENT_QUOTES, 'UTF-8') ?>
                        <span>(<?= htmlspecialchars($business['reviews'], ENT_QUOTES, 'UTF-8') ?> demo reviews)</span>
                    </div>

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
                        <span class="sample-label">Sample listing</span>
                      <a
                       href="business.php?id=<?= urlencode($business['id']) ?>"class="outline-button">
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
