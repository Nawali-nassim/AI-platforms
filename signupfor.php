<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nawali</title>
        <script src="https://kit.fontawesome.com/3aca1396eb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="index.css">
    <script src="mainJS.js" defer></script>
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
            <h2 id="logh">Sign up </h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="log-formi">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required placeholder="Enter your user name"  class="validate-username" pattern="[A-Za-z0-9_@#&-]+"><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password" class="validate-username"><br><br>
                <button type="submit" class="log-btn">Sign up</button>
                <?php
                    session_start();
                    include 'connectDB.php';
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        if(isset($_POST['username']) && isset($_POST['password'])){
                            $username = test_input($_POST['username']);
                            $password = test_input($_POST['password']);
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            // Use prepared statement for SELECT
                            $stmt = $con->prepare("SELECT * FROM users WHERE user_name = ?");
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows == 1) {
                                $_SESSION['signup_error'] =  "Username already taken.";
                            } else {
                                $stmt = $con->prepare("INSERT INTO users (user_name, password) VALUES (?, ?)");
                                $stmt->bind_param("ss", $username, $hashed_password);
                                if ($stmt->execute()) {
                                    $_SESSION['user_name'] = $username;
                                    $_SESSION['user_id'] = $row['idU'];
                                    header("Location: index.php");
                                    exit();
                                } else {
                                    $_SESSION['signup_error'] =  "Error inserting user: " . $stmt->error;
                                }
                            }
                        header("Location: signupfor.php");
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
                <span id='errorc' style='color:red;text-align:center;'>
                    <?php
                        if (isset($_SESSION['signup_error'])) {
                        echo $_SESSION['signup_error'];
                        unset($_SESSION['signup_error']); // Clear after showing
                    } ?>
                </span>
                <br>
                <p>Already have an accaunt? <br><a href="loginfor.php" class="signLink">Log in</a></p>
            </form> 
        </div> 
    </main>
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