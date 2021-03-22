<?php
session_start();

include("helpers.php");
include("sql.php");

if (!isset($_SESSION['name'])) {
	header("Location: guest.php");
}

function validation()
{
	global $projects;
	var_dump($projects);
	$validation = true;

	$validateName = true;
	$validateDate = true;
	$validateProject = true;

	empty($_POST["name"]) ? $validation['error']['name'] = 'Поле не заполнено' : null;
	if ($_GET['form'] == 'task') {
		empty($_POST["project"]) ? $validation['error']['project'] = 'Поле не заполнено' : null;
		if(isset( $validation['error'])) {
			return $validation;
		}

		if (!empty($_POST["date"])) {
			$validateDate = (is_date_valid($_POST['date']) && strtotime($_POST['date']) >= strtotime('now'));
		}
		if (!empty($_POST["project"])) {
			$validateProject = isInArray($projects, 'id', $_POST['project']);
		} else {
			$validateProject = false;
		}
	} else if ($_GET['form'] == 'project') {
		isInArray($projects, 'name', $_POST["name"]) ? $validateName = false : null;
	}

	if (!$validateName) {
		$validation = ['error' => ['name' => "Проект с таким именем уже существует"]];
	}
	if (!$validateDate) {
		$validation = ['error' => ['date' => "Дата введена не правильно"]];
	}
	if (!$validateProject) {
		$validation = ['error' => ['project' => "Выбранного проекта не существует"]];
	}

	return $validation;
}

function includeForm($errors = [])
{
	var_dump($errors);
	global $tasks, $projects, $availableAddForm;

	if (isset($_GET['form'])) {
		$form = in_array($_GET['form'], $availableAddForm) ? 'form-' . $_GET['form'] : '404';
		$form = $form . '.php';

		if ($_GET['form'] == 'task') {
			$title = "Добавление задачи";
		} else if ($_GET['form'] == 'project') {
			$title = "Добавление проекта";
		}
	} else {
		$form = '404.php';
		$title = 'Упс';
	}

	$main = include_template($form, ["tasks" => $tasks, "projects" => $projects, "errors" => $errors, "values" => $_POST]);
	$menu = include_template('left-menu.php', ["tasks" => $tasks, "projects" => $projects]);
	print(include_template("layout.php", ['title' => $title, 'main' => $main, 'menu' => $menu]));
	exit();
}


$errors = [];
$availableAddForm = ['task', 'project'];

if ($_POST) {
	$validation = validation();

	if (!isset($validation['error']) && in_array($_GET['form'], $availableAddForm)) {
		$name = mysqli_real_escape_string($connect, $_POST['name']);
		$userId = $_SESSION['user_id'];
		if($_GET['form'] == 'task') {
			$projId = mysqli_real_escape_string($connect, $_POST['project']) ;
			$date = !empty($_POST['date']) ? $_POST['date'] : date("Y-m-d H:i:s", strtotime('now + 7 days'));
			$file = !empty($_POST['file']) ? "'" . $_POST['file'] . "'" : 'NULL';
			var_dump($_POST);
			var_dump($_FILES);
		}

		if ($_GET['form'] == 'project') {
			$sql = "INSERT INTO projects (name, user_id) VALUES ('$name', $userId)";
		} else if ($_GET['form'] == 'task') {
			$sql = "INSERT INTO tasks (user_id, name, proj_id, deadline, file, date_create, status) VALUES ($userId, '$name', $projId, '$date', $file, '" . date("Y-m-d H:i:s", strtotime('now')) . "', 0)";
		}

		$result = mysqli_query($connect, $sql);
		var_dump($sql);
		if ($result === TRUE) {
			header('Location: index.php');
		} else {
			echo "Error: " . mysqli_error($connect);
		}
	} else {
		$errors = $validation['error'];
	}
}
includeForm($errors);