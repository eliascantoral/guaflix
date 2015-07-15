<?php
	function get_rating($postid, $userid){		
		include_once("backend/backend.php");
		$logic = new backend();
		$rating = $logic->get_rating($postid, $userid);
		?>
			<div class="panel panel-default">
			  <div class="panel-heading" align="right">
			<?php echo "Promedio de ". $rating[0]. ", con un total de " .$rating[1]." voto(s)";?>
			</div>
			  <div class="panel-body">
					<div id="start_panel">
						<div id="rating_panel">
							<?php
							for($i=0;$i<5;$i++){
								?>
									<a class="rate_start navbar-brand" id="s_<?php echo $i;?>" rel="<?php echo $i;?>" href="#">
										<img alt="Brand" src="<?php echo get_template_directory_uri(); ?>/img/star<?php echo $i+1<= round($rating[0])?"_":"";?>.png" height="25px">
									</a>
								<?php
							}
							?>  
						</div>
						<div id="star_userpanel">
						
								<?php if(!$rating[2]){$user_rating = rand(1,5);}else{$user_rating= $rating[2];}?>
						
							<div>
								<?php for($i=0;$i<5;$i++){ ?>
										<a class="rate_start navbar-brand" id="s_<?php echo $i;?>" rel="<?php echo $i;?>" href="#">
											<img alt="Brand" src="<?php echo get_template_directory_uri(); ?>/img/star<?php echo $i+1<= round($user_rating)?"__":"";?>.png" height="25px">
										</a>
								<?php }?> 
							</div>		
							<div>
								<?php if(!$rating[2]){echo "Nuestra predicci&oacute;n es de ".$user_rating.".";}?>
							</div>
						</div>
					</div>
			  </div>
			</div>				
		<?php
		
		//print_array($rating);
	}

?>