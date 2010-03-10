<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
<meta name="generator" content=
"HTML Tidy for Linux/x86 (vers 6 November 2007), see www.w3.org">

<link rel="stylesheet" type="text/css" media="screen" href="wikistudios.css" />

<script src="jquery-1.3.1.js" type="text/javascript"></script>
<script src="jquery-ui-personalized-1.6rc6.js" type="text/javascript"></script>
<script type="text/javascript" src="swfobject2_1.js"></script>
<script type="text/javascript">

// JW Player Code ////////////
/*
var playerSWF = new SWFObject("player.swf","ply","790","368","9","#FFFFFF");
playerSWF.addParam("allowfullscreen","true");
playerSWF.addParam("allowscriptaccess","always");
playerSWF.addParam("flashvars","file=http://wikistudios.caryme.com/playlist.php?p=4&skin=modieus.swf&playlist=none&controlbar=over&stretching=fill&repeat=list");
*/

var videoPlayer = null; // Main video player object

// JW Player calls this  function once the player is ready
function playerReady(thePlayer) { 
    videoPlayer = window.document[thePlayer.id]; 
    var tmp = document.getElementById("debug-info");
    if (tmp) { tmp.innerHTML = "About to play file!"; }
    videoPlayer.sendEvent('PLAY');   
 }

function deletePlayer(theWrapper, thePlaceholder, thePlayerId) { 
        swfobject.removeSWF(thePlayerId);
        var tmp=document.getElementById(theWrapper);
        if (tmp) { tmp.innerHTML = "<div id=" + thePlaceholder + "></div>"; 
}
}

function createPlayer(thePlaceholder, thePlayerId, theFile) {
        var flashvars = {
                file: theFile,
                autostart:"true",
                skin: "modieus.swf",
                playlist: "none",
                controlbar: "over",
                stretching: "uniform",
                repeat: "list"
        }
        var params = {
                allowfullscreen:"true", 
                allowscriptaccess:"always"
        }
        var attributes = {
                id:thePlayerId,  
                name:thePlayerId
        }
        swfobject.embedSWF("player.swf", thePlaceholder, "790", "368", "9.0.115", false, flashvars, params, attributes);
}


function playFile(theFile) { 
     deletePlayer("video-player-container", "video-player-place-holder", "main-video-player");
     createPlayer("video-player-place-holder", "main-video-player", theFile);
}
 

//////////////


/// jQuery Code /////////
jQuery(document).ready(function() {

	// Document ready...
	
	/*playerSWF.addParam("flashvars","file=http://wikistudios.caryme.com/playlist.php?p=4&skin=modieus.swf&playlist=none&controlbar=over&stretching=fill&repeat=list");
	playerSWF.write("video-player-container");*/
	
	playFile('http://wikistudios.caryme.com/playlist.php?p=1');
	
    $("#clip-list").sortable({
      handle: '.thumbnail',
      update : function () {
		    var order = $('#clip-list').sortable('serialize');
		    var tmp = document.getElementById("debug-info");
		    if (tmp) { tmp.innerHTML = order; }
		    //$.load("video-sort.php?"+order);
        }
     });
	

//progress bar
	<script type="text/javascript">
		$(function() {
			$("#progressbar").progressbar({
				value: 37
			});
		});
		</script>
	
	
	
	<div class="demo">
	
		<div id="progressbar"></div>
	
	</div>
});
</script>


<title> Wikistudios View Project Test</title>
</head>


<body>
<h3>Sortable Clip List Test</h3>

<div id="video-player-container">
    <div id="video-player-place-holder"></div>
</div>

<!-- This is where the clip list begins. The img sources and title need to be inserted by the PHP -->
<br>
<ul id="clip-list" "ui-sortable">
  <li id="clip_1">
    <img height="80" border="0" width="145" alt="Powerthirst" class="thumbnail" src="http://img.youtube.com/vi/qRuNxHqwazs/0.jpg"/>
    <span class="clip-list-title">Powerthirst</span>
  </li>
  <li id="clip_2">
    <img height="80" border="0" width="145" alt="The Office" class="thumbnail" src="http://img.youtube.com/vi/excBsIv_3xI/0.jpg"/>
    <span class="clip-list-title">The Office</span>
  </li>
  <li id="clip_3">
    <img height="80" border="0" width="145" alt="Some office video" class="thumbnail" src="http://img.youtube.com/vi/sA1qEckOkP8/0.jpg"/>
    <span class="clip-list-title">Some office video</span>
  </li>
  <li id="clip_4">
    <img height="80" border="0" width="145" alt="Summer Heights High - Crumpet" class="thumbnail" src="http://img.youtube.com/vi/qRuNxHqwazs/0.jpg"/>
    <span class="clip-list-title">Summer Heights High - Crumpet</span>
  </li>

</ul>
<!-- End of clip list -->

<p>
Debug Info:
</p>
<div id="debug-info"></div>


</body>


</html>
