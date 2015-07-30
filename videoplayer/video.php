<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<link href="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/style/css/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/lib/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/dist/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){

	$("#jquery_jplayer_1").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				title: "<?php echo get_the_title($_GET["object"]);?>",
				rtmpv: "<?php echo $url;?>",
				poster: "<?php                        
                                            if(has_post_thumbnail( $_GET["object"] )){                            
                                                    $feat_image = wp_get_attachment_url( get_post_thumbnail_id($_GET["object"]) );                                                                            
                                            }else{
                                                    $feat_image = get_template_directory_uri() . '/img/imagendefault.jpg';                              
                                            }
                                            echo $feat_image;?>"
			}).jPlayer("play");
		},
		swfPath: "<?php echo get_template_directory_uri(); ?>/videoplayer/jplayer/dist/jplayer",
		supplied: "rtmpv",
		size: {
			width: "100%",
			height: "100%",
			cssClass: "jp-video-full"
		},
		useStateClassSkin: true,
		autoBlur: false,
		smoothPlayBar: true,
		keyEnabled: true,
		remainingDuration: true,
		toggleDuration: true                
	});    

    var hidentime = 2;
    var controlvisible = false;
    var myVar=setInterval(function () {myTimer()}, 1000);        
    function myTimer() {
        $("#current").val($("#jquery_jplayer_1").data("jPlayer").status.currentTime); 
        if(controlvisible && hidentime==0){
            $('.video-hover').hide("slow");
            controlvisible = false;
        }else{
            hidentime--;
        }
    }    
    $("#progressbar").click(function(e){
        setTimeout(function(){
            var time = $("#jquery_jplayer_1").data("jPlayer").status.currentTime;
            $("#jquery_jplayer_1").jPlayer("stop");
            $("#jquery_jplayer_1").jPlayer("play",time);                        
        },700);
    });
    
    $('#jp_container_1').bind('mousemove', function(){
            $('.video-hover').show("fast");
            hidentime = 2;
            controlvisible = true;
        });
    $('.center').click(function(){               
        if($("#jquery_jplayer_1").data("jPlayer").status.paused){            
            $("#jquery_jplayer_1").jPlayer("play"); 
            $("#mainplay").attr("src","<?php echo get_template_directory_uri(); ?>/img/pause.png");
        }else{
            $("#jquery_jplayer_1").jPlayer("pause"); 
            $("#mainplay").attr("src","<?php echo get_template_directory_uri(); ?>/img/play.png");
        }
    });
});
//]]>
</script>
<div id="jp_container_1" class="jp-video jp-video-full" role="application" aria-label="media player" align="left">
	<div class="jp-type-single">
		<div id="jquery_jplayer_1" class="jp-jplayer"></div>
		<div class="jp-gui">
			<!--<div class="jp-video-play">
				<button class="jp-video-play-icon" role="button" tabindex="0">play</button>
			</div>-->
			<div class="jp-interface">
				<div class="jp-progress" id="progressbar">
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
        <div class="row video-hover">
            <div class="col-xs-2 col-md-2 side"><a href="<?php echo get_permalink($_GET["object"])?>"><img src="<?php echo get_template_directory_uri(); ?>/img/back.png"></a></div>
            <div class="col-xs-8 col-md-8 center"><img id="mainplay" src="<?php echo get_template_directory_uri(); ?>/img/pause.png"></div>
        </div>
</div>
    <input type="text" id="current" value="">   