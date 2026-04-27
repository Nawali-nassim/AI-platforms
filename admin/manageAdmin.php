<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>
    <script src="https://kit.fontawesome.com/3aca1396eb.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const page = document.getElementById('pageContent');  
            const removeAdminModal = document.getElementById('removeAdminModal');
            const changeRoleModal = document.getElementById('changeRoleModal');
            const changePassModal = document.getElementById('changePassModal');
            const addAdminModal = document.getElementById('addAdminModal');
            let cadminId = null;
            //delete functionality----------------------------------------------------------------------------------------------
                
            function closeModals(modalName) {
                const modal = document.getElementById(modalName);
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                page.removeAttribute('inert');
                cadminId = null;
            }
            function openModals(modalName, id, name) {
                const modal = document.getElementById(modalName);
                if (!modal) return;

                modal.style.display = 'flex';
                modal.setAttribute('aria-hidden', 'false');
                page.setAttribute('inert', '');
                adminId = id;
                const nameSpan = modal.querySelector('span');
                if (nameSpan) {
                    nameSpan.textContent = name;
                }
            }

            document.querySelectorAll('.open-modal').forEach(btn => {
                btn.addEventListener('click', function () {
                    openModals(this.dataset.modal, this.dataset.id, this.dataset.name);
                });
            }); 

            document.querySelectorAll('.btn-cancel').forEach(cancelBtn => {
                cancelBtn.addEventListener('click', function () {
                    const modal = this.closest('.modal');//find the closest parent element with class 'modal'
                    if (modal) {
                        closeModals(modal.id);
                    }
                });
            });

            document.querySelectorAll('.modal-close').forEach(closeBtn => {
                closeBtn.addEventListener('click', function () {
                    const modal = this.closest('.modal');
                    if (modal) {
                        closeModals(modal.id);
                    }
                });
            });
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
                <li><i class="fa-solid fa-plus"></i><a href="manageAdmin.php">add admin</a></li>
                <li><i class="fa-solid fa-eye"></i><a href="../index.php" target="_blank">show the site</a> </li>
                <li><i class="fa-solid fa-user-tie"></i>profile</li>
            </ul>
        </aside>
        <main class="main" id="pageContent" >
            <div class="table-header">
                <h1>Admins table:</h1>
                <button id="addAdminBtn" class="btn-add open-modal" data-modal="addAdminModal"><i class="fa-solid fa-plus"></i> Add Admin</button>
            </div>
            <?php
                include '../connectDB.php';
                $sql = "SELECT * FROM admin";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    echo "<table class='platforms-table'>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>role</th>
                            </tr>";
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row["idA"]."</td>
                                <td>".$row["emailA"]."</td>
                                <td>".$row["userNameA"]."</td>
                                <td>".$row["role"]."</td>
                                    <button class='removeAdmin icon-btn-d icon-btn open-modal'
                                        data-id='".$row["idA"]."'
                                        data-name='".$row["userNameA"]."'
                                        data-modal='removeAdminModal'
                                        >remove admin
                                        <i class='deleteIcon fa-regular fa-trash-can' ></i>
                                    </button>
                                    <button class='changePasswordAdmin icon-btn icon-btn-e open-modal'
                                        data-id='".$row["idA"]."'
                                        data-name='".$row["userNameA"]."'
                                        data-modal='changePassModal'
                                        >change password
                                        <i class='ediIcon fa-regular fa-pen-to-square' ></i>
                                    </button>
                                    <button class='changeRoleAdmin icon-btn icon-btn-e open-modal'
                                        data-id='".$row["idA"]."'
                                        data-name='".$row["userNameA"]."'
                                        data-modal='changeRoleModal'
                                        >change role
                                        <i class='ediIcon fa-regular fa-pen-to-square' ></i>
                                    </button>
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
        <div id="removeAdminModal" class="modal" aria-hidden="true" style="display:none;">
            <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="rmaTitle">
                <button class="Dmodal-close modal-close" aria-label="Close">&times;</button>
                <h3>are you sure you wanna remove <span></span>?</h3>
                <div class="modal-actions">
                    <button class="btn-delete btns">yes</button>
                    <button type="button" class="Dbtn-cancel btn-cancel btns">Cancel</button>
                </div>
                <div id="rmaMsg" class="verification-message" style="display:none;margin-top:8px;">
                </div>
            </div>
        </div>  
        <div id="changeRoleModal" class="modal" aria-hidden="true" style="display:none;">
            <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="epTitle">
                <button class="modal-close" aria-label="Close">&times;</button>
                <h3>Change Role for the admin <span></span></h3>
                <form id="changeRoleForm">
                    <input class="inputs" type="hidden" name="platform_id" id="platformId" value="">

                    <label class="labels" for="adminRole" >New role: </label>
                    <input class="inputs" type="text" name="adminRole" id="adminRole" value="" required>

                    <div class="modal-actions">
                        <button type="submit" class="btn-submit btns">Save</button>
                        <button type="button" class="btn-cancel btns">Cancel</button>
                    </div>
                </form>
                <div id="crMsg" style="display:none;margin-top:8px;">
                </div>
            </div>
        </div> 
        <div id="changePassModal" class="modal" aria-hidden="true" style="display:none;">
            <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="epTitle">
                <button class="modal-close" aria-label="Close">&times;</button>
                <h3 class="logh">Change Password for the admin <span></span></h3>
                <div class="divs "id="profile-form2">
                    <form id="changePassAdmin" class="profile-pass-form" autocomplete="off">
                        <label class="labels" for="current_pass">Current Password:</label>
                        <input class="inputs" type="password" id="current_pass" name="current_pass" placeholder="Enter current password" required>

                        <label class="labels" for="new_pass">New Password:</label>
                        <input class="inputs" type="password" id="new_pass" name="new_pass" placeholder="Enter new password" required>

                        <label class="labels" for="confirm_pass">Confirm New Password:</label>
                        <input class="inputs" type="password" id="confirm_pass" name="confirm_pass" placeholder="Confirm new password" required>
                        
                        <div class="modal-actions">
                            <button type="submit" class="btn-submit log-btn btns">Save</button>
                            <button type="button" class="btn-cancel btns">Cancel</button>
                        </div>
                    </form>
                    <div id="cpMsg" style="display:none;margin-top:8px;">
                    </div>
                </div>  
            </div>
        </div>
        <div id="addAdminModal" class="modal" aria-hidden="true" style="display:none;">
            <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="epTitle">
                <button class="modal-close" aria-label="Close">&times;</button>
                <h3>Add new Admin</h3>
                <form id="addAdminForm" autocomplete="off">
                    <label class="labels" for="adminEmail">Email:</label>
                    <input class="inputs" type="email" id="adminEmail" name="adminEmail" placeholder="Enter admin email" autocomplete="off" required>

                    <label class="labels" for="adminName">Name:</label>
                    <input class="inputs" type="text" id="adminNameInput" name="adminName" placeholder="Enter admin name" autocomplete="off" required>

                    <label class="labels" for="adminPassword">Password:</label>
                    <input class="inputs" type="password" id="adminPassword" name="adminPassword" placeholder="Enter password" autocomplete="new-password" required>

                    <label class="labels" for="confirmPassNewAdmin">Confirm Password:</label>
                    <input class="inputs" type="password" id="confirmPassNewAdmin" name="confirmPass" placeholder="Confirm new password" autocomplete="new-password" required>
                    
                    <div class="modal-actions">
                        <button type="submit" class="btn-submit log-btn btns">Add Admin</button>
                        <button type="button" class="btn-cancel btns">Cancel</button>
                    </div>
                </form>
                <div id="aaMsg" style="display:none;margin-top:8px;">
                </div>
            </div>
        </div>
    </div>
</body>
</html>