<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #fbc2eb, #a18cd1);
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #555;
            margin-bottom: 30px;
        }

        a {
            text-decoration: none;
            padding: 10px 20px;
            margin: 10px;
            background-color: #6c63ff;
            color: white;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        a:hover {
            background-color: #5548c8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the To-Do List App</h1>
        <a href="register.php">Register</a>
        <a href="login.php">Login</a>
    </div>
</body>
</html>
