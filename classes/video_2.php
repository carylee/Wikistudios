<?php

class Video extends Item {
	
	function __construct($video_id, $youtube_id=NULL, $name=NULL, $description=NULL) {

		if(isset($video_id)) {
			$this->video_id = $video_id;
			$this->title = $this->get_title();
			$this->youtube_ID = $this->get_youtubeID();
			$this->description = $this->get_description();
			$this->thumbnail = $this->youtube_thumb();
			$this->source = "YouTube";
		//	$this->project_id = $this->get_project_id();
			
		}
		elseif(is_null($video_id)) {
			// Set properties
			$this->youtube_ID = $youtube_id;
			$this->title = $name;
			$this->description = $description;
			$this->thumbnail = $this->youtube_thumb();
			$this->source = "YouTube";

			// Make everything safe for the database
			$youtube_id = mysql_escape_string($youtube_id);
			$name = mysql_escape_string($name);
			$description = mysql_escape_string($description);
			
			// Add to database

			$query = "INSERT INTO videos (video_name, youtube_id, description) VALUES ('$name', '$youtube_id', '$description')";
			mysql_query($query);

			// Set property - video id
			$this->video_id = mysql_insert_id();
	
		}
	}
	
	// I moved these into class Item, because in the database, everything ID related is a "youtube ID". Oh well.
	// private function set_youtubeID($youtubeID) {
	// 	$youtubeID = mysql_escape_string($youtubeID);
	// 	 
	// 	$query = mysql_query("UPDATE videos SET youtube_id='$youtubeID' WHERE video_id='$this->video_id'");
	// 	$this->youtube_ID = $youtubeID;
	// 	if($query)
	// 		$successful = TRUE;
	// 	else
	// 		$successful = FALSE;
	// 	return $successful;
	// }
	// 
	// 
	// private function get_youtubeID() {
	// //	$video_id = $this->video_id;
	// 	$result = mysql_query("SELECT youtube_id FROM videos WHERE video_id = '$this->video_id'");
	// 	$row = mysql_fetch_array($result);
	// //	$this->youtubeID = $youtubeID;
	// 	return $row[0];
	// }
	
	function embed(){
		$embed_video = "<object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/";
		$embed_video .= $this->youtube_ID;
		$embed_video .= "\"></param><param name=\"allowFullScreen\" value=\"true\">";
		$embed_video .= "</param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/";
		$embed_video .= $this->youtube_ID;
		$embed_video .= "\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"425\" height=\"344\"></embed></object>";
		
		return $embed_video;
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
	
	function youtube_thumb(){
		$url = "http://img.youtube.com/vi/";
		$url .= $this->youtube_ID;
		$url .= "/0.jpg";
		
		return $url;
	}

}

?>