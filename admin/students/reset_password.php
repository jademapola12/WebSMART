<?php
include '../../config.php';

if (isset($_POST['student_id'])) {
    $id = $_POST['student_id'];
    $new_password = md5("ABCDEF"); // Hash using MD5

    $update = $conn->query("UPDATE student_list SET password = '$new_password' WHERE id = '$id'");

    if ($update) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
