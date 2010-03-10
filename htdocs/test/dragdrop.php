<?php
$project_id = $_GET['p'];
?>
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
        swfobject.embedSWF("/jwplayer/player.swf", thePlaceholder, "790", "368", "9.0.115", false, flashvars, params, attributes);
}


function playFile(theFile) { 
     deletePlayer("video-player-container", "video-player-place-holder", "main-video-player");
     createPlayer("video-player-place-holder", "main-video-player", theFile);
}
 

//////////////


/// jQuery Code /////////
jQuery(document).ready(function() {
	// Document ready...
	
	/*playerSWF.addParam("flashvars","file=http://wikistudios.caryme.com/playlist.php?p=<?$project_id?>&skin=modieus.swf&playlist=none&controlbar=over&stretching=fill&repeat=list");
	playerSWF.write("video-player-container");*/
	
	playFile('http://wikistudios.caryme.com/playlist.php?p=<?=$project_id?>');
	
    $("#clip-list").sortable({
      handle: '.thumbnail',
      update : function () {
			var project = "http://wikistudios.caryme.com/playlist.php?p=<?=$project_id?>";
		    var order = $('#clip-list').sortable('serialize');
		    //var tmp = document.getElementById("debug-info");
		    //if (tmp) { tmp.innerHTML = order; }
		    //$.load("video-sort.php?p=<?=$project_id?>&"+order);
			$.get("video-sort.php?p=<?=$project_id?>&"+order);
			// videoPlayer.sendEvent('LOAD', 'http://wikistudios.caryme.com/playlist.php?p=<?$project_id?>');
			videoPlayer.sendEvent('STOP');
			//setTimeout("videoPlayer.sendEvent('LOAD', project)",0);
			videoPlayer.sendEvent('LOAD', project);
        }
     });
	
});