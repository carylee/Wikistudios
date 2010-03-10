<?php

class HTMLObject {
	
	function doctype(){
		echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\n";
		echo "\t\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
	}
	
	function headdec(){
		echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
		echo "<head>\n";
		echo "\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>\n";
	}
	
	function title($title){
		echo "\t<title>$title</title>\n";
	}
	
	function addstylesheet($style){
		echo "\t<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"$style\" />\n";
	}
	
	function addscript($script) {
		echo "\t<script type=\"text/javascript\" src=\"$script\"></script>\n";
	}
	
	
	function headtobody() {
		echo "</head>\n\n<body>";
	}
	
	function htmlheader($title, $styles=NULL, $scripts=NULL, $project_id=NULL) {
		$this->doctype();
		$this->headdec();
		$this->title($title);
		
		//$this->addstylesheet("/styles/style.css");
		
		if(isset($styles)){
			foreach($styles as $style)
				$this->addstylesheet($style);
		}
		
		if(isset($scripts)){
			foreach($scripts as $script){
				$this->addscript($script);
			}
		}
		
		/*if(isset($project_id)){
			$this->addscript("/scripts/jquery-1.3.1.js");
			$this->addscript("/scripts/jquery-ui-personalized-1.6rc6.js");
			$this->addscript("/scripts/swfobject2_1.js");
			$this->addscript("/scripts/dragdrop.php?p=$project_id");
		}*/
		
		$this->headtobody();
		
		echo "<div class=\"wrapper\">\n";
	}
	
	// // The below function takes in a project object
	// // and outputs a sortable (hopefully) list of its component items
	// function sortables($project){
	// 	echo "<ul id=\"clip-list ui-sortable\">\n";
	// 	echo "WTF!";
	// 	$videos = $project->get_videos();
	// 	
	// 	foreach($videos as $video){
	// 		echo "\t<li id=\"clip_$video->video_id\">\n";
	// 		echo "\t\t<img alt=\"$video->title\" class=\"thumbnail\" src=\"$video->smallthumb\"/><br />\n";
	// 	    echo "\t\t<span class=\"clip-list-title\">$video->title</span>\n";
	//   		echo "\t</li>\n";
	// 	}
	// 	echo "</ul>\n";
	// }
	
	function topnav(){
		?>

<div id="headerPan">
	<form name="login_box" method="post"  action="/login.php">
	<label></label>
	<input type="text" name="username" value="username" />
	<input type="password" name="password" value="password" />
	<input type="submit" name="buttone" class="button" value="" title="login" />
</form>
	<ul>
		<li><a href="/index.php">home</a></li>
		<li><a href="/projectlist.php">projects</a></li>
		<li><a href="/videos.php">video library</a></li>
		<li><a href="/tags.php">tags</a></li>
		<li><a href="/new_project.php">new project</a></li>
		<li><a href="/addvideo.php">new video</a></li>
		<li><a href="#">about</a></li>
		<li><a href="#">contact</a></li>
	</ul>
</div>

<?php
	}
	
	function footer(){
?>		<!--footer start -->

<div class="push"></div>
<!-- End body wrapper -->
<div class="footer">

<div id="footerMain">
	
		<div id="footerImage">

			<div id="footer">

				<ul>
					<li><a href="/index.php">home</a>|</li>
					<li><a href="#">about&nbsp;us</a>|</li>
					<li><a href="/videos.php">video&nbsp;library</a>|</li>
					<li><a href="mailto:wikistudios@mailinator.com">contact&nbsp;us</a></li>
				</ul>

				<p>&copy; Copyright  WikiStudios. All rights reserved.</p>

				<p class="copy">Designed by: <a>WikiStudiosDev</a></p>

			</div>

		</div>

	</div>

</div>
</div>
<!--footer end -->

</body>

</html> <?php
	}
	
}