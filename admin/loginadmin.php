<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in to NAWALI</title>
    <script src="https://kit.fontawesome.com/3aca1396eb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../index.css">
</head>
<body class="log-page">
    <header>
        <div class="logo">
                <i class="fas fa-chess-queen"></i>
                <span>Nawali</span>
        </div>
    </header>
    <main>
        <div class="divs log-form">
            <h2 class="logh">Admin Log in </h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="log-formi">
                <label class="labels" for="adminName">Username:</label>
                <input class="inputs" type="text" id="adminName" name="adminName" required placeholder="Enter your name" class="validate-username" pattern="[A-Za-z0-9_@#&-]+"><br><br>
                <label class="labels" for="password">Password:</label>
                <input class="inputs" type="password" id="password" name="password" required placeholder="Enter your password" class="validate-username"><br><br>
                <button type="submit" class="log-btn">Log in</button>
                <?php 
                    session_start();
                    include '../connectDB.php';
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if(isset($_POST['adminName']) && isset($_POST['password'])){
                            $adminName = test_input($_POST['adminName']);
                            $password = test_input($_POST['password']);
                            $stmr = $con->prepare("SELECT * FROM admin WHERE userNameA = ? ");
                            $stmr->bind_param("s", $adminName);
                            $stmr->execute();
                            $result = $stmr->get_result();
                            if ($result->num_rows == 1) {
                                $row = mysqli_fetch_assoc($result);
                                if (password_verify($password, $row['passwordA'])) {
                                    $_SESSION['admin_name'] = $adminName;
                                    $_SESSION['admin_id'] = $row['idA'];
                                    header("Location: dashboard.php");
                                    exit();
                                } else {
                                    $_SESSION['login_error'] = "Invalid password.";
                                }
                            } else {
                                $_SESSION['login_error'] = "No admin found with that username.";
                            }
                            header("Location: loginadmin.php");
                            exit();
                        }
                    }
                    mysqli_close($con); 
                    function test_input($data) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                        }
                    ?>
                    <br>
                    <span class="error">
                    <?php
                        if (isset($_SESSION['login_error'])) {
                        echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']); // Clear after showing
                    } ?>
                </span>
            </form> 
        </div> 
    </main> 
    <footer>
            <div class="footer-info">
            <p>&copy; 2025 Nawali. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>