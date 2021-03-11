<?php
session_start();

include("helpers.php");
include("sql.php");

$title = "Добавление задачи";

$errors = isset($errors) ? $errors : [];
$values = isset($values) ? $values : [];

$main = include_template('form-task.php', ["tasks" => $tasks, "projects" => $projects, "errors" => $errors, "values" => $values]);
$menu = include_template('left-menu.php', ["tasks" => $tasks, "projects" => $projects, 'url' => $url]);
print(include_template("layout.php", ['title' => $title, 'main' => $main, 'menu' => $menu]));
