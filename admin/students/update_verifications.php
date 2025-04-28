<?php
require '../../config.php';

// Automatically unverify students whose expiration date has passed
$today = date("Y-m-d");
$stmt = $conn->prepare("UPDATE students SET status = 0 WHERE expiration_date <= ?");
$stmt->bind_param("s", $today);
$stmt->execute();
$stmt->close();

echo "Expired accounts have been expired/inActive.";
?>
