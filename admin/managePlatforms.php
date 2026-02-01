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
        <main class="main">
            <?php
                include '../connectDB.php';
                $sql = "SELECT * FROM platforms";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    echo "<table class='platforms-table'>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>link</th>
                                <th>id category</th>
                                <th>icon</th>
                            </tr>";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>".$row["idP"]."</td><td>".$row["name"]."<i class='fa-regular fa-trash-can'></i> <i class='fa-regular fa-pen-to-square'></i></td><td> ".$row["description"]."</td><td>".$row["link"]."</td><td>".$row["idCategory"]."</td><td>".$row["icon"]."</td></tr>";
                    }
                echo "</table>";
                } else {
                echo "0 results";
                }

                $con->close();
            ?>      
        </main>
    </div>
</body>
</html>