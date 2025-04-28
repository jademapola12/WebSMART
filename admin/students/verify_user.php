<?php
require '../../config.php'; // Include your database connection

if (isset($_POST['id'], $_POST['expiration_date'])) {
    $id = $_POST['id'];
    $expiration_date = $_POST['expiration_date'];

    // Update the student's verification status and set the expiration date
    $stmt = $conn->prepare("UPDATE students SET status = 1, expiration_date = ? WHERE id = ?");
    $stmt->bind_param("si", $expiration_date, $id);

    if ($stmt->execute()) {
        echo "Student verified successfully. Expiration date set to: " . $expiration_date;
    } else {
        echo "Error verifying student.";
    }

    $stmt->close();
}
?>
