<?php
require_once 'config.php';
require_once 'auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    parse_str(file_get_contents('php://input'), $data);

    if (isset($data['task_id']) && isset($data['new_index'])) {
        $task_id = $data['task_id'];
        $new_index = $data['new_index'];
        $user_id = $_SESSION['user_id'];

        // Get current positions of all tasks
        $stmt = $conn->prepare("SELECT id, position FROM tasks WHERE user_id = ? ORDER BY position ASC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[$row['id']] = $row['position'];
        }

        // Reorder tasks
        $positions = array_keys($tasks);
        $positions = array_splice($positions, $new_index, 0, $task_id);

        $stmt = $conn->prepare("UPDATE tasks SET position = CASE id " .
            implode(' ', array_map(function ($id, $pos) {
                return "WHEN $id THEN $pos";
            }, array_keys($positions), $positions)) .
            " END WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $stmt->close();
    }
}

$conn->close();
?>
