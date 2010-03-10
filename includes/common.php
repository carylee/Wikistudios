<?php
// Save frequently used code for HTML generation here

// Function: Creates a drop-down listbox from a MySQL result
// Parms
//	$name: the name of the <input>
//	$result: the MySQL result object
//	$selected: row to be shown by default ('none')
//	$valuecol: column of $result that is used as the internal value (0)
//	$showcol: column of $result that is used as the value shown in the listbox (1)
function DropdownFromQuery($name, $result, $selected = 'none', $valuecol = 0, $showcol = 1, $autosubmit = false)
{
	$class = 1;
  	mysql_data_seek($result, 0);
  	print "<select id=\"". $name ."\" name=\"" . $name . "\"".($autosubmit ? "onchange='this.form.submit();'" : "").">\n" ;
  	while($row = mysql_fetch_array($result))
	{
		if ($row[$valuecol] == $selected)
		{
	  		print "<option class=\"class" . $class . "\" value=\"" . $row[$valuecol] . "\" selected>" . $row[$showcol] . "</option>\n";
		}
      	else
		{
	  		print "<option class=\"class" . $class . "\" value=\"" . $row[$valuecol] . "\">" . $row[$showcol] . "</option>\n";
		}
		$class++;
    }
  	print "</select>\n";
}

// Function: Creates a drop-down listbox from a MySQL result with a fake top entry
// Parms
//	$name: the name of the <input>
//	$result: the MySQL result object
//	$selected: row to be shown by default ('none')
//	$valuecol: column of $result that is used as the internal value (0)
//	$showcol: column of $result that is used as the value shown in the listbox (1)
//	$fill: the value that will printed to the fake top entry ('')
function DropdownFromQueryWithBlank($name, $result, $selected = 'none', $valuecol = 0, $showcol = 1, $fill = '')
{
  	print "<select id=\"". $name."\" name=\"" . $name . "\">\n";
  	print "<option value=''>" . $fill . "</option>\n";
  	while($row = mysql_fetch_array($result))
    {
		if ($row[$valuecol] == $selected)
		{
	  		print "<option value=\"" . $row[$valuecol] . "\" selected>" . $row[$showcol] . "</option>\n";
		}
      	else
		{
	  		print "<option value=\"" . $row[$valuecol] . "\">" . $row[$showcol] . "</option>\n";
		}	
    }
  	print "</select>\n";
}

function youtube_id_from_url($url) {
	// Code taken from http://snipplr.com/view/5163/strip-youtube-video-id-from-url/
	if(preg_match('/youtube\.com\/(v\/|watch\?v=)([\w\-]+)/', $url, $match))
		$youtubeID = $match[2]; 
	return $youtubeID;
}

function embed($youtubeid){
		$embed_video = "<object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/";
		$embed_video .= $youtubeid;
		$embed_video .= "\"></param><param name=\"allowFullScreen\" value=\"true\">";
		$embed_video .= "</param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/";
		$embed_video .= $youtubeid;
		$embed_video .= "\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"425\" height=\"344\"></embed></object>";
		
		return $embed_video;
}

// Taken from Snipplr http://snipplr.com/view.php?codeview&id=5256
function filename_safe($filename) {
    $temp = $filename;

    // Lower case
    $temp = strtolower($temp);

    // Replace spaces with a '_'
    $temp = str_replace(" ", "_", $temp);

    // Loop through string
    $result = '';
    for ($i=0; $i<strlen($temp); $i++) {
        if (preg_match('([0-9]|[a-z]|_)', $temp[$i])) {
            $result = $result . $temp[$i];
        }    
    }

    // Return filename
    return $result;
}

function youtubehq($videoID) {
	
	$uri     = "http://www.youtube.com/api2_rest?method=youtube.videos.get_video_token&video_id=$videoID";
	$t       = trim(strip_tags(@file_get_contents($uri)));
	$uri     = "http://www.youtube.com/get_video.php?video_id=$videoID&t=$t&fmt=18";
	
	return $uri;
}

function get_all_videos(){
	$query = "SELECT video_id FROM videos ORDER BY video_name ASC";
	$results = mysql_query($query);
	while($row = mysql_fetch_array($results)){
		$videos[] = new Video($row['video_id']);
	}
	
	return $videos;
}

function get_tags(){
	$query = "SELECT tag_id FROM tags ORDER BY tag ASC";
	$results = mysql_query($query);
	
	return $results;
}

function get_videos_by_tag($tag){
	$tag = strtolower($tag);
	$query = "SELECT videos.video_id FROM videos 
				JOIN videos_tags ON videos.video_id = videos_tags.video_id
				JOIN tags ON videos_tags.tag_id = tags.tag_id
				WHERE tags.tag = '$tag'";
	$results = mysql_query($query);
	
	while($row = mysql_fetch_array($results)) {
		$videos[] = new Video($row['video_id']);
	}
	
	return $videos;
}


	
?>