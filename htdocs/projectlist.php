<?php
$title = 'Projects';
$skiphtml = TRUE;
require_once('../includes/header.php');

$HTML = new HTMLObject;

$title = "Wikistudios Project List";
$stylesheets[] = "/styles/styletest.css";
$stylesheets[] = "/styles/temp.css";

$HTML->htmlheader($title, $stylesheets);
$HTML->topnav();
?>

<div id="bodycontent">
	<h1>Projects</h1>

<?php

$results = mysql_query("SELECT project_id FROM projects");

echo "<table>\n";
$runs = 1;
while($row = mysql_fetch_array($results)) {
	if($runs % 2 == 0)
		$row_id = 'even';
	else
		$row_id = 'odd';
	
	$project = new Project($row['project_id']);
	
	//$length = 50; // set acceptable length of the description
	
	//$description = $video->description;
	
	// if (strlen($video->description) > $length) {
	// 	$description = substr($description, 0, $length);
	// 	$description .= "...";
	// }
	
	echo "<tr class='$row_id'>\n";
	echo "<td class='link'><a href='/project.php?p=$project->project_id'>$project->title</a></td>\n"; // Print column with video title and link
	echo "</tr>";
	$runs++;
}

echo "</table>\n";

?>
</div>
<?php
$HTML->footer();
?>