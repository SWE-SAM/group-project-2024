<?php
session_start();

include("includes/db_connection.php");  

$username = '';
$password = '';
$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($username) || empty($password)) {
        $loginError = "Please enter both username and password.";
    } else {

        $stmt = $db->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $stmt->bindValue(':password', $password, SQLITE3_TEXT);

        $result = $stmt->execute();


        if ($row = $result->fetchArray()) {

            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            if ($_SESSION['role'] == "admin") {
                header("Location: dashboard.html");
                exit();
            } elseif ($_SESSION['role'] == "manager") {
                header("Location: manager_dashboard.html");
                exit();
            } else {
                header("Location: normal_dashboard.html");
                exit();
            }
        } else {
            $loginError = "Invalid login credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login-styles.css">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>
<body>
    <!-- header -->
    <header>
        <div class="logo">
            <img src="images/Screenshot 2024-11-05 162943.png" alt="Logo">
        </div>
    </header>

    <!-- main content -->
    <main>
        <div class="content-wrapper">
            <h1>Login</h1>


            <form method="POST" action="login.php">
                <div class="input-box">
                    <select id="role" name="role">
                        <option value="normal">Normal Login</option>
                        <option value="manager">Manager Login</option>
                        <option value="admin">Admin Login</option>
                    </select>
                </div>


                <div class="input-box">
                    <input type="text" placeholder="Username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                    <box-icon type='solid' name='user'></box-icon>
                </div>
                
                <div class="input-box">
                    <input type="password" placeholder="Password" name="password" required>
                    <box-icon type='solid' name='lock-alt'></box-icon>
                </div>


                <div class="login-wrapper">
                    <button id="loginBtn" class="btn" type="submit">Login</button>
                </div>

                <div class="remember-forgot">
                    <div class="remember-me">
                        <label>
                            <input type="checkbox" id="rememberMe"> Remember me
                        </label>
                    </div>
                    <div class="forgot-password">
                        <a href="#">Forgot Password?</a>
                    </div>
                </div>
            </form>


            <?php if ($loginError) : ?>
                <div class="error-message" style="color: red; text-align: center;">
                    <p><?php echo $loginError; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
