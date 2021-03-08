<?php
include("helpers.php");
include("sql.php");

$title = "Добавление задачи";


function validation($whatToValidate)
{
	global $projects;
	var_dump($projects);
	$validation = false;

	if ($whatToValidate === "form-task") {
		$vDate = true;
		if (!empty($_POST["date"])) {
			$vDate = (preg_match("/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/", $_POST['date']) && strtotime($_POST['date']) >= strtotime('now'));
		}
		if (!empty($_POST["project"])) {
			$vProject = isInArray($projects, 'id', $_POST['project']);
		} else {
			$vProject = false;
		}

		if (!$vDate) {
			$validation['date'] = $_POST['date'];
		}
		if (!$vProject) {
			$validation['project'] = $_POST['project'];
		}
	}

	return $validation;
}

//
//var_dump($_POST);

$date = !empty($_POST['date']) ? $_POST['date'] : date("Y-m-d H:i:s", strtotime('now + 7 days'));
$proj_id = $_POST['project'];
$name = $_POST['name'];
$file = !empty($_POST['file']) ? "'".$_POST['file']."'" : 'NULL';

var_dump($_POST);
var_dump($_FILES);

$errors = validation("form-task");
//exit();
if ($errors === false) {
	$sql = "INSERT INTO tasks (user_id, name, proj_id, deadline, file, date_create, status) 
	VALUES (1, '$name', $proj_id, '$date', $file, '" . date("Y-m-d H:i:s", strtotime('now')) . "', 0)";

	$result = mysqli_query($connect, $sql);
	var_dump($result);
	if ($result === TRUE) {
		header('Location: index.php');
	} else {
		echo "Error:" . mysqli_error($connect);
	}
}

$main = include_template('form-task.php', ["tasks" => $tasks, "projects" => $projects, "errors" => $errors, "values" => $_POST]);
$menu = include_template('left-menu.php', ["tasks" => $tasks, "projects" => $projects, 'url' => $url]);
print(include_template("layout.php", ['title' => $title, 'main' => $main, 'menu' => $menu]));