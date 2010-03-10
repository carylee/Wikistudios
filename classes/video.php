<?php

// Note: most of the set and get methods in this class are not used.
// This was my first endeavor in OOP in PHP and I learned a lot as I went along.
									// 	~Cary

class Video {
	
	function __construct($video_id, $youtube_id=NULL, $name=NULL, $description=NULL) {

		// If the entry already exists, retrieve its members
		if(isset($video_id)) {
			// Setting properties
			
			$query = "SELECT * FROM videos WHERE video_id = '$video_id'";
			$results = mysql_query($query);
			$data = mysql_fetch_array($results);
			$this->video_id = $video_id; // Video ID (video_id)
			$this->title = stripslashes($data['video_name']); // Title (title)
			$this->youtube_ID = $data['youtube_id']; // Youtube ID (youtube_ID)
			$this->description = stripslashes($data['description']); // Description (description)
			$this->duration = $data['duration']; // Duration (duration)
			$this->thumbnail = $this->youtube_thumb(); // Large Thumbnail (youtube_thumb)
			$this->smallthumb = $this->small_youtube_thumb(); // Small Thumbnail (small_youtube_thumb)
			$this->source = "YouTube"; // Source (source)
			
			// Much of this previously called getter functions, but now is down to a single query for optimization.
		}
		
		// If the entry doesn't exist, create it
		elseif(is_null($video_id)) {
			
			$yt = new Zend_Gdata_YouTube();
			
			// Set properties
			$this->youtube_ID = $youtube_id;

			// Instantiate videoEntry object (necessary for some properties)
			$videoEntry = $yt->getVideoEntry($this->youtube_ID);
			
			// Fetch title, description, and duration from youtube
			$title = $videoEntry->getVideoTitle();
			$description = $videoEntry->getVideoDescription();
			$duration = $videoEntry->getVideoDuration();
			@$tagarray = $videoEntry->getVideoTags();
			
			
			// Set properties
			$this->title = $title;
			$this->description = $description;
			$this->duration = $duration;

			// Set other properties
			$this->thumbnail = $this->youtube_thumb();
			$this->smallthumb = $this->small_youtube_thumb();
			$this->source = "YouTube";

			// Make everything safe for the database
			$youtube_id = mysql_escape_string($youtube_id);
			$title = mysql_escape_string($title);
			$description = mysql_escape_string($description);
			
			// Add to database

			$query = "INSERT INTO videos (video_name, youtube_id, description, type, duration) VALUES ('$title', '$youtube_id', '$description', '1', '$duration')";
			mysql_query($query);

			// Set property - video id
			$this->video_id = mysql_insert_id();
			
			// Push Tags
			$this->push_tag_array($tagarray);
	
		}

	}
	
	// Store the Youtube ID in the Database
	// Takes one argument, the Youtube ID as a string
	private function set_youtubeID($youtubeID) {
		$youtubeID = mysql_escape_string($youtubeID);
		$query = mysql_query("UPDATE videos SET youtube_id='$youtubeID' WHERE video_id='$this->video_id'");
		$this->youtube_ID = $youtubeID;
	}

