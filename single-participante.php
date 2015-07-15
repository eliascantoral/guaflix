<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div id="object_info_wrapper" align="center">
	<div id="object_info" align="left">
		<div class="media">
		  <div class="media-left media-top">
			<a href="#">
			<?php $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );?>
				<img src="<?php echo $feat_image;?>" width="150px">
			</a>		
		  </div>
		  <!--<div id=""></div>-->
		  <div class="media-body">
			<h4 class="media-heading"><?php the_title();?></h4>
			<div id="object_content"><?php the_content(); ?></div>			
		  </div>
		</div>
	</div>
	<div id="participant_objects">
	
	</div>
</div>

<script>
	$( document ).ready(function() {		
		ajax_async("2","&se="+<?php echo $post->ID;?>,false,"participant_objects");	
	});
</script>


<?php endwhile; endif; ?>
<?php get_footer(); ?>
