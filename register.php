<?php

include("helpers.php");
include("sql.php");

$title = "Регистрация";

function validation() {
	global $connect;
	$validation = [];
	$sql = "SELECT * FROM users WHERE email = ".$_POST['email'];
	$emails = mysqli_query($connect, $sql);
	if (!empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['password'])) {
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$validation['email'] = "E-mail введен не корректно";
		} else if ($emails){
			$validation['email'] = "Введеенный E-mail уже зарегистрирован";
		}
	} else {
		empty($_POST['email']) ? $validation['email'] = 'Вы не ввели почту' : false;
		empty($_POST['password']) ? $validation['password'] = 'Вы не ввели пароль' : false;
		empty($_POST['name']) ? $validation['name'] = 'Вы не ввели имя' : false;
	}

	var_dump($validation);
	return $validation;
}

$errors = [];
if($_POST) {
	$errors = validation();
	$email = $_POST['email'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$name = $_POST['name'];
	$dateReg = date('Y-m-d H:i:s', strtotime('now'));
	if ($errors == []) {
		$sql = "INSERT INTO users (email, name, password, date_reg)
				VALUES ('$email', '$name', '$password', '$dateReg')";
		$result = mysqli_query($connect, $sql);
		var_dump($result);
		if ($result === TRUE) {
			header('Location: index.php');
		} else {
			echo "Error:" . mysqli_error($connect);
		}
	}
}

$main = include_template('register.php', ["tasks" => $tasks, "projects" => $projects, "errors" => $errors, "values" => $_POST]);
$menu = include_template('left-menu.php', ["tasks" => $tasks, "projects" => $projects, 'url' => $url]);
print(include_template("layout.php", ['title' => $title, 'main' => $main, 'menu' => $menu]));