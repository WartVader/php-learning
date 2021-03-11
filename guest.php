<?php

include("helpers.php");
include("sql.php");

$title = "Дела в порядке";

$main = include_template('guest.php');
print(include_template("layout.php", ['title' => $title, 'main' => $main]));