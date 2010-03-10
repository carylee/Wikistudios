<?php
$title = 'Tag Video';
require_once('../includes/header.php');

?>

<h1>Add Tags to a Video</h1>
<?php
if(isset($_POST['v'])) {
	$video_id = $_POST['v'];
	$video = new Video($video_id);
	$tags = $_POST['tags'];
	$video->push_tag_list($tags, ', ');
}



$query = "SELECT video_id, video_name FROM videos";
$results = mysql_query($query);
?>


<form id='form' name='form' method='post' action='tag_video.php'>
	 
	Select Video: <?php DropdownFromQuery('v', $results, 'none', 'video_id', 'video_name'); ?><br />
	Add Tags (separated by comma): <input type="text" name="tags" id="tags" /><br />
	<input type="submit" name="submit" value="Add Tags" />
	
</form>