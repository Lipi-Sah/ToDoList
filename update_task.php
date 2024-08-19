<?php
require_once 'config.php';
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['task_id'];
    $title = $_POST['title'];

    $stmt = $conn->prepare("UPDATE tasks SET title = ? WHERE id = ?");
    $stmt->bind_param("si", $title, $task_id);
    $stmt->execute();
    header('Location: dashboard.php');
    exit();
}
?>
