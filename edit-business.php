
<?php
session_start();
require_once __DIR__ . "/db.php";

if (!isset($_SESSION["owner_id"])) {
    header("Location: Owner.php");
    exit();
}

$ownerId = (int) $_SESSION["owner_id"];
$businessId = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

$message = "";
$error = "";

// Fetch business belonging to logged-in owner
$stmt = $conn->prepare("
    SELECT * FROM businesses
    WHERE business_id = ? AND owner_id = ?
");
$stmt->bind_param("ii", $businessId, $ownerId);
$stmt->execute();

$result = $stmt->get_result();
$business = $result->fetch_assoc();
$stmt->close();

if (!$business) {
    die("Business not found or you are not authorized to edit it.");
}

// Fetch categories
$categories = [];
$result = $conn->query("SELECT category_id, category_name FROM categories");

while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch existing services
$services = [];

$stmt = $conn->prepare("
    SELECT service_name FROM business_services
    WHERE business_id = ?
");
$stmt->bind_param("i", $businessId);
$stmt->execute();

$serviceResult = $stmt->get_result();

while ($row = $serviceResult->fetch_assoc()) {
    $services[] = $row["service_name"];
}
$stmt->close();

// Update business
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $businessName = trim($_POST["business_name"] ?? "");
    $categoryId = (int) ($_POST["category"] ?? 0);
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $address = trim($_POST["address"] ?? "");
    $serviceInput = trim($_POST["services"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $hours = trim($_POST["hours"] ?? "");
    $imageUrl = trim($_POST["image_url"] ?? "");

    if ($businessName === "" || $categoryId <= 0 || $address === "") {
        $error = "Please fill all required fields.";
    } else {

        $categoryCheck = $conn->prepare(
            "SELECT category_id FROM categories WHERE category_id = ?"
        );
        $categoryCheck->bind_param("i", $categoryId);
        $categoryCheck->execute();
        $validCategory = $categoryCheck->get_result()->num_rows > 0;
        $categoryCheck->close();

        if (!$validCategory) {
            $error = "Please select a valid category.";
        } else {

            $serviceList = array_filter(
                array_map("trim", explode(",", $serviceInput))
            );

            try {
                $conn->begin_transaction();

                $stmt = $conn->prepare("
                    UPDATE businesses
                    SET business_name = ?,
                        category_id = ?,
                        phone = ?,
                        email = ?,
                        address = ?,
                        description = ?,
                        opening_hours = ?,
                        image_url = ?
                    WHERE business_id = ? AND owner_id = ?
                ");

                $stmt->bind_param(
                    "sissssssii",
                    $businessName,
                    $categoryId,
                    $phone,
                    $email,
                    $address,
                    $description,
                    $hours,
                    $imageUrl,
                    $businessId,
                    $ownerId
                );

                $stmt->execute();
                $stmt->close();

                $stmt = $conn->prepare(
                    "DELETE FROM business_services WHERE business_id = ?"
                );
                $stmt->bind_param("i", $businessId);
                $stmt->execute();
                $stmt->close();

                $stmt = $conn->prepare("
                    INSERT INTO business_services (business_id, service_name)
                    VALUES (?, ?)
                ");

                foreach ($serviceList as $service) {
                    $stmt->bind_param("is", $businessId, $service);
                    $stmt->execute();
                }

                $stmt->close();

                $conn->commit();

                header("Location: Owner-dashboard.php");
                exit();

            } catch (Throwable $e) {
                $conn->rollback();
                $error = "Unable to update business. Please try again.";
            }
        }
    }

    // Keep submitted values in form if validation fails
    $business["business_name"] = $businessName;
    $business["category_id"] = $categoryId;
    $business["phone"] = $phone;
    $business["email"] = $email;
    $business["address"] = $address;
    $business["description"] = $description;
    $business["opening_hours"] = $hours;
    $business["image_url"] = $imageUrl;
    $services = $serviceList ?? [];
}

$pageTitle = "Edit Business | Dahod Nearby";

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
</head>
<body>

<div class="register-business-page">
    <div class="register-business-heading">
        <h1>Edit Your Business</h1>
        <p>Update your business information</p>
    </div>

    <div class="register-business-card">

        <?php if ($error): ?>
            <p class="error-message"><?= e($error) ?></p>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label>Business Name *</label>
                <input type="text" name="business_name"
                       value="<?= e($business["business_name"]) ?>" required>
            </div>

            <div class="form-group">
                <label>Category *</label>
                <select name="category" required>
                    <option value="">Select Category</option>

                    <?php foreach ($categories as $category): ?>
                        <option value="<?= e($category["category_id"]) ?>"
                            <?= $business["category_id"] == $category["category_id"] ? "selected" : "" ?>>
                            <?= e($category["category_name"]) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone"
                       value="<?= e($business["phone"]) ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                       value="<?= e($business["email"]) ?>">
            </div>

            <div class="form-group">
                <label>Address *</label>
                <input type="text" name="address"
                       value="<?= e($business["address"]) ?>" required>
            </div>

            <div class="form-group">
                <label>Services (comma separated)</label>
                <input type="text" name="services"
                       value="<?= e(implode(", ", $services)) ?>">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description"><?= e($business["description"]) ?></textarea>
            </div>

            <div class="form-group">
                <label>Opening Hours</label>
                <input type="text" name="hours"
                       value="<?= e($business["opening_hours"]) ?>">
            </div>

            <div class="form-group">
                <label>Image URL</label>
                <input type="text" name="image_url"
                       value="<?= e($business["image_url"]) ?>">
            </div>

            <button type="submit" class="register-submit-button">
                Update Business
            </button>

            <a href="Owner-dashboard.php">Cancel</a>

        </form>
    </div>
</div>

</body>
</html>
