<?php
session_start();
include "connectDB.php";
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
   if (isset($_POST['id']) && isset($_POST['action'])) {//get the body of the POST request (fetch)
    $platformId = intval($_POST['id']);//The intval() function returns the integer value of a variable.
    $idUser = $_SESSION['user_id']; 
    $action = $_POST['action'];

    if ($action === 'add') {
        $sql = "INSERT INTO favorites (idUser, idPlatform) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $idUser, $platformId);//"ii" means two integers
        if ($stmt->execute()) {
        echo "added to favorites";
            } else {
        echo "Error: " . $stmt->error;
        }
    } elseif ($action === 'remove') {
        $sql = "DELETE FROM favorites WHERE idUser = ? AND idPlatform = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $idUser, $platformId);
        if ($stmt->execute()) {
        echo "removed from favorites";
            } else {
        echo "Error: " . $stmt->error;
        }
    }
}
} else {
    die("You must be logged in to manage favorites.");
}

?>
