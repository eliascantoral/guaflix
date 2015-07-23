<?php
/*
	Template name: Player
*/
 get_header();

if(isset($_GET["object"]) && $_GET["object"]!=""){
?>
	<div id="canvasplayer" align="center">
		
		<?php 
		$wowza_server = get_field("servidor_wowza","option");
		//echo $wowza_server;
		$url = get_field("video",$_GET["object"]);
                $url = $url['url'];
		$url = str_replace("http://","",$url);
		$url = str_replace("https://","",$url);
                                
		$url="http://".$wowza_server.":1935/vods3/_definst_/mp4:amazons3/".$url."/manifest.f4m";
                
                $url="http://".$wowza_server.":1935/vods3/_definst_/mp3:amazons3/guaflix-vid-stream/wp-content/uploads/2015/07/Queen-Bohemian-Rhapsody.mp3/manifest.f4m";
		$url= urlencode($url);
		//echo $url;
		include_once("player/player.php");?>
	</div>
<?php
	
}else{
	?>
		<div class="alert alert-danger" role="alert">Ingreso incorrecto</div>	
	<?php
}
?>

<?php get_footer(); ?>