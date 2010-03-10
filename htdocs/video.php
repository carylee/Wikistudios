<?php

$skiphtml = TRUE;

require_once('../includes/header.php');

// Get the project ID from GET and instantiate objects
if(isset($_GET['v'])){
	$video_id = $_GET['v']; // GET the project id
	$video = new Video($video_id); // Instantiate a project object
	$comments = $video->get_comments(); //
	
}

else
	header("location: /videos.php");

$HTML = new HTMLObject;

$title = "Wikistudios | $video->title";
$stylesheets = array("/styles/styletest.css");
//$stylesheets[] = "styles/style3.css";
$scripts[] = "/scripts/swfobject2_1.js";
$scripts[] = "/jwplayer/swfobject.js";

$HTML->htmlheader($title, $stylesheets, $scripts);

?>

<!--header paer start -->
<?php $HTML->topnav(); ?>

<!-- Video Player -->
<div id="videoPart">
	<?= $video->embed() ?>
</div>

<!-- header part end -->

<!--body part start -->

<div id="mainBody">
	<h2><?=$video->title?></h2>

<!-- <h2><a href="#" class="lib" title="Add to Library"> Add to Library</a> </h2> -->
<h2> <a href="http://wikistudios.caryme.com/videos.php?v=<?=$video->video_id?>%26action=add%26p=select" class="pro" title="Add To Project"> Add to Project</a></h2>
<!--left side start -->

<!--left side end -->

<!--right side start -->

<div id="rightPan">

	<h2><a href="#" class="eve" title="current events"> current events</a> </h2>
	<h2> <a href="/addvideo.php" class="work" title="our works"> our works</a></h2>
	<!-- <p>""</p>

		<h3>Tags Here</h3>
		<p>""</p> -->
	<h3>Comments (<a href='/test/comment.php?p=<?=$video->video_id?>'>add?</a>)</h3>
	<form action='/comment.php' method='post' name='commentform'>
		<input type="hidden" name="video_id" value="<?=$video->video_id?>"/><br />
		<input type="hidden" name="from" value='/video.php?v=<?=$video->video_id?>' />
		<label>Comment</label><input type="text" name="body" /><br />
		<input type="submit" value="Submit Comment" />
	</form>

<?php

if(isset($comments)){
	foreach ($comments as $comment){
		echo "<p class=\"hig\">Comment Title</p>\n";
		echo "<p class=\"one\">$comment->body</p>\n";
		echo "<p class=\"more1\"> <a href=\"#\">dead link</a></p>\n";
	}

}
?>

</div>

<!--right side end -->

<br class="blank" />

</div>

<!--body part end -->

<!--footer start -->

<?php $HTML->footer(); ?>
