<?php

include("index.php");

function validation($data, $whatToValidate)
{
	$validated = false;
	$dateValidate = ["form-project",];
	$projectsValidate = ["form-project",];
	if ($whatToValidate === "date" || in_array($whatToValidate, $dateValidate)) {
		$validated = $validated || (preg_match("^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$", $data) && strtotime($data) >= strtotime('now'));
	}
	if ($whatToValidate === "projects" || in_array($whatToValidate, $projectsValidate)) {
		global $projects;
		$validated = $validated || isInArray($projects, 'id', $data);
	}
	return $validated;
}

var_dump($projects);

if ($_POST['project'] || $_POST['name'] || $_POST['date'] || $_POST['file']) {
	validataion();
}