<?php

$skiphtml = TRUE;

require_once('../includes/header.php');

// Get the project ID from GET and instantiate objects
if(isset($_GET['p'])){
	$project_id = $_GET['p']; // GET the project id
	$project = new Project($project_id); // Instantiate a project object
	$comments = $project->get_comments(); //
}

else
	header("location: /projectlist.php");

$HTML = new HTMLObject;

$title = "Wikistudios | $project->title";

//$styles[] = "/styles/styletest.css";
$styles = array("/styles/styletest.css", "/scripts/themes/ui.all.css");
$scripts = array("/scripts/jquery-1.3.1.js", "/scripts/jquery-ui-personalized-1.6rc6.js", "/scripts/swfobject2_1.js", "/scripts/jScrollHorizontalPane.min.js", "/scripts/dragdrop.php?p=$project->project_id");

$HTML->htmlheader($title, $styles, $scripts);

?>

<!--header paer start -->

<?php $HTML->topnav(); ?>

<!-- Video Player -->
<div id="videoPart">
	<?php $project->js_embed(); ?>
</div>

<!-- Player Control -->


<!-- Sortable Video Clip Thumbnails -->
<div id="sortclips">
	<?php $project->sortables();?>
</div>

<!-- header part end -->

<!--body part start -->

<div id="mainBody">

<!--left side start -->

<!-- <div id="leftPan">
	<h2>Videos</h2>

	<ul>
		<?php
		// $videos = $project->get_videos();
		// 		foreach($videos as $video)
		// 			echo "<li><a href=\"../videos.php?v=$video->video_id&action=play\">$video->title</a></li>";
		?>
	</ul>
	<h3>project info</h3>

	<ul class="here">
		<li><a href="#">info </a></li>
		<li><a href="#">info</a></li>
	</ul>

	<a class="more" href="#">more info?</a>
	<p></p>
</div> -->

<!--left side end -->

<!--right side start -->
	<div id='buttons'>
		<h2><a href="/videos.php?p=<?=$project->project_id?>" class="fromlib bigbutton" title="Add from Library"> </a> </h2>
		<h2><a href="/addvideo.php?p=<?=$project->project_id?>" class="addnew bigbutton" title="Add new Video"> </a></h2>
	</div>

<div id="rightPan">
	<!-- <p>""</p> -->
	<!-- <h3>Tags Here</h3> -->
	<!-- <p>""</p> -->
	<h3>Comments (<a href='/test/comment.php?p=<?=$project->project_id?>'>add?</a>)</h3>
	<form action='/comment.php' method='post' name='commentform'>
		<input type="hidden" name="project_id" value="<?=$project->project_id?>"/><br />
		<input type="hidden" name="from" value='/project.php?p=<?=$project->project_id?>' />
		<label>Comment</label><input type="text" name="body" /><br />
		<input type="submit" value="Submit Comment" />
	</form>
	<h3>Project Duration: <?php $project->get_duration();?></h3>

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

<?php $HTML->footer(); ?>
