<?php
require_once 'config.php';
require_once 'auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_task'])) {
    $title = $_POST['title'];
    $user_id = $_SESSION['user_id'];

    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $title);
        $stmt->execute();
        $stmt->close();
    }
}

if (isset($_GET['complete'])) {
    $task_id = $_GET['complete'];
    $stmt = $conn->prepare("UPDATE tasks SET completed = 1 WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_GET['edit'])) {
    $task_id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT title FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id ORDER BY position ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - To-Do List</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: url('images/todo.webp') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        h2 {
            margin-top: 0;
            font-size: 2.5rem;
            color: #333;
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 3px solid #ff5722;
            animation: slideIn 0.5s ease-out;
        }

        .task-form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease-out;
        }

        .task-form input[type="text"] {
            flex: 1;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            margin-right: 10px;
            transition: border-color 0.3s ease;
        }

        .task-form input[type="text"]:focus {
            border-color: #ff5722;
            outline: none;
        }

        .task-form button {
            padding: 12px 20px;
            background-color: #ff5722;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .task-form button:hover {
            background-color: #e64a19;
            transform: scale(1.05);
        }

        .task-list {
            margin-top: 20px;
            animation: fadeIn 0.5s ease-out;
        }

        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-radius: 8px;
            background: #ffffff;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .task-item:hover {
            background: #f5f5f5;
            transform: translateY(-2px);
        }

        .task-item.completed {
            text-decoration: line-through;
            color: #999;
        }

        .task-item span {
            font-size: 16px;
        }

        .task-item div a {
            color: #ff5722;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
            font-size: 14px;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .task-item div a:hover {
            color: #e64a19;
            transform: scale(1.1);
        }

        .task-item div button {
            background: none;
            border: none;
            color: #ff5722;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .task-item div button:hover {
            color: #e64a19;
            transform: scale(1.1);
        }

        .edit-form {
            margin-top: 20px;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-out;
        }

        .edit-form h3 {
            margin-top: 0;
            font-size: 1.5rem;
            color: #333;
            border-bottom: 2px solid #ff5722;
            padding-bottom: 10px;
        }

        .edit-form input[type="text"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            width: calc(100% - 120px);
            margin-right: 10px;
            transition: border-color 0.3s ease;
        }

        .edit-form input[type="text"]:focus {
            border-color: #ff5722;
            outline: none;
        }

        .edit-form button {
            padding: 12px 20px;
            background-color: #ff5722;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .edit-form button:hover {
            background-color: #e64a19;
            transform: scale(1.05);
        }

        .logout-link {
            display: block;
            text-align: center;
            margin-top: 30px;
            font-size: 16px;
        }

        .logout-link a {
            color: #ff5722;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .logout-link a:hover {
            color: #e64a19;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .task-form input[type="text"] {
                width: calc(100% - 80px);
            }

            .task-form button {
                width: 100%;
            }

            .task-item {
                font-size: 14px;
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <form class="task-form" method="POST">
            <input type="text" name="title" placeholder="New Task" required>
            <button type="submit" name="add_task">Add Task</button>
        </form>

        <?php if (isset($task_id) && isset($task)): ?>
            <div class="edit-form">
                <h3>Edit Task</h3>
                <form method="POST" action="update_task.php">
                    <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
                    <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
                    <button type="submit">Update Task</button>
                </form>
            </div>
        <?php endif; ?>

        <div class="task-list">
            <?php while ($task = $result->fetch_assoc()): ?>
                <div class="task-item <?php echo $task['completed'] ? 'completed' : ''; ?>" data-id="<?php echo $task['id']; ?>">
                    <span><?php echo htmlspecialchars($task['title']); ?></span>
                    <div>
                        <?php if (!$task['completed']): ?>
                            <a href="?edit=<?php echo $task['id']; ?>">Edit</a>
                            <a href="?complete=<?php echo $task['id']; ?>">Complete</a>
                        <?php endif; ?>
                        <a href="?delete=<?php echo $task['id']; ?>">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.querySelector('.task-list');
        Sortable.create(el, {
            onEnd: function(evt) {
                var taskId = evt.item.getAttribute('data-id');
                var newIndex = evt.newIndex;
                fetch('update_task_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        'task_id': taskId,
                        'new_index': newIndex
                    })
                });
            }
        });
    });
    </script>
</body>
</html>

<?php
$conn->close();
?>
