
<?php
session_start();
require_once __DIR__ . "/db.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: Admin-login.php");
    exit();
}

$pageTitle = "Admin Dashboard | Dahod Nearby";

// Fetch all businesses
$businesses = [];

$sql = "
    SELECT b.*, c.category_name, o.owner_name
    FROM businesses b
    LEFT JOIN categories c ON b.category_id = c.category_id
    LEFT JOIN owners o ON b.owner_id = o.owner_id
    ORDER BY b.created_at DESC
";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $businesses[] = $row;
}

$total = count($businesses);
$pending = 0;
$approved = 0;
$rejected = 0;

foreach ($businesses as $business) {
    if ($business["status"] === "pending") {
        $pending++;
    } elseif ($business["status"] === "approved") {
        $approved++;
    } elseif ($business["status"] === "rejected") {
        $rejected++;
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="style.css?v=4">
<link rel="stylesheet" href="owner-admin.css?v=1">
</head>

<body>

<div class="owner-dashboard-page">

    <div class="owner-dashboard-header">
        <div>
            <h1>Admin Dashboard</h1>
            <p>Welcome, <?= e($_SESSION["admin_name"]) ?></p>
        </div>

        <a href="Admin-logout.php" class="owner-action-link">
            Logout
        </a>
    </div>

    <div class="owner-dashboard-stats">

        <div class="owner-stat-card">
            <h3>Total Businesses</h3>
            <h2><?= $total ?></h2>
        </div>

        <div class="owner-stat-card">
            <h3>Pending</h3>
            <h2><?= $pending ?></h2>
        </div>

        <div class="owner-stat-card">
            <h3>Approved</h3>
            <h2><?= $approved ?></h2>
        </div>

        <div class="owner-stat-card">
            <h3>Rejected</h3>
            <h2><?= $rejected ?></h2>
        </div>

    </div>

    <div class="owner-dashboard-content">

        <h2>Manage Business Listings</h2>

        <div class="owner-table-wrapper">
            <table class="owner-business-table">

                <thead>
                    <tr>
                        <th>Business</th>
                        <th>Owner</th>
                        <th>Category</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (empty($businesses)): ?>

                    <tr>
                        <td colspan="6">No businesses found.</td>
                    </tr>

                <?php else: ?>

                    <?php foreach ($businesses as $business): ?>

                        <tr>
                            <td><?= e($business["business_name"]) ?></td>

                            <td><?= e($business["owner_name"] ?? "N/A") ?></td>

                            <td><?= e($business["category_name"] ?? "Other") ?></td>

                            <td><?= e($business["phone"]) ?></td>

                            <td>
                                <?= e(ucfirst($business["status"])) ?>
                            </td>

                            <td>
                                <a href="Business.php?id=<?= urlencode($business["business_id"]) ?>"
                                   class="owner-action-link">
                                    View
                                </a>

                                <?php if ($business["status"] !== "approved"): ?>
                                    <form action="Admin-action.php" method="POST">
                                        <input type="hidden" name="business_id"
                                               value="<?= e($business["business_id"]) ?>">
                                        <input type="hidden" name="action"
                                               value="approve">
                                        <button type="submit">Approve</button>
                                    </form>
                                <?php endif; ?>

                                <?php if ($business["status"] !== "rejected"): ?>
                                    <form action="Admin-action.php" method="POST"
                                          onsubmit="return confirm('Reject this business?');">
                                        <input type="hidden" name="business_id"
                                               value="<?= e($business["business_id"]) ?>">
                                        <input type="hidden" name="action"
                                               value="reject">
                                        <button type="submit">Reject</button>
                                    </form>
                                <?php endif; ?>

                            </td>
                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>
            </table>
        </div>

    </div>

</div>

</body>
</html>
