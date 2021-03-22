<?php
session_start();

include("helpers.php");
include("sql.php");

$title = "Регистрация";

function validation() {
	global $connect;
	$validation = [];
	$sql = "SELECT * FROM users WHERE email = '${_POST['email']}'";
	$emails = mysqli_query($connect, $sql);

	if (!empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['password'])) {
	    //TODO: ломается валидация емайла
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$validation['email'] = "E-mail введен не корректно";
        } else if ($emails->num_rows !== 0){
			$validation['email'] = "Введенный E-mail уже зарегистрирован";
		}
	} else {
		empty($_POST['email']) ? $validation['email'] = 'Вы не ввели почту' : false;
		empty($_POST['password']) ? $validation['password'] = 'Вы не ввели пароль' : false;
		empty($_POST['name']) ? $validation['name'] = 'Вы не ввели имя' : false;
	}

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
			header('Location: auth.php');
		} else {
			echo "Error:" . mysqli_error($connect);
		}
	}
}

$main = include_template('register.php', ["tasks" => $tasks, "projects" => $projects, "errors" => $errors, "values" => $_POST]);
print(include_template("layout.php", ['title' => $title, 'main' => $main]));
