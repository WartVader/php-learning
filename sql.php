<?php
$connect = mysqli_connect('localhost', 'homestead', 'secret', 'doingsdone', 33060);

$sql_projects = "SELECT COUNT(t.id) AS count, p.id, p.name  FROM projects p LEFT JOIN users u ON u.id = p.user_id LEFT JOIN tasks t ON t.proj_id = p.id WHERE p.user_id = 1 GROUP BY p.id";
$sql_tasks = "SELECT t.* FROM tasks t LEFT JOIN users u ON u.id = t.user_id WHERE t.user_id = 1";
if (isset($_GET['proj_id'])) {
	$sql_tasks = $sql_tasks . " AND t.proj_id = " . $_GET['proj_id'];
}
$result_p = mysqli_query($connect, $sql_projects);
$result_t = mysqli_query($connect, $sql_tasks);
$projects = mysqli_fetch_all($result_p, MYSQLI_ASSOC);
$tasks = mysqli_fetch_all($result_t, MYSQLI_ASSOC);
