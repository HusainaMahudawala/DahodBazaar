
<?php
session_start();
require_once __DIR__ . "/db.php";

if (!isset($_SESSION["owner_id"])) {
    header("Location: Owner.php");
    exit();
}

$ownerId = (int) $_SESSION["owner_id"];
$error = "";
$success = "";

// Fetch owner details
$stmt = $conn->prepare("
    SELECT owner_name, email, phone
    FROM owners
    WHERE owner_id = ?
");

$stmt->bind_param("i", $ownerId);
$stmt->execute();

$result = $stmt->get_result();
$owner = $result->fetch_assoc();
$stmt->close();

if (!$owner) {
    die("Owner account not found.");
}

// Update profile
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["owner_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");

    if ($name === "" || $email === "") {
        $error = "Name and email are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {

        // Check whether email belongs to another owner
        $check = $conn->prepare("
            SELECT owner_id FROM owners
            WHERE email = ? AND owner_id != ?
        ");

        $check->bind_param("si", $email, $ownerId);
        $check->execute();

        $emailExists = $check->get_result()->num_rows > 0;
        $check->close();

        if ($emailExists) {
            $error = "This email is already registered.";
        } else {

            $stmt = $conn->prepare("
                UPDATE owners
                SET owner_name = ?, email = ?, phone = ?
                WHERE owner_id = ?
            ");

            $stmt->bind_param("sssi", $name, $email, $phone, $ownerId);

            if ($stmt->execute()) {
                $success = "Profile updated successfully!";

                $owner["owner_name"] = $name;
                $owner["email"] = $email;
                $owner["phone"] = $phone;
            } else {
                $error = "Unable to update profile.";
            }

            $stmt->close();
        }
    }

    // Keep entered values if validation fails
    if ($error !== "") {
        $owner["owner_name"] = $name;
        $owner["email"] = $email;
        $owner["phone"] = $phone;
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

$pageTitle = "My Profile | Dahod Nearby";
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

<div class="register-business-page">

    <div class="register-business-heading">
        <h1>My Profile</h1>
        <p>Manage your account information</p>
    </div>

    <div class="register-business-card">

        <?php if ($success): ?>
            <p class="success-message"><?= e($success) ?></p>
        <?php endif; ?>

        <?php if ($error): ?>
            <p class="error-message"><?= e($error) ?></p>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label>Owner Name *</label>
                <input type="text"
                       name="owner_name"
                       value="<?= e($owner["owner_name"]) ?>"
                       required>
            </div>

            <div class="form-group">
                <label>Email Address *</label>
                <input type="email"
                       name="email"
                       value="<?= e($owner["email"]) ?>"
                       required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text"
                       name="phone"
                       value="<?= e($owner["phone"]) ?>">
            </div>

            <button type="submit" class="register-submit-button">
                Update Profile
            </button>

            <a href="Owner-dashboard.php">Back to Dashboard</a>

        </form>

    </div>
</div>

</body>
</html>
