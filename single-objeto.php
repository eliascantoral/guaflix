<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php $isfree = get_field("view_method")=="free";
										//$time = strtotime ("today midnight");
										//echo date('l jS \of F Y h:i:s A' , $time-1);
?>


<div id="object_info_wrapper" align="center">
	<div id="object_info" align="left">
		<div class="media">
		  <div class="media-left media-top">
			<a href="#">
				<?php
					if(has_post_thumbnail( $object_id )){
						$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
					}else{
						$feat_image = get_template_directory_uri() . '/img/imagendefault.jpg';
					}?> 			
				<?php 						
			//$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
				<img src="<?php echo $feat_image;?>" width="450px">
			</a>
			<br><br>
			<div class="object_pay">
				<?php 
					if(!$isfree){
						if(!is_login()){
							get_payoptions($post->ID); 
						}else{
							$status = user_object_status(is_login(), $post->ID);
							if(!$status){
								get_payoptions($post->ID);
							}else{
								switch($status[0]){							
									case "0":{//compra
										get_playoption($post->ID);									
									break;}
									case "1":{//alquiler
										$time = strtotime ("today midnight");
										get_payoptions($post->ID);
										if($status[1]>=($time-1)){
											get_playoption($post->ID);
										}else{
											echo "El tiempo de renta ha terminado.";					
										}
										break;
									}
									case "2":{///Membresia
										get_playoption($post->ID);
										break;
									}
									
								}
							}							
							
						}
					}else{ 
						get_playoption($post->ID);
					}
				?>
			</div>
			<br>
			<div class="clear"></div>
			<div id="object_rating"></div>
			<div class="clear"></div>				
		  </div>
		  <!--<div id=""></div>-->
		  <div class="media-body">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="media-heading"><?php the_title();?></h4>
				</div>
				<div class="panel-body">
					<div id="object_content"><?php the_content(); ?></div>	
				</div>
			</div>
	
			<div id="object_participant"></div>
			<div class="clear"></div>	
		  </div>
		</div>
	</div>
</div>
<script>
	$( document ).ready(function() {		
		ajax_async("3","&se="+<?php echo $post->ID;?>,false,"object_participant");
		ajax_async("4","&se="+<?php echo $post->ID;?>,false,"object_rating");
	});
</script>



<?php endwhile; endif; ?>
<?php get_footer(); ?>