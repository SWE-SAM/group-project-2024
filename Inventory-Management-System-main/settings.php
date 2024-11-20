<?php
session_start();

include("includes/db_connection.php");  

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$username = '';
$name = '';
$phone_number = '';
$email = '';
$role = '';
$password = '';

if (!$user_id) {
    header("Location: login.php");
    exit();
}

$stmt = $db->prepare("SELECT * FROM user WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$result = $stmt->execute();

if ($row = $result->fetchArray()) {
    $username = $row['username'];
    $name = $row['name'];
    $phone_number = $row['phone_number'];
    $email = $row['email'];
    $role = $row['role'];
    $password = $row['password'];  
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['username'];
    $new_name = $_POST['name'];
    $new_phone_number = $_POST['phone_number'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    $update_stmt = $db->prepare("UPDATE user SET username = :username, name = :name, phone_number = :phone_number, email = :email, password = :password WHERE user_id = :user_id");
    $update_stmt->bindValue(':username', $new_username, SQLITE3_TEXT);
    $update_stmt->bindValue(':name', $new_name, SQLITE3_TEXT);
    $update_stmt->bindValue(':phone_number', $new_phone_number, SQLITE3_TEXT);
    $update_stmt->bindValue(':email', $new_email, SQLITE3_TEXT);
    $update_stmt->bindValue(':password', $new_password, SQLITE3_TEXT);  
    $update_stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);

    if ($update_stmt->execute()) {
        $success_message = "Your details have been updated successfully!";
    } else {
        $error_message = "There was an error updating your details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <style>

                    /* General styles */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Chewy', cursive;
            }

            /* Body */
            body {
                color: #333;
                line-height: 1.6;
                background-color: #fff;
                display: flex;
                flex-direction: column;
            }

            /* Header */
            header {
                width: 100%;
                display: flex;
                justify-content: space-between;
                padding: 15px 20px;
                background-color: #F4D7E4; /* Light pink background */
                color: #333;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            /* Logo */
            .logo img {
                width: 150px; /* Adjust logo size */
            }

            /* Vertical Navbar */
            .vertical-navbar {
                width: 220px;
                background-color: #fff; 
                height: 100vh;
                position: fixed;
                top: 60px;
                left: 0;
                padding-top: 20px;
            }

            .vertical-navbar ul {
                list-style-type: none;
                padding: 0;
            }

            .vertical-navbar ul li {
                margin: 15px 0;
            }

            /* Default navbar styles */
            .vertical-navbar ul li a {
                display: block;
                padding: 10px;
                color: #000000;
                text-decoration: none;
                font-weight: bold;
                border-radius: 5px;
                transition: all 0.3s ease; 
            }

            
            .vertical-navbar ul li a:hover {
                background-color: #F4D8E4;
                transform: scale(1.1); 
                border-radius: 50px; 
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2); 
            }

            /* Main content */
            main {
                padding: 20px;
                margin-left: 240px;
                margin-top: 80px;
                text-align: center;
                min-height: 100vh;
            }

            /* User Details Box */
            .user-details-box {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #F4D7E4; /* Neutral light background for form */
                border: 1px solid #ddd;
                border-radius: 15px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            /* Form Title */
            .user-details-box h2 {
                color: #333;
                font-size: 1.5em;
                text-align: center;
                border-bottom: 1px solid #ccc;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            /* Input fields */
            .user-details-box input[type="text"],
            .user-details-box input[type="password"],
            .user-details-box input[type="email"] {
                width: 100%;
                padding: 10px;
                margin-top: 5px;
                font-size: 1em;
                border-radius: 8px;
                border: 1px solid #87AAB9; /* Matches navbar color */
                margin-bottom: 15px;
                background-color: #fff;
                color: #333;
            }

            .user-details-box input[type="submit"] {
                background-color: #C5EBC3; /* Pastel green */
                color: #333;
                border: none;
                padding: 12px 25px;
                font-size: 1.1em;
                border-radius: 8px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .user-details-box input[type="submit"]:hover {
                background-color: #a3d3a3; /* Slightly darker green */
            }

            /* Success/Error Messages */
            .message {
                margin-top: 20px;
                text-align: center;
                font-size: 1em;
            }

            .message.success {
                color: #4CAF50; /* Green for success */
            }

            .message.error {
                color: #E57373; /* Red for error */
            }

    </style>
</head>
<body>
    <!-- header -->
    <header>
        <div class="logo">
            <img src="./images/Screenshot 2024-11-05 162943.png" alt="Logo">
        </div>
    </header>
    
    <!-- vertical navbar -->
    <nav class="vertical-navbar">
        <ul>
            <li><a href="dashboard.html"><box-icon name='dashboard' type='solid'></box-icon>Dashboard ></a></li>
            <li><a href="inventory/inventory.php"><box-icon name='table'></box-icon>Inventory ></a></li>
            <li><a href="users.html"><box-icon name='user-circle'></box-icon>User Overview ></a></li>
            <li><a href="settings.php"><box-icon name='cog'></box-icon>Settings ></a></li>
            <li><a href="login.php"><box-icon name='log-out-circle'></box-icon>Logout ></a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main>
        <h1>Settings</h1>
        
        <!-- User details box -->
        <div class="user-details-box">
            <h2>Edit User Login Details</h2>
            <form action="settings.php" method="POST">
                <div class="detail">
                    <strong>Username:</strong>
                    <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                </div>
                <div class="detail">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="detail">
                    <strong>Phone Number:</strong>
                    <input type="text" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required>
                </div>
                <div class="detail">
                    <strong>Email:</strong>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
                <div class="detail">
                    <strong>Password:</strong>
                    <input type="password" name="password" value="<?php echo htmlspecialchars($password); ?>" placeholder="Enter new password">
                </div>
                <input type="submit" value="Update Details">
            </form>
        </div>
        
        <!-- Success or Error Message -->
        <?php if (isset($success_message)) : ?>
            <div style="color: green; text-align: center;">
                <p><?php echo $success_message; ?></p>
            </div>
        <?php elseif (isset($error_message)) : ?>
            <div style="color: red; text-align: center;">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
