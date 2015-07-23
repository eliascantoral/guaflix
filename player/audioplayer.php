<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
﻿<script type="text/javascript">//<![CDATA[
var playlistStr ="<?php echo $url;?>"
//if (screen.height > 800)
//	playlistStr = "http%3A%2F%2F54.152.103.80%2Fvod%2Fmp4:sample.mp4%2Fmanifest.f4m";

document.write('<object width="300px" height="200px">');
document.write('<param name="movie" value="http://fpdownload.adobe.com/strobe/FlashMediaPlayback_101.swf"></param>');
document.write('<param name="flashvars" value="src='+playlistStr+'&playButtonOverlay=false&autoPlay=true&streamType=recorded&bufferingOverlay=false&initialBufferTime=5"></param>');
document.write('<param name="allowFullScreen" value="true"></param>');
document.write('<param name="allowscriptaccess" value="always"></param>');
document.write('<param name="wmode" value="opaque"></param>');
document.write('<embed src="http://fpdownload.adobe.com/strobe/FlashMediaPlayback_101.swf" type="application/x-shockwave-flash" wmode="opaque" allowscriptaccess="always" allowfullscreen="true" width="100%" height="100%" flashvars="src='+playlistStr+'&playButtonOverlay=false&autoPlay=true&streamType=recorded&bufferingOverlay=false&initialBufferTime=5"></embed>');
document.write('</object>');
//]]></script>
<noscript>
    <object width="300px" height="200px">
    <param name="movie" value="http://fpdownload.adobe.com/strobe/FlashMediaPlayback_101.swf"></param>
    <param name="flashvars" value="src=http%3A%2F%2F184.72.239.149%2Fvod%2Fsmil:bigbuckbunnybaseline.smil%2Fmanifest.f4m&playButtonOverlay=false&autoPlay=true&streamType=recorded&bufferingOverlay=false&initialBufferTime=5"></param>
    <param name="allowFullScreen" value="true"></param>
    <param name="allowscriptaccess" value="always"></param>
    <param name="wmode" value="opaque"></param>
    <embed src="http://fpdownload.adobe.com/strobe/FlashMediaPlayback_101.swf" type="application/x-shockwave-flash" wmode="opaque" allowscriptaccess="always" allowfullscreen="true" width="640" height="360" flashvars="src=http%3A%2F%2F184.72.239.149%2Fvod%2Fsmil:bigbuckbunnybaseline.smil%2Fmanifest.f4m&playButtonOverlay=false&autoPlay=true&streamType=recorded&bufferingOverlay=false&initialBufferTime=5"></embed>
    </object>
</noscript>