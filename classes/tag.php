<?php

class Tag {
	
	function __construct($tag=NULL){
		if(isset($tag)) {
			$tag = strtolower($tag); // Make it all lower case to avoid capitalization issues
			$tag = mysql_real_escape_string($tag); // Make tag SQL safe
			$result = mysql_query("SELECT * FROM tags WHERE tag = '$tag'"); // See if tag exists already
			
			if (mysql_num_rows($result) > 0){ // If tag exists already
				
				$row = mysql_fetch_array($result);
				$tag_id = $row['tag_id']; // Save the tag ID
			}
			
			elseif (mysql_num_rows($result) == 0){
				mysql_query("INSERT INTO tags (tag) VALUES ('$tag')");
				$tag_id = mysql_insert_id();
			}
			
			$this->name = stripslashes($tag);
			$this->tag_id = $tag_id;
		}
	}
	
	function get_all(){
		$result = mysql_query("SELECT tag FROM tags ORDER BY tag");
		while ($row = mysql_fetch_array($result)) {
			$tagname = $row['tag'];
			$tag = new Tag($tagname);
			$tags[] = $tag;
		//	echo "Now working on $tag->tag_id, the tag $tag->name<br />";
			
		}
		
		return $tags;
	}
	
	function numvids(){
		$query = "SELECT * FROM videos_tags WHERE tag_id = '$this->tag_id'";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		return $num;
	}
	
	function get_tag_data() {
 		$tagobjs = $this->get_all();

		foreach($tagobjs as $tag)
			$tagarray[$tag->name] = $tag->numvids();
		
    	return $tagarray;
	}

function get_tag_cloud() {
	// Default font sizes
	$min_font_size = 12;
	$max_font_size = 56;

	// Pull in tag data
	$tags = $this->get_tag_data();
	
	$minimum_count = min(array_values($tags));
	$maximum_count = max(array_values($tags));
	$spread = $maximum_count - $minimum_count;

	if($spread == 0) {
	    $spread = 1;
	}

	//Finally we start the HTML building process to display our tags. For this demo the tag simply searches Google using the provided tag.
	$cloud_html = "<div id='tagcloud'>\n";
	$cloud_tags = array(); // create an array to hold tag code
	foreach ($tags as $tag => $count) {
		//echo $count;
		$size = $min_font_size + ($count - $minimum_count) * ($max_font_size - $min_font_size) / $spread;
		$cloud_tags[] = '<a style="font-size: '. floor($size) . 'px' 
			. "\" class=\"tag_cloud\" href=\"http://wikistudios.caryme.com/videos.php?tag=$tag\">" 
			. htmlspecialchars(stripslashes($tag)) . '</a>';
	}
	$cloud_html .= join("\n", $cloud_tags) . "\n" . "</div>";
	return $cloud_html;
	}
	
	
}