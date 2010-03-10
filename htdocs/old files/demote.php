<?php

$skiphtml = TRUE;
require_once('../includes/header.php');

if(isset($_GET['v']))
	$video_id = $_GET['v'];

if(isset($_POST['v']))
	$video_id = $_POST['v'];

if(isset($_GET['p']))
	$project_id = $_GET['p'];

if(isset($_POST['p']))
	$project_id = $_POST['p'];

if(isset($video_id) && isset($project_id)){

	// Instantiate video and project objets
    //	$video = new Video($video_id);
	$project = new Project($project_id);
	
	$project->demote($video_id);
	
	// $successful = TRUE;
}
// 
// else
// 	$successful = FALSE;
