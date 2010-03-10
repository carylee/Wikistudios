<?

class Image extends Item {
	function __construct($video_id, $filename=NULL, $name=NULL, $description=NULL) {

		if(isset($video_id)) {
			$this->video_id = $video_id;
			$this->title = $this->get_title();
			$this->filename = $this->get_filename();
			$this->filepath = $this->get_filepath();
			$this->description = $this->get_description();
			//$this->thumbnail = $this->youtube_thumb();
			$this->source = "Upload";
			
		}
		elseif(is_null($video_id)) {
			// Set properties
			$this->filename = $filename;
			$this->filepath = $this->get_filepath();
			$this->title = $name;
			$this->description = $description;
		//	$this->thumbnail = $this->youtube_thumb();
			$this->source = "Upload";

			// Make everything safe for the database
			$filename = mysql_escape_string($filename);
			$name = mysql_escape_string($name);
			$description = mysql_escape_string($description);
			
			// Add to database

			$query = "INSERT INTO videos (video_name, youtube_id, description, type) VALUES ('$name', '$filename', '$description' , '2')";
			mysql_query($query);

			// Set property - video id
			$this->video_id = mysql_insert_id();
	
		}
	}
	
	function set_filename($filename){
		$this->set_youtubeID($filename);
	}
	
	function get_filename(){
		$filename = $this->get_youtubeID;
		return $filename;
	}
	
	function get_filepath(){
		$filename = $this->filename;
		
		$path = USERIMAGES_PATH . $filename;
		
		return $path;

	}
	
}