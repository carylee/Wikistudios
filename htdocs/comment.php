<?php

$title = "Add Comment Test Page";

require_once('../includes/header.php');

if(isset($_GET['p'])){
	$project_id = $_GET['p'];
	$id_for_form = $project_id;
	$fieldname = "project_id";
}

if(isset($_GET['v'])){
	$video_id = $_GET['v'];
	$id_for_form = $video_id;
	$fieldname = "video_id";
}

if(isset($_POST['body'])){
	//echo "yay!";
	$body = $_POST['body'];
	$continue = FALSE;
	
	$newcomment = new CommentBuilder($body);
	
	if(isset( $_POST['video_id']) && ($_POST['video_id'] != 0 ) ){
		// echo "in video thingy";
		$video_id = $_POST['video_id'];
		$newcomment->add_to_video($video_id);
		$continue = TRUE;
	}
	elseif(isset($_POST['project_id']) && ($_POST['project_id']!= 0) ){
		$project_id = $_POST['project_id'];
		$newcomment->add_to_project($project_id);
		$continue = TRUE;
	}
	
	if($continue){
		$comment_id = $newcomment->comment_id;
		$comment = new Comment($comment_id);
		echo $comment->body;
	}
	
	if(isset($_POST['from'])) {
		$from = $_POST['from'];
		header("Location: $from");
	}
	
}

if(isset($_GET['c'])) {
	$comment_id = $_GET['c'];
	$comment = new Comment($comment_id);
	echo $comment->body . "<br />";
}

if(isset($video_id) || isset($project_id)){
	?>
<form action = 'comment.php' method=POST name='form'>
	<input type="hidden" name="<?=$fieldname?>" value="<?=$id_for_form?>"/><br />
	Body <input type="textarea" name="body" /><br />
	<input type="submit" value="Submit Comment" />
</form>
<?php
}
else {
?>
<form action = 'comment.php' method=POST name='form'>
	Video ID <input type="text" name="video_id" /><br />
	or Project ID <input type="text" name="project_id" /><br />
	Body <input type="textarea" name="body" /><br />
	<input type="submit" value="Submit Comment" />
</form>
<?php
}
?>