<?php

class Project {
	
	function __construct($project_id, $title=NULL, $owner_id=NULL, $managed=0) {


		if(isset($project_id)) {
			$this->project_id = $project_id;
			$this->title = $this->get_title();
			$this->owner_id = $this->get_owner_id();
		}
		
		else {
			$this->title = $title;
			$this->owner_id = $owner_id;
			$title = mysql_real_escape_string($title);
			$owner_id = mysql_real_escape_string($owner_id);
			$managed = mysql_real_escape_string($managed);
			$query = "INSERT INTO projects (project_name, management_option, owner_id)" .
					"VALUES ('$title', '$managed', '$owner_id')"; 
			mysql_query($query);
			$this->project_id = mysql_insert_id();
		}
		
	}
	
	private function get_title(){
		$result = mysql_query("SELECT project_name FROM projects WHERE project_id = '$this->project_id'");
		$row = mysql_fetch_array($result);
		$title = $row[0];
		$title = stripslashes($title);
		return $title;
	}
	
	private function get_owner_id(){
		$result = mysql_query("SELECT owner_id FROM projects WHERE project_id = '$this->project_id'");
		$row = mysql_fetch_array($result);
		return $row[0];
	}
	
	function add_video($video_id){
		$testresult = mysql_query("SELECT * FROM videos_projects WHERE video_id = '$video_id' AND project_id = '$this->project_id'");
		if (mysql_num_rows($testresult) < 1) {
			$video_id = mysql_real_escape_string($video_id);
			$order = $this->get_last_number(); // Get the current last order number in the project
			$order++; // Increment the order number, this will be the new video's order number
		
			$result = mysql_query("INSERT INTO videos_projects (project_id, video_id, order_in_project) VALUES ('$this->project_id','$video_id','$order')");
		}
	}
	

	public function get_videos(){ // returns an array of all the video objects in project

		$result = mysql_query("SELECT video_id FROM videos_projects WHERE project_id = '$this->project_id' ORDER BY order_in_project ASC");
		$numrows = mysql_num_rows($result);
		
		if ($numrows = 0) 
			$videos = 0;
		else {
			$index = 0;
			while($row = mysql_fetch_array($result)) {
				$videos[$index] = new Video($row['video_id']);
				$index++;
			}
		}
		return $videos;
	}
	
	function get_num_of_videos(){
		$result = mysql_query("SELECT video_id FROM videos_projects WHERE project_id = '$this->project_id'");
		$numvideos = mysql_num_rows($result);
	//	echo $numvideos;
		return $numvideos;
	}
	
	function get_last_number(){ // Currently an alias for get_num_of_videos.
		// Eventually, this will return the last order number in the project rather than the number of videos
		// in the project.  Use this when applicable rather than get_num_of_videos so a change will be easy.
		$numvideos = $this->get_num_of_videos();
		
		return $numvideos;
	}
	
	function promote($video_id){
		$video = new Video($video_id); // Create a video object of the input video_id
		$old_order = $video->get_order_in_project($this->project_id); // Remember the old order number
		$new_order = $old_order - 1; // Figure out the new order number (1 higher = 1 less)
		$result = mysql_query("SELECT video_id FROM videos_projects WHERE project_id = '$this->project_id' AND order_in_project = '$new_order'");
			// do a query to find the video object currently in the position the promoted video will move to
		if (mysql_num_rows($result) != 1) // if there was no vdeo there
			echo "Video cannot be promoted because a higher video cannot be found <br />\n";
		else {	
			$row = mysql_fetch_array($result);
			$higher_video_id = $row['video_id'];
			$higher_video = new Video($higher_video_id);
			$higher_video->demote($this->project_id);
			$video->promote($this->project_id);
		}
		
	}
	
	function demote($video_id) {
		$video = new Video($video_id);
		$old_order = $video->get_order_in_project($this->project_id);
		$new_order = $old_order + 1;
		$result = mysql_query("SELECT video_id FROM videos_projects WHERE project_id = '$this->project_id' AND order_in_project = '$new_order'");
		if (mysql_num_rows($result) != 1) 
			echo "Video cannot be promoted because a lower video cannot be found <br />\n";
		else {	
			$row = mysql_fetch_array($result);
			$lower_video_id = $row['video_id'];
			$lower_video = new Video($lower_video_id);
			
			// echo "Going to promote $lower_video->title and demote $video->title <br />\n"; // (for debugging)
			
			$lower_video->promote($this->project_id);
			$video->demote($this->project_id);
		}

	}
	
