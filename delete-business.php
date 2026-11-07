<?php
session_start();
require_once __DIR__ . "/db.php";

if (!isset($_SESSION["owner_id"])) {
    header("Location: Owner.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_POST["business_id"])) {
    header("Location: Owner-dashboard.php");
    exit();
}

$businessId = (int) $_POST["business_id"];
$ownerId = (int) $_SESSION["owner_id"];

$stmt = $conn->prepare(
    "DELETE FROM businesses WHERE business_id = ? AND owner_id = ?"
);

$stmt->bind_param("ii", $businessId, $ownerId);
$stmt->execute();

$stmt->close();

header("Location: Owner-dashboard.php");
exit();
?>