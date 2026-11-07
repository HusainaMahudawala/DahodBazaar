<?php

require_once __DIR__ . "/db.php";

$selectedId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$business = null;

if ($selectedId) {

    $stmt = $conn->prepare("
        SELECT b.*, c.category_name
        FROM businesses b
        LEFT JOIN categories c ON b.category_id = c.category_id
        WHERE b.business_id = ? AND b.status = 'approved'
        LIMIT 1
    ");

    $stmt->bind_param("i", $selectedId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        $business = [
            "id" => $row["business_id"],
            "name" => $row["business_name"],
            "category" => $row["category_name"] ?? "Other",
            "icon" => $row["icon_class"] ?: "fa-store",
            "tag" => $row["tag"] ?? "",
            "location" => trim(($row["area"] ?? "") . ", " . ($row["city"] ?? "Dahod"), ", "),
            "address" => $row["address"] ?? "",
            "phone" => $row["phone"] ?? "",
            "hours" => $row["opening_hours"] ?? "Contact for timings",
            "rating" => "N/A",
            "reviews" => 0,
            "description" => $row["description"] ?? "",
            "services" => []
        ];

        $serviceStmt = $conn->prepare("
            SELECT service_name
            FROM business_services
            WHERE business_id = ?
        ");

        $serviceStmt->bind_param("i", $selectedId);
        $serviceStmt->execute();

        $serviceResult = $serviceStmt->get_result();

        while ($service = $serviceResult->fetch_assoc()) {
            $business["services"][] = $service["service_name"];
        }
    }
}

$pageTitle = $business
    ? $business["name"] . " | Dahod Nearby"
    : "Business Not Found | Dahod Nearby";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, "UTF-8") ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="style.css">

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

<main class="details-page">
    <a href="index.php#businesses" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Back to businesses
    </a>

    <?php if (!$business): ?>

        <section class="details-card not-found">
            <i class="fa-solid fa-store-slash fa-3x"></i>
            <h1>Business not found</h1>
            <p>This business ID does not exist in our sample listings.</p>
            <a href="index.php#businesses" class="details-button">
                Browse businesses
            </a>
        </section>

    <?php else: ?>

        <article class="details-card">
            <div class="details-banner">
                <i class="fa-solid <?= htmlspecialchars($business["icon"], ENT_QUOTES, "UTF-8") ?>"></i>
                <br>
                <span class="details-tag">
                    <?= htmlspecialchars($business['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </span>
            </div>

            <div class="details-content">
                <span class="section-label">
                    <?= htmlspecialchars($business["category"], ENT_QUOTES, "UTF-8") ?>
                </span>

                <h1><?= htmlspecialchars($business["name"], ENT_QUOTES, "UTF-8") ?></h1>

                <div class="business-rating">
                    <i class="fa-solid fa-star"></i>
                    <?= htmlspecialchars($business["rating"], ENT_QUOTES, "UTF-8") ?>
                    <span>
                        (<?= (int) $business["reviews"] ?> demo reviews)
                    </span>
                </div>

                <p class="details-description">
                    <?= htmlspecialchars($business["description"], ENT_QUOTES, "UTF-8") ?>
                </p>

                <h2>Business information</h2>

                <div class="details-grid">
                    <div class="detail-item">
                        <span class="detail-label">Address</span>
                        <i class="fa-solid fa-location-dot"></i>
                       <?= htmlspecialchars($business['address'] ?? $business['location'] ?? 'Dahod, Gujarat', ENT_QUOTES, 'UTF-8') ?>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Phone number</span>
                        <i class="fa-solid fa-phone"></i>
                        <?= htmlspecialchars($business["phone"], ENT_QUOTES, "UTF-8") ?>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Opening hours</span>
                        <i class="fa-regular fa-clock"></i>
                        <?= htmlspecialchars($business["hours"], ENT_QUOTES, "UTF-8") ?>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Category</span>
                        <i class="fa-solid fa-tag"></i>
                        <?= htmlspecialchars($business["category"], ENT_QUOTES, "UTF-8") ?>
                    </div>
                </div>

                <h2>Products and services</h2>

                <ul class="service-list">
                    <?php foreach ($business["services"] as $service): ?>
                        <li><?= htmlspecialchars($service, ENT_QUOTES, "UTF-8") ?></li>
                    <?php endforeach; ?>
                </ul>

                <div class="details-actions">
                    <a class="details-button"
                       href="tel:<?= htmlspecialchars($business["phone"], ENT_QUOTES, "UTF-8") ?>">
                        <i class="fa-solid fa-phone"></i> Call business
                    </a>

                <?php
                 $mapLocation = trim(($business['name'] ?? '') . ', ' . ($business['location'] ?? '') . ', Dahod, Gujarat');
                 $mapUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($mapLocation);
                 ?>

                <a href="<?= htmlspecialchars($mapUrl, ENT_QUOTES, 'UTF-8') ?>"
                target="_blank" class="details-button" rel="noopener noreferrer">
                 <i class="fa-solid fa-map-location-dot"></i> View on Maps
                </a>

                </div>

                <p class="demo-note">
                    Demo data for project testing. Names, ratings, reviews,
                    phone numbers, addresses, hours and services have not
                    been verified. Replace these with verified details before
                    publishing this directory.
                </p>
            </div>
        </article>

    <?php endif; ?>
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
