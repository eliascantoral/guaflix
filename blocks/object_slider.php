<?php
	function get_slider_box($slider){
		?>
			<div id="slider_wrapper_<?php echo $slider[0];?>" class="slider_wrapper" style="width:auto; min-width: 260px; width: <?php echo $slider[3]?>;">				

				<div class="col-md-12 slider_title"><h3><?php echo $slider[1];?></h3></div>
					
							<div id="slider_<?php echo $slider[0];?>" class="slider">
								<?php $elements = $slider[4];						
										for($i=0;$i<sizeof($elements);$i++){
											?><div class="item slider_element">
													<div class="slider_element_inside">
														<?php									
															get_objectbox($elements[$i]);
														?>
													</div>
											</div><?php							
										}
								?>
							</div>
					

				<script>
					$("#slider_<?php echo $slider[0];?>").owlCarousel({
						stopOnHover : true,
						navigation:true,
						navigationText: [
						  "<i class='icon-chevron-left icon-white'><</i>",
						  "<i class='icon-chevron-right icon-white'>></i>"
						  ],
						paginationSpeed : 1000,
						goToFirstSpeed : 2000,
						pagination: false,
						responsive: true,
						responsiveRefreshRate : 200,
						responsiveBaseWidth: $("#slider_wrapper_<?php echo $slider[0];?>"),						
							});	
				</script>
			</div>
			
		<?php		
	}

?>