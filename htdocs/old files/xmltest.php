<?php
require('../includes/header.php');
// include class file
require("/home/ucmnuorg/php/XML/Serializer.php");

// create object
$serializer = new XML_Serializer();
$playlist_title = "title of playlist";
$playlist_description = "description of playlist";

$title = "Some Title";
$description = "Some Description";
$location = "localhost";
$youtube_ID = "YOUTUBEID";

$url = "http://www.youtube.com/watch?v=" . $youtube_ID;
$track = array(
		"title" => $title,
//		"creator" => $creator,
		"info" => $description,
		"location" => $url
//		"image" => "sometime.jpg"
		);
		
$tracklist = array("track" => $track);

$xml = array(
		"title" => $playlist_title,
		"info" => $playlist_description,
		"tracklist" => $tracklist
		);

$serializer->setOption("addDecl", true);
// indent elements
$serializer->setOption("indent", "    ");

// set name for root element
$serializer->setOption("rootName", "playlist");

// set attributes for root element
$serializer->setOption("rootAttributes", array("version" => "1", "xlmns" => "http://xspf.org/ns/0/"));
$result = $serializer->serialize($xml);

if($result)
	echo $serializer->getSerializedData();
	
$data = $serializer->getSerializedData();
	
$project = new Project(2);

$serialize2 = new XML_Serializer();
$serialize2->serialize($project);

echo $serialize2->getSerializedData();

$filename = $playlist_title . ".xml";

$handle = fopen($filename, 'w') or die("can't open file");
fwrite($handle, $data);
fclose($handle);



?>