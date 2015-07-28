<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
<meta charset="utf-8" />
<title>Guaflix-Player</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="jplayer/style/css/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jplayer/lib/jquery.min.js"></script>
<script type="text/javascript" src="jplayer/dist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){

	$("#jquery_jplayer_1").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				title: "Space Alone - Ilias Sounas",
				rtmpv: "rtmp://52.5.124.101:1935/vods3/_definst_/mp4:amazons3/guaflix-vid-stream/wp-content/uploads/2015/07/fantastic4.mp4",
				poster: "https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQXKnWQWMhK31WAgxYay2rPHJpN8zbrhhO2UNy271yCBonwK-wFVA"
			}).jPlayer("play");
		},
		swfPath: "jplayer/dist/jplayer",
		supplied: "rtmpv",
		size: {
			width: "640px",
			height: "360px",
			cssClass: "jp-video-360p"
		},
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: true,
		toggleDuration: true
	});
    $("#thebutton").click( function() {
      $("#jquery_jplayer_1").jPlayer("play",50);
    });      
    var myVar=setInterval(function () {myTimer()}, 3000);
    function myTimer() {
        $("#current").val($("#jquery_jplayer_1").data("jPlayer").status.currentTime);
    }    
    
   
});
//]]>
</script>
</head>
<body>
<div id="jp_container_1" class="jp-video jp-video-360p" role="application" aria-label="media player">
	<div class="jp-type-single">
		<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		<div class="jp-gui">
			<div class="jp-video-play">
				<button class="jp-video-play-icon" role="button" tabindex="0">play</button>
			</div>
			<div class="jp-interface">
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
				<div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
				<div class="jp-controls-holder">
					<div class="jp-controls">
						<button class="jp-play" role="button" tabindex="0">play</button>						
                                                <button class="jp-stop" role="button" tabindex="0">stop</button>                                                 
					</div>
					<div class="jp-volume-controls">                                                
						<button class="jp-mute" role="button" tabindex="0">mute</button>
						<button class="jp-volume-max" role="button" tabindex="0">max volume</button>
						<div class="jp-volume-bar">
							<div class="jp-volume-bar-value"></div>
						</div>
					</div>
					<div class="jp-toggles">
						<button class="jp-repeat" role="button" tabindex="0">repeat</button>
						<button class="jp-full-screen" role="button" tabindex="0">full screen</button>
                                                <!--<button id="jp-backbutton" class="jp-back" role="button" tabindex="0">back</button>-->
					</div>
				</div>
				<div class="jp-details">
					<div class="jp-title" aria-label="title">&nbsp;</div>
				</div>
			</div>
		</div>
		<div class="jp-no-solution">
			<span>Update Required</span>
			To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		</div>
	</div>
</div>
    
    <button id="thebutton" value="hola">hola</button>
    <input type="text" id="current" value="">
</body>

</html>
<script>   
</script>