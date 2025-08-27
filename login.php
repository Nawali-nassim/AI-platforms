<?php
session_start();
include 'connectDB.php';
if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
     $sql = "SELECT * FROM users WHERE user_name='$username'";
      $result = mysqli_query($con, $sql);
      if ((mysqli_num_rows($result)) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.html");
            exit();
        } else {
            $errorm= "Invalid password.";
        }
    } else {
        $errorm= "No user found with that username.";
    }
}
mysqli_close($con);
?>