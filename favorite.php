<?php
include "db_connect.php";

if (isset($_POST['id']) && isset($_POST['action'])) {//get the body of the POST request (fetch)
    $platformId = intval($_POST['id']);//The intval() function returns the integer value of a variable.
    $userId = $_SESSION['user_id']; 
    $action = $_POST['action'];

    if ($action === 'add') {
        $sql = "INSERT INTO favorites (idUser, idPlatform) VALUES (?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $userId, $platformId);//"ii" means two integers
        $stmt->execute();
        echo "added to favorites";
    } elseif ($action === 'remove') {
        $sql = "DELETE FROM favorites WHERE idUser = ? AND idPlatform = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $userId, $platformId);
        $stmt->execute();
        echo "removed from favorites";
    }
}
?>
