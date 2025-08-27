<?php
session_start();
include 'connectDB.php';

$username = $_POST['username'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Use prepared statement for SELECT
$stmt = $con->prepare("SELECT * FROM users WHERE user_name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    echo "Username already taken.";
    exit();
} else {
    $stmt = $con->prepare("INSERT INTO users (user_name, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        $_SESSION['username'] = $username;
        header("Location: index.html");
        exit();
    } else {
        echo "Error inserting user: " . $stmt->error;
        exit();
    }
}
mysqli_close($con);
?>