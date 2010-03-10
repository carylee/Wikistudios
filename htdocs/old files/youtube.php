<?php
$title = "youtube work";
require_once('../includes/header.php');

if(isset($_GET['youtubeurl'])) {
	$youtubeurl = $_GET['youtubeurl'];
	$video = new Video;
	$video->youtube_id_from_url($youtubeurl);
}
else {
?>
<form method="get" action ="youtube.php" name ="youtubeform" id="youtubeform">
	Youtube URL:<input type="text" name="youtubeurl" id="youtubeurl" /><br />
	<input type="submit" name="youtubesubmit" id="youtubesubmit" value="Submit" />
</form>
<?php
}

?>