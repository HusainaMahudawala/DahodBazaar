
<?php
session_start();
require_once __DIR__ . "/db.php";

$pageTitle = "Admin Login | Dahod Nearby";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("
        SELECT admin_id, admin_name, password_hash
        FROM admins
        WHERE username = ?
    ");

    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();

    if ($admin && password_verify($password, $admin["password_hash"])) {

        session_regenerate_id(true);

        $_SESSION["admin_id"] = $admin["admin_id"];
        $_SESSION["admin_name"] = $admin["admin_name"];

        header("Location: Admin-dashboard.php");
        exit();

    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="style.css?v=4">
<link rel="stylesheet" href="owner-admin.css?v=1">
</head>
<body>

<div class="register-business-page">

    <div class="register-business-heading">
        <h1>Admin Login</h1>
        <p>Welcome to Dahod Nearby Administration</p>
    </div>

    <div class="register-business-card">

        <?php if ($error): ?>
            <p class="error-message">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>

        <form method="POST">

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="register-submit-button">
                Login as Admin
            </button>

        </form>

    </div>
</div>

</body>
</html>
