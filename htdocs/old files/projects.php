<?php
$title = "View project";
require_once('../includes/header.php');

$HTML = new HTMLObject;

$title = "Wikistudios Project List";
$stylesheets[] = "/style2.css";

$HTML->htmlheader($title, $stylesheets);

$HTML->topnav();

if(isset($_GET['project'])){
	$project_id = $_GET['project'];
	$project = new Project($project_id);
	
	if(isset($_GET['move'])){
		$move_video_id = $_GET['video'];
		$direction = $_GET['move'];
		if($direction == 'up')
			$project->promote($move_video_id);
		elseif($direction == 'down')
			$project->demote($move_video_id);
	//	header("../projects.php?project=$project->project_id");
	}
	$videos = $project->get_videos();
	
	echo "<h1>$project->title</h1>\n";
	
/*	if(isset($_GET['play'])){
	//	echo "inside if statment <br />";
		$playvideo_id = $_GET['video'];
		$playvideo = new Video($playvideo_id);
		echo "<div id=\"youtube\">\n";
		echo "<h2>$playvideo->title</h2>\n";
		echo $playvideo->embedjw();
		echo "<p>$playvideo->description</p>\n";
		echo "<p><a href='../editvideo.php?video=$playvideo->video_id'>Edit</a></p>\n";
		echo "</div>\n";
	}*/
	
	echo "<div id='youtube'>\n";
	echo $project->embed();
	echo "</div>\n";
	
	//echo $videos[0]->title;
	echo "<table>\n";
	// Loop through the array of objects to display a 
//	$state = 0;
	if($project->get_num_of_videos() < 1 )
		echo "You have no videos yet.";
	else {
		
		echo "\t<tr>\n";
		echo "\t\t<td><b>Video Name</b></td>\n";
		echo "\t\t<td><b>Youtube ID</b></td>\n";
		echo "\t\t<td></td>\n";
		echo "\t\t<td></td>\n";
		echo "\t\t<td><b>Order</b></td>\n\t</tr>\n";	
		$runs = 1;
		foreach($videos as $video) {
			$numvids = $project->get_num_of_videos();
			$order = $video->get_order_in_project($project->project_id);
			
			// Prepare to color rows
			if($runs % 2 == 0)
				$row_id = 'even';
			else
				$row_id = 'odd';
			
			// Create table entries
			echo "\t<tr id='$row_id'>\n"; 
			echo "\t\t<td>$video->title\n";  // Row with video's title
			echo "\t\t<td>$video->youtube_ID</td>\n";  // Row with video's youtube ID

			if($video->get_order_in_project($project->project_id) > 1)  // Only make link available if video isn't first
				echo "\t\t<td><a href='?project=$project_id&move=up&video=$video->video_id'>Move Up</a></td>\n";  // Move up link
			else
				echo "\t\t<td></td>\n";  // else empty table entry
			if($order < $numvids) {  // Only make link avaialble if video isn't last
				echo "\t\t<td><a href='?project=$project_id&move=down&video=$video->video_id'>Move Down</a></td>\n";
			}
			else {
				echo "\t\t<td></td>\n";
			//	$order
			//	echo "HERE I AM: $video->get
			}
			echo "\t\t<td>$order</td>\n";
			//echo "<td>$order2</td>\n";
			echo "\t</tr>\n";
			$runs++;
		}
	}
	echo "</table><br />\n";
	echo "<a href='../addvideo.php?project_id=$project->project_id'>Add video to project</a><br/>";
	echo "<a href='../videos.php?p=$project->project_id'>Add a video from the library</a><br />\n";
	

}
?>
<form id="form1" name="form1" method="get" action="projects.php">
  <p>Projects:
<?php
	$results = mysql_query("SELECT * FROM projects");
	DropdownFromQuery('project', $results, 'none', 'project_id', 'project_name');
?>
</p>
  <p>
    <input type="submit" value="Go to project" />
</p>
</form>

<? require_once('../includes/footer.php'); ?>
