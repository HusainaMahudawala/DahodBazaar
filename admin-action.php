
<?php
session_start();
require_once __DIR__ . "/db.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: Admin-login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Admin-dashboard.php");
    exit();
}

$businessId = (int) ($_POST["business_id"] ?? 0);
$action = $_POST["action"] ?? "";

if ($businessId <= 0 || !in_array($action, ["approve", "reject"], true)) {
    header("Location: Admin-dashboard.php");
    exit();
}

$status = ($action === "approve") ? "approved" : "rejected";

$stmt = $conn->prepare("
    UPDATE businesses
    SET status = ?
    WHERE business_id = ?
");

$stmt->bind_param("si", $status, $businessId);
$stmt->execute();
$stmt->close();

header("Location: Admin-dashboard.php");
exit();
?>
