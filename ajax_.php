<?php
/*
	Template name: Ajax
*/
//print_array($_POST);	
if(isset($_POST["action"])){
	switch($_POST["action"]){
		case "0":{/////////////Search object
			// WP_Query arguments
			if(isset($_POST["se"])){					
					$args = array (
						'post_type'              => 'objeto',
						's'                      => $_POST["se"],
						'order'                  => 'DESC',
						'orderby'                => 'date',
					);

					
					$query = new WP_Query( $args );	
					if($query->have_posts()) : 
						?>
						<div class="panel panel-default">
						  <div class="panel-heading">Busqueda: <?php echo $_POST["se"];?></div>
						  <div class="panel-body">					
								<?php
								while($query->have_posts()) : 
									$query->the_post();?>							
										<div class="slider_search_element">
											<?php get_objectbox(get_the_ID());?>
										</div>
									<?php
								endwhile;
								?>							
						  </div>
						</div>							
						<?php
					endif;
					
					$args = array (
						'post_type'              => 'participante',
						's'                      => $_POST["se"],
						'order'                  => 'DESC',
						'orderby'                => 'date',
					);
					$query = new WP_Query( $args );	
					if($query->have_posts()) : 
						?>
						<div class="panel panel-default">
						  <div class="panel-heading">Participantes: <?php echo $_POST["se"];?></div>
						  <div class="panel-body">					
								<?php
								while($query->have_posts()) : 
									$query->the_post();?>							
										<div class="slider_search_element">
											<?php get_participantbox(get_the_ID());?>
										</div>
									<?php
								endwhile;
								?>							
						  </div>
						</div>							
						<?php
					endif;				
					
			}		
			break;}////////////Search object
		case "1":{
			if(isset($_POST["se"])){	
					$args = array (
						'post_type'              => 'objeto',
						'cat'                    => $_POST["se"],
						'order'                  => 'DESC',
						'orderby'                => 'date',
					);					
					$query = new WP_Query( $args );	
					if($query->have_posts()) : 
						?>
						<div class="panel panel-default">
						  <div class="panel-heading">Busqueda: <?php echo  get_cat_name($_POST["se"]);?></div>
						  <div class="panel-body">					
								<?php
								while($query->have_posts()) : 
									$query->the_post();?>							
										<div class="slider_search_element">
											<?php get_objectbox(get_the_ID());?>
										</div>
									<?php
								endwhile;
								?>							
						  </div>
						</div>							
						<?php
					endif;				
			}
			break;
		}
		case "2":{////////Responce objects by participant
			if(isset($_POST["se"])){				
						// args
						$args = array(
							'numberposts' => -1,
							'post_type' => 'objeto',
							'meta_query' => array(
								array(
									'key' => 'participant',
									'value' => $_POST["se"],									
									'compare' => 'LIKE'
								)
							)
						);

						// get results
						$the_query = new WP_Query( $args );

						// The Loop
						?>
						<?php if( $the_query->have_posts() ): ?>
								<div class="panel panel-default">
								  <div class="panel-heading"><?php echo get_the_title($_POST["se"]);?></div>
								  <div class="panel-body">					
										<?php
										while($the_query->have_posts()) : 
											$the_query->the_post();?>							
												<div class="slider_search_element">
													<?php get_objectbox(get_the_ID());?>
												</div>
											<?php
										endwhile;
										?>							
								  </div>
								</div>	
						<?php endif; ?>

						<?php wp_reset_query();  // Restore global post data stomped by the_post().						
				
			}
			break;}
		case "3":{////////Responce participant by post
				if(isset($_POST["se"])){
					$participants = get_field("participant",$_POST["se"]);
					?>
						<div class="panel panel-default">
						  <div class="panel-heading">Participantes</div>
						  <div class="panel-body">					
								<?php
								for($i=0;$i<sizeof($participants);$i++){?>
									<div class="slider_search_element">
										<?php get_participantbox_minimal($participants[$i]);?>
									</div>						
								<?php }
								?>
						  </div>
						</div>					
					<?php 
				}		
			break;}
		case "4":{
			if(isset($_POST["se"])){
				include_once("logic/service.php");
				get_rating($_POST["se"], is_login());
				
			}
			break;}
		case "login":{////Login
				if( isset($_POST["mail_"]) && isset($_POST["pass_"]) ){
					if( isset($_POST["name_"]) && isset($_POST["last_"]) ){
						$user_id = create_user_new($_POST["name_"], $_POST["last_"], $_POST["mail_"], $_POST["pass_"]);
					}else{
						$user_id = check_user($_POST["mail_"],$_POST["pass_"]);
					}
					if( $user_id == 0){
						?>
							<input type="text" id="txt_ver1" class="form-control" value="0" aria-describedby="basic-addon4" >
						<?php
						$_SESSION = array();
					}else{
						$_SESSION = array();
						?>
							<input type="text" id="txt_ver1" class="form-control" value="<?php echo $user_id; ?>" aria-describedby="basic-addon4" >
						<?php
						session_start();
						$_SESSION["userid"] = $user_id;
						print_array($_SESSION);	
						echo is_login();
					}
				}
			break;
		}


		case "profile":{////Login
			if( isset($_POST["pass_"]) && isset($_POST["id_"]) ) {
				$user_id = change_pass($_POST["id_"], $_POST["pass_"]);
			}else if ( isset($_POST["oldpass_"]) && isset($_POST["id_"]) ) {
				echo "entro aqui";
				$user_id = check_old_pass($_POST["id_"], $_POST["oldpass_"]);
			}else if( isset($_POST["name_"]) && isset($_POST["last_"]) && isset($_POST["mail_"]) && isset( $_POST["id_"] )){
				$user_id = change_data($_POST["id_"], $_POST["name_"], $_POST["last_"], $_POST["mail_"]);
			}

			if( $user_id == 0){
				?>
					<input type="text" id="txt_ver1" class="form-control" value="0" aria-describedby="basic-addon4" >
				<?php
			}else{
				?>
					<input type="text" id="txt_ver1" class="form-control" value="<?php echo $user_id; ?>" aria-describedby="basic-addon4" >
				<?php
			}
			break;
		}	
		case "logout":{
			if(isset($_POST["userid"])){
				session_start();
				$_SESSION = array();				
			}
			break;
		}
		default : echo  "*.*";
	}
}
?>