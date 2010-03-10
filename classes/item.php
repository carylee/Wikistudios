<?php

class Item {
	
	// function __construct($video_id, $youtube_id=NULL, $name=NULL, $description=NULL) {
	// 
	// 		if(isset($video_id)) {
	// 			$this->video_id = $video_id;
	// 			$this->title = $this->get_title();
	// 			$this->youtube_ID = $this->get_youtubeID();
	// 			$this->description = $this->get_description();
	// 			$this->thumbnail = $this->youtube_thumb();
	// 			$this->source = "YouTube";
	// 		//	$this->project_id = $this->get_project_id();
	// 			
	// 		}
	// 		elseif(is_null($video_id)) {
	// 			// Set properties
	// 			$this->youtube_ID = $youtube_id;
	// 			$this->title = $name;
	// 			$this->description = $description;
	// 			$this->thumbnail = $this->youtube_thumb();
	// 			$this->source = "YouTube";
	// 
	// 			// Make everything safe for the database
	// 			$youtube_id = mysql_escape_string($youtube_id);
	// 			$name = mysql_escape_string($name);
	// 			$description = mysql_escape_string($description);
	// 			
	// 			// Add to database
	// 
	// 			$query = "INSERT INTO videos (video_name, youtube_id, description) VALUES ('$name', '$youtube_id', '$description')";
	// 			mysql_query($query);
	// 
	// 			// Set property - video id
	// 			$this->video_id = mysql_insert_id();
	// 	
	// 		}
	// 	}
	
	function set_description($description){
		$description = mysql_real_escape_string($description);
		$query = mysql_query("UPDATE videos SET description='$description' WHERE video_id ='$this->video_id'");
	//	$this->description = $description;
		if($query)
			$successful = TRUE;
		else
			$successful = FALSE;
		return $successful;
	}
	
	protected function set_youtubeID($youtubeID) {
		$youtubeID = mysql_escape_string($youtubeID);
		 
		$query = mysql_query("UPDATE videos SET youtube_id='$youtubeID' WHERE video_id='$this->video_id'");
		$this->youtube_ID = $youtubeID;
		if($query)
			$successful = TRUE;
		else
			$successful = FALSE;
		return $successful;
	}
	
	
	protected function get_youtubeID() {
	//	$video_id = $this->video_id;
		$result = mysql_query("SELECT youtube_id FROM videos WHERE video_id = '$this->video_id'");
		$row = mysql_fetch_array($result);
	//	$this->youtubeID = $youtubeID;
		return $row[0];
	}
	
	protected function get_description() {
		//$video_id = $this->video_id;
		$result = mysql_query("SELECT description FROM videos WHERE video_id = '$this->video_id'");
		$row = mysql_fetch_array($result);
		$description = $row[0];
		$description = stripslashes($description);
		return $description;
	}
	
	function set_title($title) {
		$title = mysql_real_escape_string($title);
		$query = mysql_query("UPDATE videos SET video_name='$title' WHERE video_id = '$this->video_id'");
	}
	
	function get_title() {
		$result = mysql_query("SELECT video_name FROM videos WHERE video_id = '$this->video_id'");
		$row = mysql_fetch_array($result);
		$title = $row[0];
		return $title;
	}

	function promote($project_id) {
		$order = $this->get_order_in_project($project_id);
		$order--;
		if($order > 0){
			$this->set_order_in_project($order, $project_id);
		}
		else
			echo "Video is already first in project!";
	}
	
	function demote($project_id) { // Increase the order_in_project by one
		$order = $this->get_order_in_project($project_id);
		$order++;
		$this->set_order_in_project($order, $project_id);
	}
	
	function set_order_in_project($order, $project_id) {
		// Pass the string 'last' into this if you want to stick it on the end
		if($order=='last'){
			// Add some stuff here to detect the last one and make this one past it
		}
		
		
		else {
			$order = mysql_real_escape_string($order);
			$query = mysql_query("UPDATE videos_projects SET order_in_project='$order' WHERE video_id = '$this->video_id' AND project_id = '$project_id'");
		}

	}
	
	function get_order_in_project($project_id) {
		$result = mysql_query("SELECT order_in_project FROM videos_projects WHERE video_id = '$this->video_id' AND project_id = '$project_id'");
		$row = mysql_fetch_array($result);
		$order = $row[0];
		return $order;
	}
	
