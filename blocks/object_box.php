<?php 

	function get_objectbox($object_id, $style=null){
		$object_info = get_objectdata($object_id);
		//print_array($object_info);
		?>
			<div id="objectbox_<?php echo $object_info[0];?>" class="ih-item square effect6 from_top_and_bottom objectbox"><a href="<?php echo $object_info[2];?>">
				<div class="img"><?php
							if(has_post_thumbnail( $object_id )){
								echo get_the_post_thumbnail( $object_id,  array( 150, 150));
							}else{
								echo '<img src="' . get_template_directory_uri() . '/img/imagendefault.jpg"/>';
							}?> 
				</div>
				<div class="info">
				  <h3><?php echo $object_info[1];?></h3>
				  <p><?php echo $object_info[3];?>
					<?php for($i=0;$i<sizeof($object_info[5]);$i++){
						echo "<div class='personal_field'><strong>".$object_info[5][$i][0].": </strong>".$object_info[5][$i][1]."</div>";						
					}?>
					
				   </p>
				</div></a>				
			</div>

		<?php
	}

	function get_participantbox($object_id){		
		?>
			<div class="media">
				<div class="media-left">
					<a href="<?php echo get_permalink($object_id);?>">
						<?php echo get_the_post_thumbnail( $object_id,  array( 150, 150));?>
					</a>
				</div>
				<div class="media-body participant_title">
					<h4 class="media-heading"><a href="<?php echo get_permalink($object_id);?>"><?php echo get_the_title( $object_id ); ?></a></h4>
					<?php echo the_excerpt_max_charlength($object_id,130);?>
				</div>
			</div>
		<?php		
	}
	function get_participantbox_minimal($object_id){		
		?>
			<div class="media">
				<div class="media-middle">
					<a href="<?php echo get_permalink($object_id);?>"  title="<?php echo get_the_title( $object_id ); ?>">
						<?php echo get_the_post_thumbnail( $object_id,  array( 75, 75));?>
						<?php echo get_the_title( $object_id ); ?>
					</a>
				</div>	
				
			</div>
		<?php		
	}	
	
?>