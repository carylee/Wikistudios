<?php
header('Content-Type: text/xml');

$skiphtml = TRUE;
require_once('../includes/header.php');

if(isset($_GET['p'])){
	$project_id = $_GET['p'];
	$project = new Project($project_id);
	$videos = $project->get_videos();

	?>
	<playlist version="1" xmlns="http://xspf.org/ns/0/">
	    <title><?= $project->title ?></title>
	    <trackList>
	<?php

	foreach ($videos as $video ){
		$duration = $video->duration;
	?>
	        <track>
	            <title><?=$video->title?></title>
	            <annotation><?=$video->description?></annotation>
	            <location>http://www.youtube.com/watch?v=<?=$video->youtube_ID?></location>
				<image><?=$video->thumbnail?></image>
				<meta rel="duration"><?=$duration?></meta>
	        </track>

	<?php

	}
	?>
	    </trackList>
	</playlist>

	<?php
}
?>