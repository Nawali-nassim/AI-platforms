<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <script src="https://kit.fontawesome.com/3aca1396eb.js" crossorigin="anonymous"></script>
    <script >
        document.addEventListener('DOMContentLoaded', function() {
              const page = document.getElementById('pageContent');  

        const deFeedModal = document.getElementById('deleteFeedbackModal');
    const dfMsg =document.getElementById('dfMsg');
    let cfeedbackId = null;

    function openModalDFeed(id) {
      deFeedModal.style.display = 'flex';
          deFeedModal.setAttribute('aria-hidden', 'false');
          page.setAttribute('inert','');
          cfeedbackId = id;
    }
          
    function closeModalDFeed() {
      deFeedModal.style.display = 'none';
      deFeedModal.setAttribute('aria-hidden', 'true');
      page.removeAttribute('inert');
      cfeedbackId = null;
    }
    document.querySelectorAll('.deleteFeedback').forEach(icon => {
        icon.addEventListener('click', function() {
          openModalDFeed(this.dataset.id)
    })});
    
    
    document.querySelectorAll('.btn-deleteFeed').forEach(dfbtn => {
    dfbtn.addEventListener('click', function() {
        let feedbackId = cfeedbackId;
        //using ajax to send the request to deletePlatform.php:
        fetch('deleteFeedback.php', {//options
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
                //to send data in URL-encoded format eg: id=1&action=add ,can be json too
            },
            body: 'id=' + feedbackId  //the content of the POST request
        })
        .then(response => response.text())//get the response as text from the server
        .then(data => {
            console.log(data);
            if(dfMsg) {
              dfMsg.textContent = data;
              dfMsg.style.display = 'block';
            } else {
              alert(data); // fallback if element doesn't exist
            }
            // close modal after a short delay on success
            setTimeout(() => closeModalD(), 1500);
        });
        console.log('Delete feedback with ID:', feedbackId);
    });
  });
  if(deFeedModal){
    deFeedModal.querySelector('.DFmodal-close').addEventListener('click', closeModalDFeed);
    deFeedModal.querySelector('.DFbtn-cancel').addEventListener('click', closeModalDFeed);
  } 
        });
    </script>
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
                <li><i class="fa-solid fa-comments"></i><a href="manageFeedback.php">review feedback</a></li>
                <li><i class="fa-solid fa-plus"></i>add admin</li>
                <li><i class="fa-solid fa-eye"></i><a href="../index.php" target="_blank">show the site</a> </li>
                <li><i class="fa-solid fa-user-tie"></i>profile</li>
            </ul>
        </aside>
        <main class="main" id="pageContent" >
            <div class="table-header">
                <h1>Feedbacks table:</h1>
            </div>
            <?php
                include '../connectDB.php';
                $sql = "SELECT 
                            feedbacks.idFeed,
                            feedbacks.feedback,
                            platforms.name AS platform_name,
                            feedbacks.dateSended,
                            feedbacks.state
                        FROM feedbacks
                        JOIN platforms ON feedbacks.idPlatform = platforms.idP;";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    echo "<table class='platforms-table'>
                            <tr>
                                <th>ID</th>
                                <th>Feedback</th>
                                <th>Platform name</th>
                                <th>date sended</th>
                                <th>state</th>
                            </tr>";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row["idFeed"]."
                                    <button class='deleteFeedback icon-btn-d icon-btn' 
                                        data-id='".htmlspecialchars($row["idFeed"])."'>b
                                        <i class='deleteIcon fa-regular fa-trash-can' ></i>
                                    </button>
                                </td>
                                <td>".$row["feedback"]."</td>
                                <td> ".$row["platform_name"]."</td>
                                <td>".$row["dateSended"]."</td>
                                <td>".$row["state"]." <br><br>
                                change status to :
                                    <select>
                                        <option>not reviewed</option>
                                        <option>in progress</option>
                                        <option>done</option>
                                    </select>
                                </td>
                            </tr>";
                    }
                echo "</table>";
                } else {
                echo "0 results";
                }

                $con->close();
            ?>
        </main>
        <div id="deleteFeedbackModal" class="modal" aria-hidden="true" style="display:none;">
            <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="dfTitle">
                <button class="DFmodal-close modal-close" aria-label="Close">&times;</button>
                <h3>are you sure you wanna delete this feedback?</h3>
                <div class="modal-actions">
                    <button class="btn-deleteFeed btns">yes</button>
                    <button type="button" class="DFbtn-cancel btn-cancel btns">Cancel</button>
                </div>
                <div id="dfMsg" class="verification-message" style="display:none;margin-top:8px;">
                </div>
            </div>
        </div>   
    </div>
</body>
</html>