	// private function get_project_id() {
	// 		// Needs to be updated for new data structure
	// 		
	// 		$result = mysql_query("SELECT project_id FROM videos WHERE video_id = '$this->video_id'");
	// 		$row = mysql_fetch_array($result);
	// 		$project_id = $row[0];
	// 		return $project_id;
	// 	}
	
	// function embed(){
	// 	$embed_video = "<object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/";
	// 	$embed_video .= $this->youtube_ID;
	// 	$embed_video .= "\"></param><param name=\"allowFullScreen\" value=\"true\">";
	// 	$embed_video .= "</param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/";
	// 	$embed_video .= $this->youtube_ID;
	// 	$embed_video .= "\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"425\" height=\"344\"></embed></object>";
	// 	
	// 	return $embed_video;
	// }
	
	function thumbnail(){
		$url = "http://img.youtube.com/vi/";
		$url .= $this->youtube_ID;
		$url .= "0.jpg";
		
		return $url;
	}
	
	function xml(){
		$ser = new XML_Serializer();
		$ser->setOption("indent", "    "); // Sets xml to indent properly
		$result = $ser->serialize($this);
		$data = $ser->getSerializedData();
		return $data;
	}
	
	function embedjw(){
		$embed = "<div id=\"flash\">";
		$embed .= "<script type=\"text/javascript\">\n";
		$embed .= "var s1 = new SWFObject('/jwplayer/player.swf','ply','470','320','9','#ffffff')\n";
		$embed .= "s1.addParam('allowfullscreen','true');\n";
		$embed .= "s1.addParam('allowscriptaccess','always');\n";
		$embed .= "s1.addParam('wmode','opaque');\n";
		$embed .= "s1.addParam('flashvars','file=http://www.youtube.com/watch?v=$this->youtube_ID&type=youtube&autostart=true');\n";
		$embed .= "s1.write('flash');\n";
		$embed .= "</script>\n";
		$embed .= "</div>\n";


		return $embed;
	}
	
	function push_tag($name){
		
		// Switching this to work with the Tag Class
		// $tag = strtolower($tag); // Make it all lower case to avoid capitalization issues
		// 	$tag = mysql_real_escape_string($tag); // Make tag SQL safe
		// 	$result = mysql_query("SELECT * FROM tags WHERE tag = '$tag'"); // See if tag exists already
		// 	
		// 	if (mysql_num_rows($result) > 0){ // If tag exists already
		// 		
		// 		$row = mysql_fetch_array($result);
		// 		$tag_id = $row['tag_id']; // Save the tag ID
		// 		
		// 		// Save the query to add the existing tag into table
		// 		$query = "INSERT INTO videos_tags (video_id, tag_id) VALUES ('$this->video_id', '$tag_id')";
		// 		
		// 	}
		// 	
		// 	elseif (mysql_num_rows($result) == 0){
		// 		mysql_query("INSERT INTO tags (tag) VALUES ('$tag')");
		// 		$tag_id = mysql_insert_id();
		// 		$query = "INSERT INTO videos_tags (video_id, tag_id) VALUES ('$this->video_id', '$tag_id')";
		// 		
		// 	}
		// 	
		// 	else
		// 		die("Something went wrong inserting tags");
		// 	
		// 	mysql_query($query); // Go ahead and make the query
		
		$tag = new Tag($name); // Instantiating the tag takes care of everything that previously existed here
		
		$query = "INSERT INTO videos_tags (video_id, tag_id) VALUES ('$this->video_id', '$tag->tag_id')";
		mysql_query($query);
		
	}
	
	// push_tag_list will take string list of tags, separate them, and save all the tags
	// it will take in a list of tags $tags separated by some delimiter $delitmiter
	function push_tag_list($tags, $delimiter) {
		$tags = explode($delimiter, $tags); // Explode the list to make it an array
		
		foreach($tags as $tag){
			$this->push_tag($tag);
		}
		
	}
	
	function youtube_thumb(){
		$url = "http://img.youtube.com/vi/";
		$url .= $this->youtube_ID;
		$url .= "/0.jpg";
		
		return $url;
	}

}

?>