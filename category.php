<?php
include 'connectDB.php';
session_start();

$catsRes = $con->query("SELECT * FROM categories ORDER BY idC");
$categories = [];
while($c = $catsRes->fetch_assoc()) {
    $categories[] = $c;
}

$platRes = $con->query("
  SELECT * FROM platforms  
  ORDER BY name
");
$platforms = [];
while($p = $platRes->fetch_assoc()) {
    $platforms[] = $p;
}
//for favorites
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
if ($userId > 0) {
    $favResult = $con->query("SELECT idPlatform FROM favorites WHERE idUser = $userId");
    $favorites = [];
    if (!$favResult ) {
        die("Query error: " . $con->error);
    }
    while($row = $favResult->fetch_assoc()) {
        $favorites[] = $row['idPlatform'];
    }
} else {
    $favorites = [];
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
                <li><a href="about.html">About us</a></li>
                <li><a href="category.html">Categories</a></li>
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
    <div class="divs">
        <h1>Categories</h1>
        <span><?php 
        if (isset($_SESSION['user_name'])) {
            echo "Welcome, " . htmlspecialchars($_SESSION['user_name']) . "!";
        } else {
            echo "Welcome, Guest!";
        }
        ?></span>
        <h4>click on the category card and the Platforms will be filtered </h4><br>
        <p> <input type="search" name="searchInput" id="searchInput" placeholder="Search platforms here"></p>
    </div>
    <div class="cards">
        <?php foreach($categories as $cat): ?>
            <div class="categoryCard" data-cat="<?=htmlspecialchars($cat['idC'])?>" tabindex="0" >
                <h2><?=htmlspecialchars($cat['name'])?></h2>
                <p>
                <?= htmlspecialchars(trim($cat['description'])) !== '' ? htmlspecialchars($cat['description']) 
                    : 'No description available.' ?>
                </p>            
            </div>
        <?php endforeach; ?>
    </div>


    <div class="divs">

        <h3 id="defaultTitle"  style="display:block;"> All platforms</h3>
        <h3 class="title" data-cat="1" style="display:none;"> Chat platforms</h3>
        <h3 class="title" data-cat="2" style="display:none;">Video platforms </h3>
        <h3 class="title" data-cat="3" style="display:none;"> Image platforms</h3>
        <h3 class="title" data-cat="4" style="display:none;"> Audio platfoms</h3>

        <div id="empty-msg" style="display:none; margin:12px 0;">no platform in this category</div>
        
        <div  id="platformsContainer">
            <?php foreach($platforms as $p): ?>
            <div class="platformCard" data-cat="<?=htmlspecialchars($p['idCategory'])?>" id="platform-<?=intval($p['idP'])?>">
                <img src="images/<?=htmlspecialchars($p['icon'])?>" alt="<?=htmlspecialchars($p['name'])?>" loading="lazy">
                <h4><?=htmlspecialchars($p['name'])?></h4>
                <p class=" desc">
                    
                    <?=htmlspecialchars($p['description'])?>
                </p>

                <div class="cardFooter">
                    <button class="star" >
                        <i class="favorite-icon <?= in_array(htmlspecialchars($p['idP']), $favorites) ? 'fas active' : 'far' ?> fa-star"
                            data-id="<?=htmlspecialchars($p['idP'])?>"></i>
                    </button>
                    <button class="visit">
                        <a class="Nodecoration" href="<?=htmlspecialchars($p['link'])?>" target="_blank" rel="noopener noreferrer">Visit the web</a>
                    </button>
                <!--noopener: Prevents the new page from being able to access the window.opener property of the original page.
                 This improves security by protecting your page from potential malicious scripts on the linked site.
                noreferrer: Prevents the browser from sending the Referer header to the new page.
                 This means the new page won’t know where the visitor came from.-->
                    <button class="feedback-btn visit"
                        data-id="<?=htmlspecialchars($p['idP'])?>"
                        data-name="<?=htmlspecialchars($p['name'])?>"><!--for sending it to the modal-->
                        Give feedback
                    </button>
                </div>
            </div>
                <div id="feedbackModal" class="modal" aria-hidden="true" style="display:none;">
                <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="fbTitle">
                    <button class="modal-close" aria-label="Close">&times;</button>
                    <h3 id="fbTitle">Feedback for <span id="fbPlatformName"></span></h3>
                    <form id="feedbackForm">
                    <input type="hidden" name="platform_id" id="fbPlatformId" value="">
                    <textarea name="feedback" id="fbText" rows="6" placeholder="Write your feedback..." required></textarea>
                    <div class="modal-actions">
                        <button type="submit" class="btn-submit">Send</button>
                        <button type="button" class="btn-cancel">Cancel</button>
                    </div>
                    </form>
                    <div id="fbMsg" style="display:none;margin-top:8px;"></div>
                </div>
            </div>
            <?php endforeach; ?>
            

        </div>
    </div>
    <footer>
        <nav >
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
</html>