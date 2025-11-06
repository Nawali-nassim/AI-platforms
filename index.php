<?php
session_start();
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
                        echo '<li><a href="editProfile.php">Profile</a></li>';
                    } else {
                        echo '<li><a href="loginfor.php">Log in</a></li>';
                        echo '<li><a href="signupfor.php">Sign up</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </header>
    <main>
        <div id="hero" class="divs">
            <br>
            <h1>One platform.<br>Unlimited AI tools .</h1>
            <a href="category.php" class="hero">Explore category</a>
            <a href="signupfor.php" class="hero">Sign up</a>
        </div>
        <div class="divs">
            <h3>Why using Nawali?</h3>
            <div class="why">
                <p >
                    <i class="fa-solid fa-bolt"></i><br>
                    <span><b>Productivity</b></span><br>
                    <span>Boost efficiency with AI that helps you manage tasks, organize data, and save valuable time.</span>
                </p>
                <p>
                    <i class="fa-solid fa-palette"></i><br>
                    <span><b>Creativity</b></span><br>
                    <span>Unleash your imagination with AI-powered tools for writing, design, and content creation.</span>
                </p>
                <p>
                    <i class="fa-solid fa-robot"></i><br>
                    <span><b>Automation</b></span><br>
                    <span>Automate repetitive tasks and let AI handle the routine, so you can focus on what matters.</span>
                </p>
                <p>
                    <i class="fa-solid fa-diagram-project"></i><br>
                    <span><b>Integration</b></span><br>
                    <span>connect multiple AI tools seamlessly without switching between websites</span>
                </p>
            </div>
        </div>
        <div  class="divs">
            <h3> Explore Categories</h3>
            <div class="categories">
                <p class="test">
                    <i class="fa-solid fa-video"></i><br>
                    <span><b>Video</b></span><br>
                    <img src="images/video editing1.jpg" alt="video editing with AI">
                </p>
                <p class="test" onclick="window.location.href='chatC.html'">
                    <i class="fa-solid fa-comment"></i><br>
                    <span><b> Chat</b></span><br>
                    <img src="images/chat Ai.jpg" alt="chating with AI">
                </p>
                
                <p class="test">
                    <i class="fa-solid fa-image"></i><br>
                    <span><b>Image</b></span><br>
                    <img src="images/image editing.jpg" alt="image editing with AI">
                </p>
                <p class="test">
                    <i class="fa-solid fa-headphones"></i><br>
                    <span><b>Audio</b></span><br>
                    <img src="images/audio editing.jpg" alt="audio editing with AI">
                </p>
            </div> 
        </div>
    </main>
    <footer>
        <nav >
            <ul id="footer-nav"> 
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About the site</a></li>
                <li><a href="category.php">Categories</a></li>
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

</html>