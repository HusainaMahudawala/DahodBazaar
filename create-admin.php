<?php
require_once __DIR__ . "/db.php";

$adminName = "Administrator";
$username = "admin";

// Apna strong password yahan set karna
$password = "ChangeThis@123";

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("
    INSERT INTO admins (admin_name, username, password_hash)
    VALUES (?, ?, ?)
");

$stmt->bind_param("sss", $adminName, $username, $passwordHash);

if ($stmt->execute()) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>