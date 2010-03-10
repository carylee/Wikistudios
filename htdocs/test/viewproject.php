<?php
$skiphtml = TRUE;
require_once('../../includes/header.php');

if(isset($_GET['p'])){
	$project_id = $_GET['p'];
	$project = new Project($project_id);
}

$HTML = new HTMLObject;

$title = "Wikistudios | $project->title";
$stylesheets[] = "wikistudios.css";
$scripts[] = "jquery-1.3.1.js";
$scripts[] = "jquery-ui-personalized-1.6rc6.js";
$scripts[] = "swfobject2_1.js";
$scripts[] = "dragdrop.php?p=$project->project_id";

$HTML->htmlheader($title, $stylesheets, $scripts);

?>

<div id="header">
	<h1>Wikistudios – <?=$project->title?></h1>
	<ul id="navbar">
		<li><a href="/index.php">Home</a></li>
		<li><a href="/videos.php">Videos</a></li>
		<li><a href="/projectlist.php">Projects</a></li>
		<li><a href="/new_project.php">New Project</a></li>
		<li><a href="/addvideo.php?p=<?=$project->project_id?>">Add Video to Project</a></li>
		<li <a href="/videos.php?p=<?=$project->project_id?>">Add Video from Library</a></li>
	</ul>
</div>

<div id="video-player-container">
    <div id="video-player-place-holder"></div>
</div>

<!-- This is where the clip list begins. The img sources and title are inserted by PHP -->
<br>
<ul id="clip-list" "ui-sortable">
<?php
if(isset($project)){
	$videos = $project->get_videos();
	
	foreach($videos as $video){
		echo "\t<li id=\"clip_$video->video_id\">\n";
		echo "\t\t<img alt=\"$video->title\" class=\"thumbnail\" src=\"$video->smallthumb\"/><br />\n";
	    echo "\t\t<span class=\"clip-list-title\">$video->title</span>\n";
  		echo "\t</li>\n";
	}
}
?>

</ul>
<!-- End of clip list -->


</body>


</html>
