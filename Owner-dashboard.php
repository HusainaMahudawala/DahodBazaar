<?php
$pageTitle = "Owner Dashboard | Dahod Nearby";

/* Demo data until MySQL is connected */
$businesses = [
    [
        "name" => "Prabhuan Restaurant",
        "category" => "Restaurant",
        "location" => "Dahod, Gujarat",
        "status" => "Approved"
    ],
    [
        "name" => "Dahod Family Food Corner",
        "category" => "Restaurant",
        "location" => "Dahod, Gujarat",
        "status" => "Pending"
    ],
    [
        "name" => "Smile Dental Care",
        "category" => "Healthcare",
        "location" => "Dahod, Gujarat",
        "status" => "Approved"
    ]
];

$totalBusinesses = count($businesses);
$approvedBusinesses = 0;
$pendingBusinesses = 0;

foreach ($businesses as $business) {
    if ($business["status"] === "Approved") {
        $approvedBusinesses++;
    } elseif ($business["status"] === "Pending") {
        $pendingBusinesses++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?></title>

    <link rel="stylesheet" href="./style.css?v=4">      
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="owner-dashboard-body">

    <!-- Top Navbar -->
    <header class="main-header">
        <div class="main-header-container">
            <a href="index.php" class="brand-logo">
                <i class="fa-solid fa-location-dot brand-location"></i>
                <span>Dahod <span class="brand-highlight">Nearby</span></span>
            </a>

            <div class="dashboard-top-right">
                <span class="owner-welcome">
                    <i class="fa-regular fa-user"></i>
                    Business Owner
                </span>

                <a href="index.php" class="dashboard-view-site">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    View Website
                </a>
            </div>
        </div>
    </header>

    <div class="owner-dashboard-layout">

        <!-- Sidebar -->
        <aside class="owner-sidebar">
            <div class="owner-sidebar-profile">
                <div class="owner-avatar">
                    <i class="fa-solid fa-user-tie"></i>
                </div>

                <div>
                    <h3>Owner Account</h3>
                    <p>Business Management</p>
                </div>
            </div>

            <p class="owner-sidebar-label">MAIN MENU</p>

            <nav class="owner-sidebar-nav">
                <a href="owner-dashboard.php" class="owner-side-link active">
                    <i class="fa-solid fa-table-columns"></i>
                    Dashboard
                </a>

                <a href="#my-businesses" class="owner-side-link">
                    <i class="fa-solid fa-store"></i>
                    My Businesses
                </a>

                <a href="register-business.php" class="owner-side-link">
                    <i class="fa-solid fa-circle-plus"></i>
                    Add Business
                </a>

                <a href="#owner-profile" class="owner-side-link">
                    <i class="fa-regular fa-id-card"></i>
                    My Profile
                </a>
            </nav>

            <div class="owner-sidebar-bottom">
                <a href="index.php" class="owner-side-link">
                    <i class="fa-solid fa-house"></i>
                    Back to Website
                </a>

                <a href="owner.php" class="owner-side-link owner-logout-link">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="owner-dashboard-main">

            <div class="owner-dashboard-heading">
                <div>
                    <p class="owner-dashboard-eyebrow">OVERVIEW</p>
                    <h1>Owner Dashboard</h1>
                    <p class="owner-dashboard-description">
                        Manage your business listings and track their status.
                    </p>
                </div>

                <a href="register-business.php"
                   class="owner-add-business-btn">
                    <i class="fa-solid fa-plus"></i>
                    Add New Business
                </a>
            </div>

            <!-- Statistics -->
            <section class="owner-stats-grid">

                <div class="owner-stat-card">
                    <div class="owner-stat-icon stat-blue">
                        <i class="fa-solid fa-store"></i>
                    </div>

                    <div>
                        <p>Total Businesses</p>
                        <h2><?= $totalBusinesses ?></h2>
                        <span>Business listings</span>
                    </div>
                </div>

                <div class="owner-stat-card">
                    <div class="owner-stat-icon stat-green">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>

                    <div>
                        <p>Approved Listings</p>
                        <h2><?= $approvedBusinesses ?></h2>
                        <span>Approved businesses</span>
                    </div>
                </div>

                <div class="owner-stat-card">
                    <div class="owner-stat-icon stat-orange">
                        <i class="fa-regular fa-clock"></i>
                    </div>

                    <div>
                        <p>Pending Approval</p>
                        <h2><?= $pendingBusinesses ?></h2>
                        <span>Awaiting review</span>
                    </div>
                </div>

            </section>

            <!-- Business Listings -->
            <section class="owner-business-section" id="my-businesses">

                <div class="owner-section-heading">
                    <div>
                        <h2>My Business Listings</h2>
                        <p>View the businesses associated with your account.</p>
                    </div>

                    <a href="register-business.php" class="owner-text-link">
                        + Add Business
                    </a>
                </div>

                <div class="owner-table-wrapper">
                    <table class="owner-business-table">
                        <thead>
                            <tr>
                                <th>Business</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($businesses as $index => $business): ?>
                                <tr>
                                    <td>
                                        <div class="owner-business-name">
                                            <div class="owner-business-mini-icon">
                                                <i class="fa-solid fa-store"></i>
                                            </div>

                                            <strong>
                                                <?= htmlspecialchars($business["name"]) ?>
                                            </strong>
                                        </div>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($business["category"]) ?>
                                    </td>

                                    <td>
                                        <i class="fa-solid fa-location-dot owner-table-location-icon"></i>
                                        <?= htmlspecialchars($business["location"]) ?>
                                    </td>

                                    <td>
                                        <span class="owner-status
                                            <?= $business["status"] === "Approved"
                                                ? "status-approved"
                                                : "status-pending" ?>">
                                            <?= htmlspecialchars($business["status"]) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <a href="business.php"
                                           class="owner-action-link"
                                           title="View business">
                                            <i class="fa-regular fa-eye"></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <p class="owner-demo-note">
                    <i class="fa-solid fa-circle-info"></i>
                    These are sample listings. Your actual business data will appear
                    here after database integration.
                </p>

            </section>

            <!-- Profile placeholder -->
            <section class="owner-profile-section" id="owner-profile">
                <div class="owner-profile-icon">
                    <i class="fa-regular fa-user"></i>
                </div>

                <div>
                    <h2>Owner Profile</h2>
                    <p>
                        Your account details and profile settings can be added
                        here when owner registration and login are connected.
                    </p>
                </div>
            </section>

            <footer class="owner-dashboard-footer">
                &copy; <?= date("Y") ?> Dahod Nearby. All rights reserved.
            </footer>

        </main>
    </div>

</body>
</html>
