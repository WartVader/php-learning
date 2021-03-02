<?php

function validation($whatToValidate)
{
	global $projects;
	$validation = false;

	if ($whatToValidate === "form-task") {
		$validation['date'] = (preg_match("/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/", $_POST['date']) && strtotime($_POST['date']) >= strtotime('now'));
		$validation['project'] = isInArray($projects, 'id', $_POST['project']);
	}

	return $validation;
}
//
//var_dump($_POST);

$validation = validation("form-task");

//var_dump($validated);