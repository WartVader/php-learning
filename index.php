<?php
include("helpers.php");


$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url = explode('?', $url);
$url = $url[0];
$uri = $_SERVER['REQUEST_URI'];

//var_dump(((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
//var_dump($_SERVER);

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

function isInArray($array, $key, $needle)
{
	foreach ($array as $item) {
		if (isset($item[$key])) {
			if ($item[$key] === $needle) {
				return true;
			}
		}
	}
	return false;
}

function isMoreOrЕquivalent24hours($date)
{
	$date = strtotime($date);
	if ($date == 0) {
		return true;
	}
	$diff = $date - strtotime('now');
	$diff = floor($diff / (60 * 60));
	return $diff >= 24;
}

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
/*$projects = array("Входящие", "Учеба", "Работа", "Домашние дела", "Авто");
$tasks = [
    [
        'name' => "Собеседование в IT компании",
        'date' => "01.12.2018",
        'category' => "Работа",
        'is_complete' => false,
    ],
    [
        'name' => "Выполнить тестовое задание",
        'date' => "25.12.2018",
        'category' => "Работа",
        'is_complete' => false,
    ],
    [
        'name' => "Сделать задание первого раздела",
        'date' => "21.12.2018",
        'category' => "Учеба",
        'is_complete' => true,
    ],
    [
        'name' => "Встреча с другом",
        'date' => "22.12.2018",
        'category' => "Входящие",
        'is_complete' => false,
    ],
    [
        'name' => "Купить корм для кота",
        'date' => "26.01.2021",
        'category' => "Домашние дела",
        'is_complete' => false,
    ],
    [
        'name' => "Заказать пиццу",
        'date' => "Нет",
        'category' => "Домашние дела",
        'is_complete' => false,
    ],
];*/
$title = "Название страницы";
$menu = include_template('left-menu.php', ["tasks" => $tasks, "projects" => $projects, 'url' => $url]);
if (count($tasks) == 0) {
	$main = include_template('404.php', ["tassks" => $tasks, "projects" => $projects, 'show_complete_tasks' => $show_complete_tasks]);
	$title = 404;
} else {
	if ($uri == '/') {
		$main = include_template('index.php', ["tasks" => $tasks, "projects" => $projects, 'show_complete_tasks' => $show_complete_tasks]);
	} else if ($uri == '/form-task') {
		$main = include_template('form-task.php', ["tasks" => $tasks, "projects" => $projects, 'show_complete_tasks' => $show_complete_tasks]);
	} else if ($_POST) {
		$array = explode('/', $_SERVER['HTTP_REFERER']);
		$refer = $array[array_key_last($array)];
		var_dump('Location:'.$refer);
		print(include_template("layout.php", ['title' => $title, 'main' => "<br>", 'menu' => $menu]));
		header('Location: '.$_SERVER['HTTP_REFERER']);
		//exit();
		http_redirect($_SERVER['HTTP_REFERER']);
		//http_redirect(((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']);
	} else {
		$main = include_template('404.php', ["tassks" => $tasks, "projects" => $projects, 'show_complete_tasks' => $show_complete_tasks]);
		//$main = include_template('form-task.php', ["tasks" => $tasks, "projects" => $projects, 'show_complete_tasks' => $show_complete_tasks]);
		$title = 404;
	}
}
print(include_template("layout.php", ['title' => $title, 'main' => $main, 'menu' => $menu]));
