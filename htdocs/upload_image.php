<?php
$title = "Add Image";
require_once('../includes/header.php');

if(isset($_GET['project_id']))
	$project_id = $_GET['project_id'];
else
	$project_id = NULL;

if(isset($_POST['imagename'])) {

	$filename = $_FILES['userfile']['name'];
	$newfilename = filename_safe($filename);
	$name = $_POST['image_name'];
	$project_id = $_POST['project_id'];
	$description = $_POST['description'];
	
	// Move the file over to the user_images folder
	$newpath = USERIMAGE_PATH . $newfilename;
	
	// In case a file with the same name exists
	if(file_exists($newpath)){
		$number = 1;
		$testpath = $newpath;
		while(file_exists($testpath)){
			$testpath = $newpath . "_" . $number;
		
			$number++;
		}
		$newpath = $testpath;
	}
	
	move_uploaded_file($filename, $newpath);
	
	// Create a new video object
	$image = new Image(NULL, $filename, $name, $description);
//	echo $video->gettitle;
	
	// If a project id was passed into the page, add this video to that project
	if(isset($project_id)){
		
		$project = new Project($project_id);  // Instantiate a project object
		$project->add_video($video->video_id);
		
	}
	 
	
	
	
	/*$embed_video = "<object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/";
	$embed_video .= $video->youtube_ID;
	$embed_video .= "&hl=en&fs=1\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/";
	$embed_video .= $video->youtube_ID;
	$embed_video .= "&hl=en&fs=1\" tdpe=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"425\" height=\"344\"></embed></object>";
	echo $embed_video;*/
	echo $video->embed();

}
// 
// <!-- The data encoding type, enctype, MUST be specified as below -->
// <form enctype="multipart/form-data" action="__URL__" method="POST">
//     <!-- MAX_FILE_SIZE must precede the file input field -->
//     <input type="hidden" name="MAX_FILE_SIZE" value="150000" />
//     <!-- Name of input element determines name in $_FILES array -->
//     Send this file: <input name="userfile" type="file" />
//     <input type="submit" value="Send File" />
// </form>
?>

<form method="post" enctype="multipart/form-data" action ="upload_image.php" name ="imageform" id="imageform">
    <input type="hidden" name="MAX_FILE_SIZE" value="150000" />
	Choose Image: <input type="file" name="userfile" /><br />
	Name: <input type="text" name="image_name" /><br />
	Description: <input type="textarea" name="description" id="description" /><br />
	<input type="hidden" name="project_id" id="project_id" value="<?=$project_id?>" />
	<input type="submit" name="youtubesubmit" id="youtubesubmit" value="Submit" /><br />
</form>
<a href="../projects.php?project=<?=$project_id?>">Back to current project</a>