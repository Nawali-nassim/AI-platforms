<?php
session_start();
include "../connectDB.php";
if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0) {
    if (isset($_POST['id']) && isset($_POST['status'])) {
        $feedbackId = intval($_POST['id']);
        $newStatus = $_POST['status'];
        $sql = "UPDATE feedbacks SET status = ? WHERE idFeed = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $newStatus, $feedbackId);
        if ($stmt->execute()) {
            echo "Feedback status updated successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
} else {
    die("You must be logged in as admin to manage platforms.");
}
?>