	function replace_order($video_array) {
		$order = 1;
		foreach($video_array as $video_id){

			$video = new Video($video_id);
			$video->set_order_in_project($order, $this->project_id);
			
			$order++;	
		}
	}
	
	function embed(){
//		$filename = "/playlists/";
//		$filename .= filename_safe($this->title);
//		$filename .= ".xml";
	
		$embed = "<script type=\"text/javascript\" src=\"/jwplayer/swfobject.js\"></script>

		
		<div id=\"player\">This text will be replaced</div>
		
		<script type=\"text/javascript\">
		var so = new SWFObject('/jwplayer/player.swf','mpl','470','320','9');
		so.addParam('allowscriptaccess','always');
		so.addParam('allowfullscreen','true');
		so.addParam('flashvars','&file=http://wikistudios.caryme.com/playlist.php?p=$this->project_id&playlist=none&repeat=list');
		so.write('player');
		</script>";

		echo $embed;
	}
	
	function write_xml() {
		// Create new seriazlier object
		$ser = new XML_Serializer();
		$ser->setOption("addDecl", true);  // Adds xml declaration
		$ser->setOption("indent", "    "); // Sets xml to indent properly
		$ser->setOption("rootName", "playlist"); // Rootname should always be playlist
		$ser->setOption("mode", "simplexml"); // should make everything track
		$ser->setOption("rootAttributes", array("version" => "1", "xmlns" => "http://xspf.org/ns/0/")); // Tells the playlist format
		
		// Set playlist info
		$p_title = $this->title; // Playlist title
		$safetitle = filename_safe($p_title);
		
		$filename = HTDOCS_PATH . "playlists/$safetitle.xml";
	//	echo $filename;
	//	$p_description = $this->description;  // Should be added at some point
		
		$videos = $this->get_videos(); // Fetch array of video objects
		$index = 0;
		foreach($videos as $video){
			$track[$index] = array(
				"title" => $video->title,
				"annotation" => $video->description,
			//	"location" => "http://wikistudios.caryme.com/YouTube_Multi-Format.php?v=$video->youtube_ID&fmt=18",
				"location" => "http://www.youtube.com/watch?v=" . $video->youtube_ID
				);
			$index++;		
		}
		
		$xml = array(
			"title" => $p_title,
			//"info" => $p_description,
			"trackList" => array("track" => $track) );
		
		// Serialize the data
		$result = $ser->serialize($xml);
		
		// Save the data
		$data = $ser->getSerializedData();
	//	echo $data;
		// This should have some error checking
		
		// Open, write, then close the file
		$handle = fopen($filename, 'w') or die("can't open file");
	//	echo $handle;
		fwrite($handle, $data) or die("Something went wrong in writing the data");
		fclose($handle);
		
	}
	
	function sortables(){
		// echo "<div id ='clip-pane'>\n";
		echo "<ul id=\"clip-list\">\n";
		$videos = $this->get_videos();
		
		if ($videos == 0 )
			echo "This project contains no videos yet.  Try adding one! <br />\n";
			
		else {
			foreach($videos as $video){
				$title = htmlspecialchars($video->title);
				echo "\t<li id=\"clip_$video->video_id\"><div class='clip'>\n";
				echo "\t\t<a href='/video.php?v=$video->video_id'><img alt=\"$title\" class=\"thumbnail\" src=\"$video->smallthumb\"/></a><br />\n";
			    echo "\t\t<span class=\"clip-list-title\">$video->title</span></div>\n";
		  		echo "\t</li>\n";
			}
			echo "</ul>\n";
		}
		// echo "</div>\n";
	}
	
	function js_embed() {
		echo "<div id=\"video-player-container\">\n";
    	echo "\t<div id=\"video-player-place-holder\"></div>\n";
		echo "</div>\n";
	}
	
	function get_comments(){
		$query = "SELECT comment_id FROM comments WHERE project_id='$this->project_id'";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)){
			$comment_id = $row['comment_id'];
			$comments[] = new Comment($comment_id);
		}
		
		return $comments;
	}
	
	private function get_durations_array(){
		$videos = $this->get_videos();
		if($videos == 0)
			$durations[] = 0;
		
		else {
			foreach ($videos as $video)
				$durations[] = $video->duration;
		}
		return $durations;
	}
	
	function get_duration(){
		$durations = $this->get_durations_array();
		$total_duration = 0;
		
		foreach ($durations as $duration)
			$total_duration += $duration;
		
		return $total_duration;
	}
	
	function get_video_durations(){
		$durations = $this->get_durations_array();
		
		$video_durations = implode("," , $durations);
		
		return $video_durations;
	}
}
?>
