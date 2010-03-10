<?php
$title = 'Tags';
require_once('../includes/header.php');

$HTML = new HTMLObject;

$title = "Wikistudios Project List";
$stylesheets = array("/styles/styletest.css", "/styles/tagcloud.css");
//$stylesheets = array("/styles/styletest.css");

$HTML->htmlheader($title, $stylesheets);

$HTML->topnav();
?>

<?php
$results = get_tags();

// echo "<ul>";
$gettags = new Tag;

echo "<div id='bodycontent'>\n";
echo "<h1>Tags</h1>\n";
echo $gettags->get_tag_cloud();
echo "</div>\n";

$HTML->footer();
?>
