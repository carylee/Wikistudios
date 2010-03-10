<?php
header('Content-Type: text/xml');

$skiphtml = TRUE;
require_once('../includes/header.php');


$subset = FALSE;

// Check to see if any GET or POST variables are set

// Selecting by video_id
if(isset($_GET['v']))
	$video_id = $_GET['v'];

elseif(isset($_POST['v']))
	$video_id = $_POST['v'];

if(isset($video_id)){
	$video = new Video($video_id);
	$vid_array[] = $video;
	$subset = TRUE;
}

// Selecting by project ID
if(isset($_GET['p']))
	$project_id = $_GET['p'];

elseif(isset($_POST['p']))
	$project_id = $_POST['p'];
	
if(isset($project_id)){
	$project = new Project($project_id);
	$vid_array = $project->get_videos();
	$subset = TRUE;
}

// Selecting by project
if(isset($_GET['t']))
	$tag = $_GET['t'];

elseif(isset($_POST['t']))
	$tag = $_POST['t'];
	
if(isset($tag)){
	$vid_array = get_videos_by_tag($tag);
	$subset = TRUE;
}

if(!$subset)
	$vid_array = get_all_videos();

echo "<videos>\n";
foreach($vid_array as $video){
	echo $video->xml();
	echo "\n\n";
}
echo "</videos>";
?>