	// Retrieve the Youtube ID from the Database
	private function get_youtubeID() {
		$result = mysql_query("SELECT youtube_id FROM videos WHERE video_id = '$this->video_id'");
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	// Store the duration in the database (Takes a $video_entry object as an argument)
	// Takes a $video_entry object as an argument, requires the Zend GData framework
	private function set_duration($videoEntry){ // Requires a $video_entry object, duration in seconds
		$duration = $videoEntry->getVideoDuration();
		$query = mysql_query("UPDATE videos SET duration='$duration' WHERE video_id='$this->video_id'");
		mysql_query($query);
	}
	
	// Retreive the duration from the database
	private function get_duration(){
		$result = mysql_query("SELECT duration FROM videos WHERE video_id = '$this->video_id'");
		$row = mysql_fetch_array($result);
		return $row[0];
	}

	// Store the description in the database.
	function set_description($description){
		$description = mysql_real_escape_string($description);
		$query = mysql_query("UPDATE videos SET description='$description' WHERE video_id ='$this->video_id'");
	}
	
	private function get_description() {
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
	//	$this->title = $title;
	/*	if($query)
			$successful = TRUE;
		else
			$successful = FALSE;
		return $successful; */
	}
	
	function get_title() {
		$result = mysql_query("SELECT video_name FROM videos WHERE video_id = '$this->video_id'");
		$row = mysql_fetch_array($result);
		$title = $row[0];
		$title = stripslashes($title);
		return $title;
	}

	// Promote - Decrease the order of this video in a project by one
	// Takes a single argument, a project_id number
	function promote($project_id) {
		$order = $this->get_order_in_project($project_id);
		$order--;
		if($order > 0){
			$this->set_order_in_project($order, $project_id);
		//	$this->order = $order;
		}
		else
			echo "Video is already first in project!";
	}
	
	// Demote - Increase the order of this video in a project by one
	// Takes a single argument, a project_id number
	function demote($project_id) { // Increase the order_in_project by one
		$order = $this->get_order_in_project($project_id);
		$order++;
		$this->set_order_in_project($order, $project_id);
	//	$this->order = $order;
	}
	
	// Set the order of this video in a project to something new
	// Takes two arguments, the order and a project ID
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
	
	// Retrieve the order of this video in some project
	// Takes one argument - the project ID
	function get_order_in_project($project_id) {
	//	$video_id = $this->video_id;
		$result = mysql_query("SELECT order_in_project FROM videos_projects WHERE video_id = '$this->video_id' AND project_id = '$project_id'");
		$row = mysql_fetch_array($result);
		$order = $row[0];
		return $order;
	}
	
	// Deprecated after changing some structure.
	private function get_project_id() {
		// Needs to be updated for new data structure
		
		$result = mysql_query("SELECT project_id FROM videos WHERE video_id = '$this->video_id'");
		$row = mysql_fetch_array($result);
		$project_id = $row[0];
		return $project_id;
	}
	
	// Now an alias for embedjw. Previously these were two different methods.
	function embed(){
		echo $this->embedjw();
	}
	
	// Returns the large youtube thumbnail of a video
	function thumbnail(){
		$url = "http://img.youtube.com/vi/";
		$url .= $this->youtube_ID;
		$url .= "0.jpg";
		
		return $url;
	}
	
	// Returns the object data serialized as xml
	function xml(){
		$ser = new XML_Serializer();
		$ser->setOption("indent", "    "); // Sets xml to indent properly
		$result = $ser->serialize($this);
		$data = $ser->getSerializedData();
		return $data;
	}
	
	// Returns the embed code using the jw player
	function embedjw(){
		$embed = "<div id=\"flash\">";
		$embed .= "<script type=\"text/javascript\">\n";
		$embed .= "var s1 = new SWFObject('/jwplayer/player.swf','ply','790','368','9','#ffffff')\n";
		$embed .= "s1.addParam('allowfullscreen','true');\n";
		$embed .= "s1.addParam('allowscriptaccess','always');\n";
		$embed .= "s1.addParam('wmode','opaque');\n";
		$embed .= "s1.addParam('flashvars','file=http://www.youtube.com/watch?v=$this->youtube_ID&type=youtube&autostart=true&skin=/jwplayer/modieus.swf');\n";
		$embed .= "s1.write('flash');\n";
		$embed .= "</script>\n";
		$embed .= "</div>\n";

		return $embed;
	}
	
	// Unfinished.  Supposed to delete a video from the database.
	function delete(){
		$query = "DELETE FROM videos,  WHERE video_id='$this->video_id'";
		
	}
	
	// Check to see if a tag is applied to this video
	function check_tag($tag_id){ // pass in a tag_id
		$query = "SELECT * FROM videos_tags WHERE tag_id='$tag_id' AND video_id = '$this->video_id';";
			// echo "$query <br />\n";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		
	
		
		// echo "$this->title has tag something in the db $num times. <br />";
		
		if( $num == 0 )
			$exists = FALSE;
		else
			$exists = TRUE;
		
		// echo "exists is $exists<br />\n";
		return $exists;
		
	}
	
	function push_tag($name){
		
		$tag = new Tag($name); // Instantiating the tag takes care of everything that previously existed here
		
		if($this->check_tag($tag->tag_id) == FALSE){
			$query = "INSERT INTO videos_tags (video_id, tag_id) VALUES ('$this->video_id', '$tag->tag_id')";
			mysql_query($query);
		}
		
		
	}
	
	// push_tag_list will take string list of tags, separate them, and save all the tags
	// it will take in a list of tags $tags separated by some delimiter $delitmiter
	function push_tag_list($tags, $delimiter) {
		$tags = explode($delimiter, $tags); // Explode the list to make it an array
		
		$this->push_tag_array($tags);
		
	}
	
	function push_tag_array($tagarray){
		foreach($tagarray as $tag){
			$this->push_tag($tag);
		}
	}
	
	function youtube_thumb(){
		$url = "http://img.youtube.com/vi/";
		$url .= $this->youtube_ID;
		$url .= "/0.jpg";
		
		return $url;
	}
	
	function small_youtube_thumb(){
		$url = "http://img.youtube.com/vi/";
		$url .= $this->youtube_ID;
		$url .= "/2.jpg";
		
		return $url;
	}
	
	function get_comments(){
		$query = "SELECT comment_id FROM comments WHERE video_id='$this->video_id' ORDER BY comment_id DESC";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)){
			$comment_id = $row['comment_id'];
			$comments[] = new Comment($comment_id);
		}
		
		return $comments;
	}

}

?>