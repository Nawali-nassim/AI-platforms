<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
        <script src="https://kit.fontawesome.com/3aca1396eb.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="admin.css"></head>
<body>
   <div class="admin-layout">
        <aside class="sidebar">
            <div class="logo">
                <i class="fas fa-chess-queen"></i>
                <span>Nawali</span>
            </div>
            <ul>
                <li><i class="fa-solid fa-chart-pie"></i><a href="dashboard.php">statistics</a></li>
                <li><i class="fa-solid fa-pen-to-square"></i><a href="managePlatforms.php">manage platforms</a></li>
                <li><i class="fa-solid fa-pen-to-square"></i>manage categories</li>
                <li><i class="fa-solid fa-comments"></i>review feedback</li>
                <li><i class="fa-solid fa-plus"></i>add admin</li>
                <li><i class="fa-solid fa-eye"></i><a href="../index.php" target="_blank">show the site</a> </li>
                <li><i class="fa-solid fa-user-tie"></i>profile</li>
            </ul>
        </aside>
        <main class="main statistics">
            <div class="item">
                <h3>the number of users:</h3>
                <?php
                include '../connectDB.php';
                $sql = "SELECT COUNT(*) AS user_count FROM users";
                $result=  $con->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<p> " . $row['user_count'] . " </p>";
                } else {
                    echo "0 ";
                }
                ?>
            </div> 
            <div class="item">
                <h3>the number of platforms:</h3>
                <?php
                $sql = "SELECT COUNT(*) AS platform_count FROM platforms";
                $result=  $con->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<p> " . $row['platform_count'] . " </p>";
                } else {
                    echo "0 ";
                }
                ?>
            </div>
            <div class="item">
                <h3>the number of categories:</h3>
                <?php
                $sql = "SELECT COUNT(*) AS category_count FROM categories";
                $result=  $con->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<p> " . $row['category_count'] . " </p>";
                } else {
                    echo "0 ";
                }
                
                ?>
            </div>  
            <div class="item">
                <h3>the number of feedbacks:</h3>
                <?php
                $sql = "SELECT COUNT(*) AS feedback_count FROM feedbacks";
                $result=  $con->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<p> " . $row['feedback_count'] . " </p>";
                } else {
                    echo "0 ";
                }
                $con->close();
                ?>
            </div>    
        </main>
   </div>
    
</body>
</html>