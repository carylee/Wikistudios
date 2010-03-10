<?php

//$skiphtml = TRUE;
require_once('../../includes/header.php');

if(isset($_GET['p']) && isset($_GET['clip'])){
	$project_id = $_GET['p'];
	$videoarray = $_GET['clip'];
	$project = new Project($project_id);
	
	$project->replace_order($videoarray);
	echo "This may have happened successfully.";
}

?>