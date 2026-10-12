
<?php
$pageTitle = "Search Businesses | DohadBazar.com";

// Get search values from the URL.
$keyword = trim($_GET['keyword'] ?? '');
$category = trim($_GET['category'] ?? '');
$city = trim($_GET['city'] ?? '');

// Temporary sample data.
// We will replace this array with MySQL data later.
$businesses = [
    [
        'name' => 'Local Restaurant',
        'category' => 'Restaurants',
        'city' => 'Dahod',
        'area' => 'Dahod City',
        'address' => 'Dahod, Gujarat',
        'icon' => 'fa-utensils',
        'imageClass' => 'food-image',
        'tag' => 'Food & Dining'
    ],
    [
        'name' => 'Local Salon',
        'category' => 'Salons',
        'city' => 'Dahod',
        'area' => 'Dahod City',
        'address' => 'Dahod, Gujarat',
        'icon' => 'fa-scissors',
        'imageClass' => 'salon-image',
        'tag' => 'Beauty & Care'
    ],
    [
        'name' => 'Local Clinic',
        'category' => 'Doctors',
        'city' => 'Dahod',
        'area' => 'Dahod City',
        'address' => 'Dahod, Gujarat',
        'icon' => 'fa-user-doctor',
        'imageClass' => 'doctor-image',
        'tag' => 'Healthcare'
    ]
];

// Filter businesses by keyword, category, and city/area.
$results = array_filter($businesses, function ($business) use (
    $keyword,
    $category,
    $city
) {
    $searchableText = implode(' ', [
        $business['name'],
        $business['category'],
        $business['city'],
        $business['area'],
        $business['address'],
        $business['tag']
    ]);

    $matchesKeyword = $keyword === '' ||
        stripos($searchableText, $keyword) !== false;

    $matchesCategory = $category === '' ||
        strcasecmp($business['category'], $category) === 0;

    $matchesCity = $city === '' ||
        stripos($business['city'] . ' ' . $business['area'] . ' ' .
            $business['address'], $city) !== false;

    return $matchesKeyword && $matchesCategory && $matchesCity;
});

$resultCount = count($results);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="style.css">

    <style>
        /* Styles for this page only. Homepage CSS is unchanged. */
        .search-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 45px 22px 70px;
        }

        .search-page h1 {
            margin-bottom: 10px;
        }

        .search-page-intro {
            color: #64748b;
            margin-bottom: 28px;
        }

        .results-search-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 12px;
            margin-bottom: 30px;
            padding: 20px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
        }

        .results-search-form input,
        .results-search-form select {
            width: 100%;
            min-width: 0;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font: inherit;
            background: #fff;
        }

        .results-search-form button {
            padding: 13px 22px;
            border: none;
            border-radius: 8px;
            background: #2457f5;
            color: #fff;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .results-count {
            margin-bottom: 20px;
            color: #64748b;
        }

        .no-results {
            padding: 35px 20px;
            text-align: center;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
        }

        .no-results i {
            font-size: 32px;
            color: #64748b;
            margin-bottom: 12px;
        }

        .back-home {
            display: inline-block;
            margin-top: 24px;
            color: #2457f5;
            text-decoration: none;
        }

        @media (max-width: 760px) {
            .results-search-form {
                grid-template-columns: 1fr;
            }
        }
    </style>
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

    <a href="index.php#businesses" class="add-business">
        <i class="fa-solid fa-house"></i> Home
    </a>
</header>

<main class="search-page">

    <span class="section-label">LOCAL DISCOVERY</span>
    <h1>Search local businesses</h1>

    <p class="search-page-intro">
        Find businesses in Dahod by keyword, category, or city/area.
    </p>

    <form class="results-search-form" action="Search.php" method="GET">

        <input
            type="search"
            name="keyword"
            placeholder="Business name or keyword"
            value="<?= htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8') ?>"
            aria-label="Search by keyword">

        <select name="category" aria-label="Select category">
            <option value="">All categories</option>

            <?php
            $categories = ['Restaurants', 'Salons', 'Doctors'];

            foreach ($categories as $item):
            ?>
                <option
                    value="<?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?>"
                    <?= strcasecmp($category, $item) === 0 ? 'selected' : '' ?>>
                    <?= htmlspecialchars($item, ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input
            type="text"
            name="city"
            placeholder="City or area"
            value="<?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8') ?>"
            aria-label="Search by city or area">

        <button type="submit">
            <i class="fa-solid fa-magnifying-glass"></i> Search
        </button>

    </form>

    <p class="results-count">
        <?= $resultCount ?>
        <?= $resultCount === 1 ? 'business' : 'businesses' ?> found
    </p>

    <?php if ($resultCount > 0): ?>

        <div class="business-grid" id="businessGrid">

            <?php foreach ($results as $business): ?>

                <article class="business-card"
                         data-category="<?= htmlspecialchars($business['category'], ENT_QUOTES, 'UTF-8') ?>">

                    <div class="business-image <?= htmlspecialchars($business['imageClass'], ENT_QUOTES, 'UTF-8') ?>">
                        <i class="fa-solid <?= htmlspecialchars($business['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>

                        <span class="listing-tag">
                            <?= htmlspecialchars($business['tag'], ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </div>

                    <div class="business-info">

                        <h3>
                            <?= htmlspecialchars($business['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <p>
                            <i class="fa-solid fa-location-dot"></i>
                            <?= htmlspecialchars($business['address'], ENT_QUOTES, 'UTF-8') ?>
                        </p>

                        <div class="business-actions">
                            <span class="sample-label">Sample listing</span>

                            <a
                                class="outline-button"
                                href="index.php#businesses"
                                style="text-decoration:none">
                                Explore
                            </a>
                        </div>

                    </div>
                </article>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="no-results">
            <i class="fa-solid fa-magnifying-glass"></i>

            <h2>No businesses found</h2>

            <p>
                Try a different keyword, category, or city/area.
            </p>
        </div>

    <?php endif; ?>

    <a href="index.php" class="back-home">
        <i class="fa-solid fa-arrow-left"></i> Back to homepage
    </a>

</main>

</body>
</html>
