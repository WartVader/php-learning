<?php
session_start();
include("helpers.php");
include("sql.php");

$title = "Вход";

function auth(){
	global $connect;
	$auth = false;
	$sql = "SELECT * FROM users WHERE email = '${_POST['email']}'";

	$result = mysqli_query($connect, $sql);

	$user = mysqli_fetch_assoc($result);
	if($user === null) {
		return false;
	}

	if (password_verify($_POST['password'], $user['password'])) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['date_reg'] = $user['date_reg'];
		$_SESSION['name'] = $user['name'];
	}


	//var_dump($validation);
	return true;
}

$errors = [];
var_dump((empty($_POST['email']) || empty($_POST['password'])));
if($_POST) {
	if((empty($_POST['email']) || empty($_POST['password'])) == false) {
		if (auth() == false) {
			$errors['all'] = 'Почта или пароль были введены не верно, или такого аккаунта не существует';
		}
		else {
			header("Location: index.php");
		}
	}
	else {
		empty($_POST['email']) ? $errors['email'] = 'Вы не ввели почту' : false;
		empty($_POST['password']) ? $errors['password'] = 'Вы не ввели пароль' : false;
	}
}


$main = include_template('auth.php', ['errors' => $errors, 'values' => $_POST]);
$menu = include_template('left-menu.php', ["tasks" => $tasks, "projects" => $projects]);
print(include_template("layout.php", ['title' => $title, 'main' => $main]));