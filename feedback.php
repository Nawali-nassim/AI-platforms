<?php
session_start();
include 'connectDB.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method not allowed";
    exit;
}

$platform_id = isset($_POST['platform_id']) ? intval($_POST['platform_id']) : 0;
$feedback = isset($_POST['feedback']) ? trim($_POST['feedback']) : '';

if ($platform_id <= 0 || $feedback === '') {
    echo "Please provide feedback text.";
    exit;
}
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
    $user_id =$_SESSION['user_id'];
    $stmt = $con->prepare("INSERT INTO feedbacks (idPlatform, idUser, feedback, dateSended) VALUES (?, ?, ?, NOW())");
    if (!$stmt) {
        echo "Prepare error: " . $con->error;
        exit;
    }
    $stmt->bind_param("iis", $platform_id, $user_id, $feedback);
    if ($stmt->execute()) {
        echo "Thank you — feedback saved.";
    } else {
        echo "Insert error: " . $stmt->error;
    }
    $stmt->close();}
else {
    die("You must be logged in to submit feedback.");
}
?>