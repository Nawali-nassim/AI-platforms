<?php
session_start();
include 'connectDB.php';

if(!isset($_SESSION['user_id'])){
    header('location:loginfor.php');
    exit();
}
// Enable errors while debugging (remove in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //update profile info-------------------------------------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['username']) || isset($_POST['email'])) {

        $username = empty($_POST['username']) ? null :test_input($_POST['username']) ;
        $email    = empty($_POST['email'])    ?  null: test_input($_POST['email'])   ;

        $sql = "UPDATE users SET ";
        $params = [];
        $types  = "";

        if ($username) { $sql .= "user_name=?, ";
                            $params[] = $username;
                            $types .= "s"; }
        if ($email)    { $sql .= "email=?, "; 
                        $params[] = $email; 
                        $types .= "s"; }

        $sql = rtrim($sql, ", ");
        $sql .= " WHERE PID=?";
        $params[] = $_SESSION['user_id'];
        $types .= "i";

        $stmt = $con->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $stmt->close();
            header("Location: Profile.php?info_updated=1");
            exit;
        } else {
            header("Location: Profile.php?error=" . urlencode("Prepare failed: " . $con->error));
            exit();
    }
    }

    //update password-------------------------------------------------------------------------------------------------
    $message = '';
    if(isset($_POST['current_pass'], $_POST['new_pass'], $_POST['confirm_pass'])){
        $userId = intval($_SESSION['user_id']);
        $current = $_POST['current_pass'];
        $new = $_POST['new_pass'];
        $confirm = $_POST['confirm_pass'];
        $stmt = $con->prepare("SELECT password FROM users WHERE PID = ?");
        if (!$stmt) {
            header("Location: Profile.php?error=" . urlencode("Prepare failed: " . $con->error));
            exit();
        }
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();
            $stmt->close();
        //check the errors
        if (!$row) {
            header("Location: Profile.php?error=" . urlencode("User not found."));
            exit();
        }
        if (!password_verify($current, $row['password'])) {
            header("Location: Profile.php?error=" . urlencode("Current password incorrect."));
            exit();
        }
        if ($new !== $confirm || strlen($new) < 8) {
            header("Location: Profile.php?error=" . urlencode("New passwords must match and be at least 8 characters."));
            exit();
        }
        //update the password
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $u = $con->prepare("UPDATE users SET password = ? WHERE PID = ?");
        if (!$u) {
            header("Location: Profile.php?error=" . urlencode("Prepare failed: " . $con->error));
            exit();
        }
        $u->bind_param("si", $hash, $userId);
        if ($u->execute()) {
            $u->close();
            header("Location: Profile.php?pass_updated=1");
            exit();
        } else {
            header("Location: Profile.php?error=" . urlencode("Update error: " . $u->error));
            exit();
}}}
mysqli_close($con);
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nawali</title>
    <script src="https://kit.fontawesome.com/3aca1396eb.js" crossorigin="anonymous"></script>
    <script src="mainJS.js"></script>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <div class="logo">
            <i class="fas fa-chess-queen"></i>
            <span>Nawali</span>
        </div>
        <nav>
            <button class="menu-toggle" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About the site</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="subscribe.html">Subscribe</a></li>
                <?php
                    if(isset($_SESSION['user_id'])) {
                        echo '<li><a href="logout.php">Log out</a></li>';
                        echo '<li><a href="Profile.php">Profile</a></li>';
                    } else {
                        echo '<li><a href="loginfor.php">Log in</a></li>';
                        echo '<li><a href="signupfor.php">Sign up</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </header>
    <main class="profile-main">
        <div class="profile-container">
        <div class="divs" id="profile-form1">
            <?php if (isset($_GET['info_updated'])): ?>
                <div class="success">Profile information updated successfully!</div>
            <?php endif; ?>
            <?php if (isset($_GET['pass_updated'])): ?>
                <div class="success">Password changed successfully!</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="error"><?= htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <h2 class="logh">Edit Profile</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off" class="profile-info-form" >
                <label for="userName" class="labels">User name:</label>
                <input class="inputs" type="text" id="userName" name="username" placeholder="Enter your new user name" class="validate-username" autocomplete="off" pattern="[A-Za-z0-9_@#&-]+"><br>
                <label for="email" class="labels">Email:</label>
                <input class="inputs" type="email" name="email" id="email" autocomplete="off" placeholder="Enter your new email"><br>
                <input type="submit" value="Save Changes" class="log-btn">
            </form>
        </div>
        <div class="divs "id="profile-form2">
            <h2 class="logh">Change Password</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" autocomplete="off" class="profile-pass-form" >
                <label class="labels" for="current_pass">Current Password:</label>
                <input class="inputs" type="password" id="current_pass" name="current_pass" placeholder="Enter current password" required>

                <label class="labels" for="new_pass">New Password:</label>
                <input class="inputs" type="password" id="new_pass" name="new_pass" placeholder="Enter new password" required>

                <label class="labels" for="confirm_pass">Confirm New Password:</label>
                <input class="inputs" type="password" id="confirm_pass" name="confirm_pass" placeholder="Confirm new password" required>

                <button type="submit" class="log-btn">Update Password</button>
            </form>
        </div>
        </div>
    </main>
    <footer>
        <nav>
        <ul id="footer-nav"> 
            <li><a href="index.php">Home</a></li>
            <li><a href="about.html">About the site</a></li>
            <li><a href="category.html">Categories</a></li>
            <li><a href="subscribe.html">Subscribe</a></li>
        </ul>
        </nav>
        <div >
            <p>Follow us on:
                <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            </p>
            <p>&copy; 2025 Nawali. All rights reserved.</p>
        </div>
    </footer>
</body>