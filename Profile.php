<?php
session_start();
include 'connectDB.php';

if(!isset($_SESSION['user_id'])){
    header('location:loginfor.php');
    exit();
}

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
    <main>
        <div>
            <?php if (isset($_GET['info_updated'])): ?>
                <div class="success">Profile information updated successfully!</div>
            <?php endif; ?>
            <?php if (isset($_GET['pass_updated'])): ?>
                <div class="success">Password changed successfully!</div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="error"><?= htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <h2>Edit Profile</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off">
                <label for="userName">User name:</label><br>
                <input type="text" id="userName" name="username" placeholder="Enter your new user name" class="validate-username" autocomplete="off" pattern="[A-Za-z0-9_@#&-]+"><br><br>
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email" autocomplete="off" placeholder="Enter your new email"><br>
                <input type="submit" value="Save Changes">
            </form>
            
        </div>
        <h2>Change Password</h2>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" autocomplete="off">
            <input type="hidden" name="update_password" value="1">

            <label>Current Password</label><br>
            <input type="password" name="old_pass" placeholder="Enter current password" required><br>

            <label>New Password</label><br>
            <input type="password" name="new_pass" placeholder="Enter new password" required><br>

            <label>Confirm New Password</label><br>
            <input type="password" name="confirm_pass" placeholder="Confirm new password" required><br>

            <button type="submit">Update Password</button>
        </form>
    </div>
        <?php
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
                if($stmt){
                    $stmt->bind_param("i", $userId);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    if ($row = $res->fetch_assoc()) {
                        if (password_verify($current, $row['password'])) {
                            if ($new === $confirm && strlen($new) >= 8) {
                                $hash = password_hash($new, PASSWORD_DEFAULT);
                                $u = $con->prepare("UPDATE users SET password = ? WHERE PID = ?");
                                if($u){
                                    $u->bind_param("si", $hash, $userId);
                                if ($u->execute()) {
                                    $u->close();
                                    header("Location: Profile.php?pass_updated=1");
                                    exit(); // PRG to avoid resubmit
                                } else {
                                    header("Location: Profile.php?error=" . urlencode("Update error: " . $u->error));
                                    exit();
                                }
                            } else {
                                header("Location: Profile.php?error=" . urlencode("New passwords must match and be at least 8 characters."));
                                exit();
                            }
                        } else {
                            header("Location: Profile.php?error=" . urlencode("Current password incorrect."));
                            exit();
                        }
                    }
                    $stmt->close();
                    } else {
                    header("Location: Profile.php?error=" . urlencode("Prepare failed: " . $con->error));
                    exit();
                    }
                }
            }
        }
        

        mysqli_close($con);
        ?>
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