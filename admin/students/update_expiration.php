<?php
require_once('../../config.php'); // make sure you have a DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $expiration_date = $_POST['expiration_date'];

    // Optional: validate the date format
    $date =  $expiration_date;
    if (!$date) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid date format."
        ]);
        exit;
    }

    // Update student status based on expiration date
    $today = date('Y-m-d');
    $status = ($expiration_date < $today) ? 0 : 1;

    $stmt = $conn->prepare("UPDATE student_list SET expiration_date = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sii", $expiration_date, $status, $id);   

    if ($stmt->execute()) {
        $exp_class = ($status == 1) ? "badge-warning" : "badge-danger";
        echo json_encode([
            "status" => "success",
            "expiration_date" => $expiration_date,
            "exp_class" => $exp_class
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Database update failed."
        ]);
    }
}
?>
