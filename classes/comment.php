<?php

class Comment {
	
	function __construct($comment_id){
		
		$query = "SELECT * FROM comments WHERE comment_id = '$comment_id'";
		$result = mysql_query($query);
		
		$commentdata = mysql_fetch_array($result);
		
		$this->comment_id = $comment_id;
		$this->body = stripslashes($commentdata['body']);
		$this->timestamp = strtotime($commentdata['date']);
		$this->owner_id = $commentdata['owner_id'];
		$this->parent_id = $commentdata['parent_id'];
		$this->project_id = $commentdata['project_id'];
		$this->video_id = $commentdata['video_id'];
		
	}
}