<?php
$title = 'Videos';
$skiphtml = TRUE;
$addvideolink = 'addvideo.php';
require_once('../includes/header.php');

$HTML = new HTMLObject;

$title = "Wikistudios | $title";
$stylesheets[] = "/styles/styletest.css";
$stylesheets[] = "/styles/temp.css";
$scripts[] = "/jwplayer/swfobject.js";

$HTML->htmlheader($title, $stylesheets, $scripts);

$HTML->topnav();
?>

<?php

if(isset($_GET['action'])) {
	$action = $_GET['action'];
	$video_id = $_GET['v'];
	$project_id = $_GET['p'];
	
	$video = new Video($video_id);
	
	if($action == 'play') {
		//echo $video->name;
	
		echo "<h2>" . $video->title . "</h2><br />";
		echo $video->description . "<br />";
		echo $video->embedjw(); 
	}
	
	if($action == 'add') {
		if ($project_id == 'select') {
			$results = mysql_query("SELECT project_id, project_name FROM projects");
			echo "Select a project to add the video to:<br />\n";
			echo "<form id='form' name='form' method='get' action='videos.php'>";
			DropdownFromQuery('p', $results, 'none', 'project_id', 'project_name');
			echo "<input type='hidden' name='v' value='$video_id' />";
			echo "<input type='hidden' name='action' value='add' />";
			echo "<input type='submit' value='Add to project' />";
		}
		
		else {
		//	echo "HERE!!!<br />";
			$project = new Project($project_id);
			$project->add_video($video_id);
			header("Location: ../project.php?p=$project->project_id");
		}
	}

}


if(isset($_GET['p']))
	$project = $_GET['p'];
else
	$project = 'select';
	
if(isset($_GET['tag'])){
	$tag = $_GET['tag'];
	
	$videos = get_videos_by_tag($tag);
}

else {
	$videos = get_all_videos();
}

?>

<div id='bodycontent'>
	<h1>Video Library</h1>
	<form id='tagform' method='get' action='videos.php'>
		Filter by tag:<input type='text' id='tag' name='tag' /><br />
		<input type='submit' value='Filter' /><br />
	</form>


<?php

echo "<table>\n";
$runs = 1;
foreach($videos as $video) {
	if($runs % 2 == 0)
		$row_id = 'even';
	else
		$row_id = 'odd';
		
	$length = 50; // set acceptable length of the description
	
	$description = $video->description;
	
	if (strlen($video->description) > $length) {
		$description = substr($description, 0, $length);
		$description .= "...";
	}
	
	echo "\t<tr class='$row_id'>\n";
	echo "\t\t<td class='link'><a href='/video.php?v=$video->video_id'>$video->title</a></td>\n"; // Print column with video title
	echo "\t\t<td>$description</td>\n"; // Print column with video description
//	echo "\t\t<td class='link'><a href='/video.php?v=$video->video_id'>View</a></td>\n";  // Print link to preview video
	
	echo "\t\t<td class='link'><a href='/videos.php?v=$video->video_id%26action=add%26p=$project'>Use</a></td>\n"; // Print link to add video
	
	echo "\t</tr>\n";
	$runs++;
}

echo "</table>\n";

?>
</div>
<?php
$HTML->footer();
?>