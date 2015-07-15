<?php
/*
Template Name: Home page
*/
?>
<?php get_header(); ?>
				<div id="carrusel_wrapper" align="center">
					<div id="carrusel" class="owl-carousel">						  						 
						<?php 
							$header_slider = get_field('header_slider');
								if( $header_slider ): ?>								
									<?php foreach( $header_slider as $post): // variable must be called $post (IMPORTANT) ?>
										<?php setup_postdata($post); ?>													
										<?php while(the_repeater_field('imagenes',get_the_ID())): ?>											
											<?php $url = get_sub_field('url');?>
											
											 <div class="item">
												<?php if($url[0]!=""){?><a href="<?php echo get_permalink($url[0]); ?>"><?php }?>
													<img src="<?php the_sub_field('imagen'); ?>" />
												<?php if($url[0]!=""){?></a><?php }?>													
											 </div>											
										<?php endwhile; ?>											
									<?php endforeach; ?>									
									<?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
							<?php endif; ?>					 
					</div>
				</div>
				<script>
					$(document).ready(function() {					
							$("#carrusel").owlCarousel({
								autoPlay : 3000,
								stopOnHover : true,
								navigation:true,
								navigationText: [
								  "<i class='icon-chevron-left icon-white'><</i>",
								  "<i class='icon-chevron-right icon-white'>></i>"
								  ],
								paginationSpeed : 1000,
								goToFirstSpeed : 2000,
								singleItem : true,
								autoHeight : true,
								transitionStyle:"fade"
							});						
					});
				</script>  

					
<?php 

	$header_slider = get_field('body_slider');
	for($i=0;$i<sizeof($header_slider);$i++){
		get_slider($header_slider[$i][slider][0]);
		
	}
	//print_array($header_slider);
	//get_slider("5");
	
	
?>
<div class="clear"></div>

<?php get_footer(); ?>