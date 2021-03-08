<?php
include("helpers.php");
include("sql.php");


//var_dump(((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
//var_dump($_SERVER);



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
	$main = include_template('404.php', ["tasks" => $tasks, "projects" => $projects, 'show_complete_tasks' => $show_complete_tasks]);
	$title = 404;
} else {
	$main = include_template('index.php', ["tasks" => $tasks, "projects" => $projects, 'show_complete_tasks' => $show_complete_tasks]);
}
$menu = include_template('left-menu.php', ["tasks" => $tasks, "projects" => $projects, 'url' => $url]);
print(include_template("layout.php", ['title' => $title, 'main' => $main, 'menu' => $menu]));
