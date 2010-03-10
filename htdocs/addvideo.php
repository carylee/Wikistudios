<?php
$title = "Add Video";
require_once('../includes/header.php');

$HTML = new HTMLObject;

$title = "Wikistudios Project List";
$stylesheets[] = "/styles/styletest.css";
$stylesheets[] = "/styles/shortpage.css";

$HTML->htmlheader($title, $stylesheets);

$HTML->topnav();

if(isset($_GET['project_id']))
	$project_id = $_GET['project_id'];
elseif(isset($_GET['p']))
	$project_id = $_GET['p'];
else
	$project_id = NULL;


if(isset($_POST['youtubeurl'])) {
	$youtubeurl = $_POST['youtubeurl'];
	// $name = $_POST['video_name'];
	$project_id = $_POST['project_id'];
//	$description = $_POST['description'];
	
	// Get youtube ID from the url (this should really be inside a class)
	$youtubeid = youtube_id_from_url($youtubeurl);
	
	// Create a new video object
//	$video = new Video(NULL, $youtubeid, $name, $description); (moved to yt api)
	$video = new Video(NULL, $youtubeid);

	// If a project id was passed into the page, add this video to that project
	if(isset($project_id)){
		
		$project = new Project($project_id);  // Instantiate a project object
		$project->add_video($video->video_id);
		header("location: /project.php?p=$project_id");
		
	}
	 
	
	//header("location: /video.php?v=$video->video_id");
	
	/*$embed_video = "<object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/";
	$embed_video .= $video->youtube_ID;
	$embed_video .= "&hl=en&fs=1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/";
	$embed_video .= $video->youtube_ID;
	$embed_video .= "&hl=en&fs=1\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"425\" height=\"344\"></embed></object>";
	echo $embed_video;*/
	echo $video->embed();
}
?>
<br />
<div id="centerHold">
<form method="post" action ="addvideo.php" name ="youtubeform" id="youtubeform">
	<label>Youtube URL:</label><input type="text" name="youtubeurl" id="youtubeurl" /><br />
	<!-- Name: <input type="text" name="video_name" id="video_name" /><br />
	Description: <input type="textarea" name="description" id="description" /><br /> -->
	<input type="hidden" name="project_id" id="project_id" value="<?=$project_id?>" />
	<input type="submit" class="button" name="youtubesubmit" id="youtubesubmit" value="Submit" /><br />
</form>
<ul id="bottomnav">
<?php
if(isset($project_id))
	echo "\t<li><a href=\"../project.php?p=$project_id\">Back to current project</a></li>\n";
else
	echo "\t<li><a href=\"/videos.php\">Other Videos</a></li>\n";
?>
</ul>

</div>
<br class="blank">
<?php
$HTML->footer();
?>