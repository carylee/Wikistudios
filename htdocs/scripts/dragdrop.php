<?php
require_once('../../includes/header.php');
$project_id = $_GET['p'];
$project = new Project($project_id);
$duration = $project->get_duration();
$duration_string = $project->get_video_durations();
?>
var videoPlayer = null; // Main video player object
var project = "http://wikistudios.caryme.com/playlist.php?p=<?=$project_id?>";
var project_dur = <?=$duration?>;
var dur_string = '<?=$duration_string?>';
var dur_array = dur_string.split();

// Progress bar related variables
var playerProgressMAX = project_dur;
var curVideoPos = 0;
var currentItem = 0;

function updateVideoPlayerReference()
{
    if (videoPlayer == null)
    {
        videoPlayer = document.getElementById("main-video-player");
    }
}

// JW Player calls this  function once the player is ready
function playerReady(thePlayer) { 
    /*alert('the videoplayer '+thePlayer['id']+' has been instantiated');
    videoPlayer = window.document[thePlayer.id]; */
    updateVideoPlayerReference();
    
    var tmp = document.getElementById("debug-info");
    if (tmp) { tmp.innerHTML = "About to play file!"; }
    videoPlayer.sendEvent('PLAY');
    addListeners();   
 }
 
 function addListeners() {
	updateVideoPlayerReference();
	if (videoPlayer) { 
		videoPlayer.addModelListener("TIME", "positionListener");
		 player.addControllerListener('ITEM',  'itemMonitor');
	} else {
		setTimeout("addListeners()",100);
	}
}

function itemMonitor(obj){
     currentItem = obj.index;
};

function positionListener(obj) { 
	curVideoPos = obj.position; 
	var tmp = document.getElementById("elapsed-time");
	
    var globalVidPos = curVideoPos;
    updateVideoPlayerReference();
    var testDur = 0;
    if ( videoPlayer ){
        var currentPlaylist = videoPlayer.getPlaylist();
        
        for (var i = currentItem-1; i >= 0; i=i-1) 
        {
            globalVidPos = globalVidPos + currentPlaylist[i].duration;
        }

        testDur = currentPlaylist[0].duration;
    }

    $("#project-progress").value(globalVidPos);
	if (tmp) { tmp.innerHTML = globalVidPos + "s / " + project_dur + "s" ; }
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
                skin: "/jwplayer/modieus.swf",
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
 
function reloadPlayer(){
    updateVideoPlayerReference();
    
	videoPlayer.sendEvent('STOP');
	videoPlayer.sendEvent('LOAD', project);
}

//////////////


/// jQuery Code /////////
jQuery(document).ready(function() {
	// Document ready...
		
	playFile(project);
	
	$("#project-progress").slider({
			range: "min",
			value: 60,
			min: 0,
			max: playerProgressMAX,
			slide: function(event, ui) {
				
			}
		});

	
    $("#clip-list").sortable({
      handle: '.thumbnail',
      update : function () {
		    var order = $('#clip-list').sortable('serialize');
			$.get("/functions/video-sort.php?p=<?=$project_id?>&"+order, reloadPlayer());
			
        }
     });
	
});
