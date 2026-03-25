<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <script src="https://kit.fontawesome.com/3aca1396eb.js" crossorigin="anonymous"></script>
    <script src="adminJS.js"></script>
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
                <li><i class="fa-solid fa-pen-to-square"></i><a href="manageCategories.php">manage categories</a></li>
                <li><i class="fa-solid fa-comments"></i>review feedback</li>
                <li><i class="fa-solid fa-plus"></i>add admin</li>
                <li><i class="fa-solid fa-eye"></i><a href="../index.php" target="_blank">show the site</a> </li>
                <li><i class="fa-solid fa-user-tie"></i>profile</li>
            </ul>
        </aside>
        <main class="main" id="pageContent" >
            <div class="table-header">
                <h1>Categories table:</h1>
                <button id="addCategoryBtn" class="btn-add"><i class="fa-solid fa-plus"></i> Add Category</button>
            </div>
            <?php
                include '../connectDB.php';
                $sql = "SELECT * FROM categories";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    echo "<table class='platforms-table'>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                            </tr>";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>".$row["idC"]."</td>
                                <td>".$row["name"]."
                                    <button class='deletePlatform icon-btn-d icon-btn'
                                        data-id='".htmlspecialchars($row["idC"])."'
                                        data-name='".$row["name"]."'>de
                                        <i class='deleteIcon fa-regular fa-trash-can' ></i>
                                    </button>
                                    <button class='editCategory icon-btn icon-btn-e'
                                            data-id='".$row["idC"]."'
                                            data-name='".$row["name"]."'
                                            data-description='".$row["description"]."'
                                            >n
                                        <i class='ediIcon fa-regular fa-pen-to-square' data-id='".htmlspecialchars($row["idC"])."'></i>
                                    </button>
                                </td>
                                <td> ".$row["description"]."</td>
                            </tr>";
                    }
                echo "</table>";
                } else {
                echo "0 results";
                }

                $con->close();
            ?>
        </main>
        <div id="deletePlatformModal" class="modal" aria-hidden="true" style="display:none;">
            <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="dpTitle">
                <button class="Dmodal-close modal-close" aria-label="Close">&times;</button>
                <h3>are you sure you wanna delete <span id="deletePlatformNameTitle"></span>?</h3>
                <div class="modal-actions">
                    <button class="btn-delete btns"data-type="category">yes</button>
                    <button type="button" class="Dbtn-cancel btn-cancel btns">Cancel</button>
                </div>
                <div id="dpMsg" class="verification-message" style="display:none;margin-top:8px;">
                </div>
            </div>
        </div>  
        <div id="editPlatformModal" class="modal" aria-hidden="true" style="display:none;">
            <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="epTitle">
                <button class="modal-close" aria-label="Close">&times;</button>
                <h3 id="editPlatformTitle"></h3>
                <form id="editPlatformForm">
                <input class="inputs" type="hidden" name="platform_id" id="platformId" value="">

                <label class="labels" for="platformName">Platform Name: </label>
                <input class="inputs" type="text" name="platform_name" id="platformName" value="">

                <label class="labels" for="platformDescription">Platform Description: </label>
                <textarea  class="inputs" name="platform_description" id="platformDescription"></textarea>
   
                <div class="modal-actions">
                    <button type="submit" class="btn-submit btns">Save</button>
                    <button type="button" class="btn-cancel btns">Cancel</button>
                </div>
                </form>
                <div id="epMsg" style="display:none;margin-top:8px;">
                </div>
            </div>
        </div> 
    </div>
</body>
</html>