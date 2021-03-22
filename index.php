<?php
session_start();

include("helpers.php");
include("sql.php");

if(!isset($_SESSION['name'])) {
	header("Location: guest.php");
}

// показывать или нет выполненные задачи
$showCompleteTasks = isset($_GET['show_completed']) ? $_GET['show_completed'] : 0;

$title = "Название страницы";

if (isset($_GET['task_id']) && isset($_GET['check'])) {
	$taskId = intval($_GET['task_id']);
	$status = intval($_GET['check']);
	$userId = $_SESSION['user_id'];

	$sql = "UPDATE tasks SET status = $status WHERE id = $taskId AND user_id = $userId";
	$result = mysqli_query($connect, $sql);
	var_dump($sql);
	if ($result === TRUE) {
		header('Location: index.php');
	} else {
		echo "Error: " . mysqli_error($connect);
	}
}
$main = include_template('index.php', ["tasks" => $tasks, "projects" => $projects, 'showCompleteTasks' => $showCompleteTasks]);
$menu = include_template('left-menu.php', ["tasks" => $tasks, "projects" => $projects]);
print(include_template("layout.php", ['title' => $title, 'main' => $main, 'menu' => $menu]));
