<?php
$title = "View project";
require_once('../includes/header.php');

/*if(isset($_POST['submit'])){
	echo "in first if statement";
	echo $_POST['submit'];
	$video_id = $_POST['video'];
	echo $video_id;
	$title = $_POST['title'];
	$description = $_POST['description'];
	$video = new Video($video_id);
	if(isset($title))
		$video->set_title($title);
	if(isset($description))
		$video->set_description($description);
}

else {
	$video_id = $_GET['video'];
	$video = new Video($video_id);
}

echo "<h1>$video->title</h1>\n";
echo $video->embed();
echo "<p>$video->description</p>\n";

?>

<form method="post" action ="editvideo.php" name ="form" id="form">
	New Title:<input type="text" name="title" id="title" /><br />
	New Description: <input type="textarea" name="description" id="description" /><br />
	<input type="hidden" name"video" id="video" value="<?php $video_id?>" />
	<input type="submit" name="submit" id="submit" value="Submit" /><br />
</form>*/

$video_id = $_GET['video'];
$video = new Video($video_id);

echo "<h1>$video->title</h1>\n";
echo " <a href='?video=$video_id&edit=title'>Edit</a><br/>\n";
echo $video->embed();
echo "<p>$video->description ";
echo "<a href='?video=$video_id&edit=des'>Edit</a><br/>\n";

if($_GET['edit'] == 'title'){
	echo "<form method=\"post\" action = \"editvideo.php?video=$video_id\" name=\"form\" id=\"form\">\n";
	echo "New Title: <input type = \"text\" name=\"title\" /><br />";
	echo "<input type = \"submit\" name=\"submit\" value = \"Submit\" />\n";
}

if($_GET['edit'] == 'title'){
	echo "<form method=\"post\" action = \"editvideo.php?video=$video_id\" name=\"form\" id=\"form\">\n";
	echo "New Description: <input type = \"text\" name=\"description\" /><br />";
	echo "<input type = \"submit\" name=\"submit\" value = \"Submit\" />\n";
}
