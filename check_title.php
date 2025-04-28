<?php
require_once 'db_connect.php'; // Replace with your actual database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title'])) {
    $title = strtoupper(trim($_POST['title'])); // Convert to uppercase to ensure case insensitivity
    $stmt = $conn->prepare("SELECT COUNT(*) FROM projects WHERE title = ?");
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    echo ($count > 0) ? "exists" : "available";
}
?>
