<?php
session_start();
include "../connectDB.php";
if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0) {
        if (isset($_POST['id'])) {
        $feedbackId = intval($_POST['id']);
        $sql = "DELETE FROM feedbacks WHERE idFeed = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $feedbackId);
        if ($stmt->execute()) {
            echo "Feedback deleted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }}
} else {
    die("You must be logged in as admin to manage platforms.");
}
?>