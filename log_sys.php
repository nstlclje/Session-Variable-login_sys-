<?php

session_start();


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];

        
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            
            $message = "User '" . htmlspecialchars($_SESSION['username']) . "' is already logged in. Wait for them to log out first.";
        } else {
        
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password; 
            $_SESSION['loggedin'] = true;

            
            $hashedPassword = hash('sha256', $password); 
            
            
            $message = "User logged in: " . htmlspecialchars($username) . "<br>Password: " . $hashedPassword; 
        }
    }

    if (isset($_POST['logout'])) {
        
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            session_unset(); 
            session_destroy(); 
            $message = ""; 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }

        label {
            display: inline-block;
            width: 100px;
            font-size: 18px;
        }

        input[type="text"], input[type="password"] {
            width: 200px;
            padding: 8px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            padding: 8px 16px;
            font-size: 16px;
            margin-right: 10px;
        }

        .message {
            margin-top: 20px;
            font-size: 18px;
        }

        .error {
            color: red;
        }
        
        .info {
            color: black; 
        }

        .bold {
            font-weight: bold; 
        }

        .password-label {
            margin-top: 
        }
    </style>
</head>
<body>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Enter your username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Enter your password" required><br><br>

        <input type="submit" name="login" value="Login"><br><br>
        <input type="submit" name="logout" value="Logout"><br><br>
    </form>

    <div class="message">
        <?php
        
        if ($message) {
            echo '<span class="info bold">' . $message . '</span>'; 
        }
        ?>
    </div>
</body>
</html>
