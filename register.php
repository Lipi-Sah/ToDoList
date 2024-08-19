<?php
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (register($username, $email, $password)) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Registration failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - To-Do List</title>
    <style>
        /* Basic Reset */
        body, h2, input, button, p {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Background for the logo */
        .logo {
            width: 100%;
            height: 150px; /* Adjust height as needed */
            background: url('images/register.gif') no-repeat center center;
            background-size: contain;
            background-color: #fff; /* Optional: background color to fill space */
        }

        /* Styling for the container */
        .container {
            width: 90%;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .registration-form h2 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        .registration-form input[type="text"],
        .registration-form input[type="email"],
        .registration-form input[type="password"] {
            width: calc(100% - 24px);
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .registration-form button {
            width: calc(100% - 24px);
            padding: 12px;
            background-color: #ff5722;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .registration-form button:hover {
            background-color: #e64a19;
            transform: scale(1.05);
        }

        .error {
            color: #e64a19;
            font-size: 14px;
            margin-top: 10px;
        }

        a {
            color: #ff5722;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: #e64a19;
        }

        /* Responsive Styles */
        @media (max-width: 600px) {
            .container {
                width: 100%;
                padding: 10px;
            }

            .registration-form input[type="text"],
            .registration-form input[type="email"],
            .registration-form input[type="password"],
            .registration-form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="logo">
        <!-- The logo div with the background image -->
    </div>
    
    <div class="container">
        <form method="POST" class="registration-form">
            <h2>Register</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
