<?php
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (login($email, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - To-Do List</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('images/background.webp') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .container {
            text-align: center;
            background: rgba(0, 0, 0, 0.7);
            padding: 40px 60px;
            border-radius: 15px;
            box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 400px;
        }

        h2 {
            color: #ffecb3;
            margin-bottom: 20px;
            font-size: 24px;
            letter-spacing: 2px;
        }

        form input {
            padding: 12px;
            margin: 15px 0;
            width: 100%;
            border: 1px solid #ffcc80;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        form input::placeholder {
            color: #ddd;
        }

        form input:focus {
            outline: none;
            border-color: #ffa726;
        }

        form button {
            padding: 12px 20px;
            background-color: #ffa726;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background 0.3s ease;
        }

        form button:hover {
            background-color: #fb8c00;
        }

        p {
            margin-top: 20px;
        }

        a {
            color: #ffa726;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: #e57373;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
