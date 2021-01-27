<?php
include("helpers.php");
function countSpecification(array $tasks, string $category){
    $count = 0;
    foreach($tasks as $task){
        if($task['category'] === $category)
            $count++;
    }
    return $count;
}
function isMoreOrЕquivalent24hours(string $date){
    $date = strtotime($date);
    if ($date == 0){
        return true;
    }
    $diff = $date - strtotime('now');
    $diff = floor($diff/(60*60));
    return $diff >= 24;
}
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$projects = array("Входящие", "Учеба", "Работа", "Домашние дела", "Авто");
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
];
$title = "Название страницы";
foreach($tasks as $task){
    $time = strtotime($task['date']);
    $task['date'] = date('Y-m-d', $time);
    var_dump( isMoreOrЕquivalent24hours($task['date']));
} // перезаписываем дату в другом формате
$main = include_template('index.php', ["tasks" => $tasks, "projects" => $projects, 'show_complete_tasks' => $show_complete_tasks]);
$menu = include_template('left-menu.php', ["tasks" => $tasks, "projects" => $projects]);
print(include_template("layout.php", ['title' => $title, 'main' => $main, 'menu' => $menu]));
