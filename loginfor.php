<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nawali</title>
        <script src="https://kit.fontawesome.com/3aca1396eb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="index.css">
</head>
<body class="log-page">
    <div class="logo">
            <i class="fas fa-chess-queen"></i>
            <span>Nawali</span>
        </div>
    <div class="divs log-form">
        <h2 id="logh">Log in </h2>
        <form action="loginfor.php" method="post" class="log-formi">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required placeholder="Enter your name" class="validate-username" pattern="[A-Za-z0-9_@#&-]+"><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required placeholder="Enter your password" class="validate-username"><br><br>

            <button type="submit" class="log-btn">Log in</button>
            <?php 
                session_start();
                include 'connectDB.php';
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if(isset($_POST['username']) && isset($_POST['password'])){
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $stmr = $con->prepare("SELECT * FROM users WHERE user_name = ? ");
                        $stmr->bind_param("s", $username);
                        $stmr->execute();
                        $result = $stmr->get_result();
                        if ($result->num_rows == 1) {
                            $row = mysqli_fetch_assoc($result);
                            if (password_verify($password, $row['password'])) {
                                $_SESSION['username'] = $username;
                                header("Location: index.html");
                                exit();
                            } else {
                                $_SESSION['login_error'] = "Invalid password.";
                            }
                        } else {
                            $_SESSION['login_error'] = "No user found with that username.";
                        }
                        header("Location: loginfor.php");
                         exit();
                    }
                }
                mysqli_close($con); 
                ?>
                <br>
                <span id='errorc' style='color:red;text-align:center;'>
                <?php
                    if (isset($_SESSION['login_error'])) {
                    echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']); // Clear after showing
                } ?>
            </span>
            
            <br>
            <p>Don't have an account? <br><a href="signupfor.php" class="signLink">Sign up</a></p>
        </form> 
    </div> 
    <footer>
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