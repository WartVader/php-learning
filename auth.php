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
	var_dump($sql);
	var_dump($user);
	if (password_verify($_POST['password'], $user['password'])) {
		$_SESSION['id'] = $user['id'];
		$_SESSION['id'] = $user['date_reg'];
		$_SESSION['name'] = $user['name'];
		var_dump("Типо вошел");
	}


	//var_dump($validation);
	return $auth;
}

$errors = [];
if($_POST) {
	$errors = auth();
	/*$email = $_POST['email'];
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
	}*/
}

$main = include_template('auth.php', ['errors' => $errors]);
$menu = include_template('left-menu.php', ["tasks" => $tasks, "projects" => $projects, 'url' => $url]);
print(include_template("layout.php", ['title' => $title, 'main' => $main]));