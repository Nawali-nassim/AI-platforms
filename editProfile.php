<?php
session_start();
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
                        echo '<li><a href="editProfile.php">edit profile</a></li>';
                    } else {
                        echo '<li><a href="loginfor.php">Log in</a></li>';
                        echo '<li><a href="signupfor.php">Sign up</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        
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
            <p>&copy; 2023 Nawali. All rights reserved.</p>
        </div>
    </footer>
</body>