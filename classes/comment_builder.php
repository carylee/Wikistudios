<?php

class CommentBuilder {
	
	function __construct($body, $user_id=1, $parent_id=NULL){
		$this->body = $body;
		$this->owner_id = $user_id;
		$this->parent_id = $parent_id;
		
		$this->mysql_safe_body = mysql_real_escape_string($body);
		
	}

	function add_to_project($project_id){
		//echo "about to make the mysql query";
		
		$query = "INSERT INTO comments (body, project_id, owner_id, parent_id) 
				  VALUES ('$this->mysql_safe_body', '$project_id', '$this->owner_id', '$this->parent_id')";
				
		mysql_query($query);
		$this->comment_id = mysql_insert_id();
	}

	function add_to_video($video_id){
		//echo "in the add_to_video function <br />";
		$query = "INSERT INTO comments (body, video_id, owner_id, parent_id)
				  VALUES ('$this->mysql_safe_body', '$video_id', '$this->owner_id', '$this->parent_id')";
		
		mysql_query($query);
		$this->comment_id = mysql_insert_id();
	}

}