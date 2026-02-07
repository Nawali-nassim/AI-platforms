<?php
session_start();
include "../connectDB.php";
if(isset($_SESSION['admin-id']) && $_SESSION['admin-id'] > 0) {
   if (isset($_POST['id'])) {
    $platformId = intval($_POST['id']);
    $sql = "DELETE FROM platforms WHERE idP = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $platformId);
    if ($stmt->execute()) {
        echo "Platform deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
   }
} else {
    die("You must be logged in as admin to manage platforms.");
}
?>