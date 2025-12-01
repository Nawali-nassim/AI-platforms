<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About NAWALI Web</title>
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
                <li><a href="about.php">About us</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="subscribe.html">Subscribe</a></li>
                <?php
                    if(isset($_SESSION['user_id'])) {
                        echo '<li><a href="logout.php">Log out</a></li>';
                        echo '<li><a href="profile.php">Profile</a></li>';
                    } else {
                        echo '<li><a href="loginfor.php">Log in</a></li>';
                        echo '<li><a href="signupfor.php">Sign up</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </header>
    <main>
    <div class=" divs">
        <h1 class="shape page-title">About NAWALI</h1>
        <p class="subtitle">Your smart directory for discovering the best AI tools.</p>

        <p class="about-text">
            AI Platforms Web is a simple and organized web application designed to help users explore and 
            discover the best AI platforms available online. Our goal is to make it easy for you to find the 
            right tools for programming, design, writing, productivity, and more.
                    <br><br>
            The website collects different AI websites and organizes them into clear categories. You can view 
            detailed information about each platform, save your favorites, and quickly access them whenever you need.
        </p>

        <h2 class="shape section-title">Our Purpose</h2>
        <p class="about-text">
            With AI tools increasing every day, it's difficult to know which platforms are useful or trustworthy.  
            This website offers a clean and simple experience that helps you save time, stay organized, and easily 
            navigate through different AI tools.
        </p>

        <h2 class="shape section-title">Features</h2>
        <p class="about-text">
            • Browse AI tools by categories  
            <br>• Save your favorite platforms  
            <br>• Simple and user-friendly design  
            <br>• Updated and accurate information  
        </p>

        <h2 class="shape section-title">Future Plans</h2>
        
        <p class="about-text">
            We plan to add new features such as user reviews, ratings, admin dashboard tools, and automatic updates 
            for AI platforms. This will help the website grow and give users a better experience.
                    <br><br>
            Thank you for using AI Platforms Web. We hope it helps you discover amazing tools and stay productive.
        </p>
    </div>
    </main>
        <footer>
        <nav >
            <ul id="footer-nav"> 
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About the site</a></li>
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
            <p>&copy; 2025 Nawali. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
