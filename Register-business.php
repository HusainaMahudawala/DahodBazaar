<?php
require_once "db.php";

$pageTitle = "Register Your Business | Dahod Nearby";

$message = "";
$messageType = "";
$formData = [
    "business_name" => "",
    "category" => "",
    "owner_name" => "",
    "phone" => "",
    "email" => "",
    "address" => "",
    "services" => "",
    "description" => "",
    "hours" => "",
    "image_url" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $businessName = trim($_POST["business_name"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $ownerName = trim($_POST["owner_name"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";
    $address = trim($_POST["address"] ?? "");
    $services = trim($_POST["services"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $hours = trim($_POST["hours"] ?? "");
    $imageUrl = trim($_POST["image_url"] ?? "");
    $formData = [
    "business_name" => $businessName,
    "category" => $category,
    "owner_name" => $ownerName,
    "phone" => $phone,
    "email" => $email,
    "address" => $address,
    "services" => $services,
    "description" => $description,
    "hours" => $hours,
    "image_url" => $imageUrl
];

    if (
        $businessName === "" || $category === "" ||
        $ownerName === "" || $phone === "" ||
        $email === "" || $password === "" ||
        $address === "" || $services === "" ||
        $description === ""
    ) {
        $message = "Please fill all required fields.";
        $messageType = "error";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $messageType = "error";

    } elseif (strlen($password) < 8) {
        $message = "Password must contain at least 8 characters.";
        $messageType = "error";

    } elseif ($password !== $confirmPassword) {
        $message = "Passwords do not match.";
        $messageType = "error";

    } else {
        try {
            // db.php connection variable
            if (!isset($conn) && isset($con)) {
                $conn = $con;
            }

            if (!isset($conn)) {
                throw new Exception("Database connection variable not found in db.php.");
            }

            $conn->begin_transaction();

            // Check whether this email is already registered
            $check = $conn->prepare(
                "SELECT owner_id FROM owners WHERE email = ?"
            );
            $check->bind_param("s", $email);
            $check->execute();
            $existingOwner = $check->get_result();

            if ($existingOwner->num_rows > 0) {
                throw new Exception("This email is already registered. Please use another email.");
            }

            // Find selected category ID
            $categoryQuery = $conn->prepare(
                "SELECT category_id FROM categories WHERE category_name = ?"
            );
            $categoryQuery->bind_param("s", $category);
            $categoryQuery->execute();
            $categoryResult = $categoryQuery->get_result();

            if ($categoryResult->num_rows === 0) {
                throw new Exception("Selected category was not found.");
            }

            $categoryRow = $categoryResult->fetch_assoc();
            $categoryId = (int)$categoryRow["category_id"];

            // Securely hash the password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insert owner
            $ownerQuery = $conn->prepare(
                "INSERT INTO owners (owner_name, email, phone, password_hash)
                 VALUES (?, ?, ?, ?)"
            );
            $ownerQuery->bind_param(
                "ssss",
                $ownerName,
                $email,
                $phone,
                $passwordHash
            );
            $ownerQuery->execute();

            $ownerId = $conn->insert_id;

            // Generate a unique business slug
            $slug = strtolower(trim($businessName));
            $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
            $slug = trim($slug, '-') . '-' . time();

            // Insert business with pending approval status
            $businessQuery = $conn->prepare(
                "INSERT INTO businesses
                (owner_id, category_id, business_name, slug, tag,
                 address, city, area, phone, email, description,
                 opening_hours, image_url, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')"
            );

            $tag = $category;
            $city = "Dahod";
            $area = "Dahod";

            $businessQuery->bind_param(
                "iisssssssssss",
                $ownerId,
                $categoryId,
                $businessName,
                $slug,
                $tag,
                $address,
                $city,
                $area,
                $phone,
                $email,
                $description,
                $hours,
                $imageUrl
            );

            $businessQuery->execute();
            $businessId = $conn->insert_id;

            // Insert multiple services
            $serviceList = explode(",", $services);

            $serviceQuery = $conn->prepare(
                "INSERT INTO business_services (business_id, service_name)
                 VALUES (?, ?)"
            );

            foreach ($serviceList as $service) {
                $service = trim($service);

                if ($service !== "") {
                    $serviceQuery->bind_param("is", $businessId, $service);
                    $serviceQuery->execute();
                }
            }

            $conn->commit();

            $message = "Business submitted successfully! It is waiting for admin approval.";
            $messageType = "success";

        } catch (Throwable $e) {

            if (isset($conn) && $conn->connect_errno === 0) {
                $conn->rollback();
            }

            $message = $e->getMessage();
            $messageType = "error";
        }
    }
}
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
<link rel="stylesheet" href="/project/style.css?v=3">

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
<?php if ($message !== ""): ?>
    <p class="register-form-note"
       style="color: <?= $messageType === 'success' ? 'green' : 'red' ?>;">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>
            <div class="form-group">
                <label for="business_name">Business Name *</label>
                <input
    type="text"
    id="business_name"
    name="business_name"
    placeholder="Enter your business name"
    value="<?= htmlspecialchars($formData['business_name']) ?>"
    required
>
                
            </div>

            <div class="form-group">
                <label for="category">Business Category *</label>
               <select id="category" name="category" required>
    <option value="">Select a category</option>
    <?php
    $categories = [
        "Doctors", "Restaurants", "Salons", "Shopping",
        "Education", "Hotels", "Electronics",
        "Home Services", "Other"
    ];

    foreach ($categories as $cat):
    ?>
        <option value="<?= htmlspecialchars($cat) ?>"
            <?= $formData['category'] === $cat ? 'selected' : '' ?>>
            <?= htmlspecialchars($cat) ?>
        </option>
    <?php endforeach; ?>
</select>
            </div>

            <div class="form-group">
                <label for="owner_name">Owner Name *</label>
                <input type="text" id="owner_name" name="owner_name"
placeholder="Enter owner's name"
value="<?= htmlspecialchars($formData['owner_name']) ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" id="phone" name="phone"
placeholder="Enter phone number"
value="<?= htmlspecialchars($formData['phone']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
placeholder="Enter email address"
value="<?= htmlspecialchars($formData['email']) ?>">
                </div>
            </div>
            <div class="form-group">
    <label for="password">Create Password *</label>
    <input
        type="password"
        id="password"
        name="password"
        placeholder="Minimum 8 characters"
        minlength="8"
        required
    >
</div>

<div class="form-group">
    <label for="confirm_password">Confirm Password *</label>
    <input
        type="password"
        id="confirm_password"
        name="confirm_password"
        placeholder="Re-enter your password"
        required
    >
</div>

            <div class="form-group">
                <label for="address">Business Address *</label>
                <textarea id="address" name="address" rows="3"
placeholder="Enter your business address in Dahod"
required><?= htmlspecialchars($formData['address']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="services">Services Offered *</label>
               <input type="text" id="services" name="services"
placeholder="e.g. Haircut, Facial, Hair Styling"
value="<?= htmlspecialchars($formData['services']) ?>" required>
                <small>Separate multiple services with commas.</small>
            </div>

            <div class="form-group">
                <label for="description">Business Description *</label>
                <textarea id="description" name="description" rows="4"
placeholder="Describe your business and what makes it special"
required><?= htmlspecialchars($formData['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="hours">Business Hours</label>
                <input type="text" id="hours" name="hours"
placeholder="e.g. Monday–Saturday, 9 AM–8 PM"
value="<?= htmlspecialchars($formData['hours']) ?>">
            </div>

            <div class="form-group">
                <label for="image_url">Business Image URL (Optional)</label>
                <input type="url" id="image_url" name="image_url"
placeholder="https://example.com/business-image.jpg"
value="<?= htmlspecialchars($formData['image_url']) ?>">
            </div>

            <button type="submit" class="register-submit-button">
                Submit Business
            </button>

            <p class="register-form-note">
    Your business will be visible after admin approval.
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
