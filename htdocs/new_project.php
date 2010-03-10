<?php
$title = "Create New Project";
require_once('../includes/header.php');

$HTML = new HTMLObject;
$stylesheets = array("/styles/styletest.css", "/styles/shortpage.css");
$HTML->htmlheader($title, $stylesheets);

if(isset($_POST['title'])) {
	$title = $_POST['title'];
	$user_id = $_POST['user_id'];
	$project = new Project(NULL, $title, $user_id);
	header("Location: /project.php?p=$project->project_id");
	}
$HTML->topnav();
?>
<div id='bodycontent'>	
	<h1>Create a New Project</h1>
<form method="post" action ="new_project.php" name ="createproject" id="createproject">
	<label>Project Title:</label><input type="text" name="title" id="title" /><br />
	<input type="hidden" name="user_id" id="user_id" value="1"/><br />
	<input type="submit" class="button" name="submit" id="submit" value="Submit" /><br />
</form>
</div>
<?php
$HTML->footer();
?>
