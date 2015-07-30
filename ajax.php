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
                                        if($participants){
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
				}		
			break;}
		case "4":{
			if(isset($_POST["se"])){
				include_once("logic/service.php");
				get_rating($_POST["se"], is_login());
				
			}
			break;}
		case "5":{
			$answer = array("r"=>"0","d"=>"Acceso no valido.");
			if(isset($_POST["user_"]) && isset($_POST["object_"]) && isset($_POST["paym"]) && isset($_POST["tc_"])){
				$object_id = $_POST["object_"];
				$tc = $_POST["tc_"];
				$days = isset($_POST['day'])?$_POST['day']:null;
				//print_array($_POST);				
				
				if($_POST["user_"]==is_login()){					
					$cost = "";
					$status = false;
					$total = 0;
					
					switch($_POST["paym"]){
						case "0":{///Compra							
							$cost = get_field("compra", $object_id);							
							$total = $cost;
							$status = true;
							break;}
						case "1":{///Renta
							
							$cost = get_field("renta", $object_id);
							if(isset($_POST['day'])){								
								$total = $cost * $_POST['day'];
							}else{
								$total = $cost;								
							}
							$status = true;
							break;}
						case "2":{///Membresia							
							if(user_subscription($user)){
								$cost = get_field("membresia", $object_id);
								$total = $cost;
								$status = true;
							}else{
								$answer = array("r"=>"3","d"=>"Debe activar previamente su membresia.");							
							}
							break;}						
						default: $answer = array("r"=>"0","d"=>"Tipo de compra no valida.");
					}
					if($status){						
						if($total>0){							
							$respuesta = make_pay(is_login(), $total, $tc);
							if($respuesta){
													
								if(save_pay(is_login(), $tc, $object_id, "Compra de objeto", $total, "1")){
									if(add_userobject(is_login(), $object_id, $_POST["paym"], $total, $days)){																		
										$answer = array("r"=>"1","d"=>$object_id);										
									}																		
								}
															
							}else{
								$answer = array("r"=>"0","d"=>"No se pudo realizar el cobro, por favor contactar a su banco si el problema continua.");								
							}
						}else{
							$answer = array("r"=>"0","d"=>"Todo se realizo correctamente, por favor espere un momento...");						
						}											
					}else{
						$answer = array("r"=>"0","d"=>"No se pudo verificar el estado de su cuenta.");
						
					}									
				}else{
					$answer = array("r"=>"0","d"=>"Acceso incorrecto. Por favor intente luego.");	
				}				
			}
			
			echo json_encode ($answer);
			break;}
                        /********************************************** AJAX PLAYER ***************************************************/
                        /********************************************** AJAX PLAYER ***************************************************/
                        /********************************************** AJAX PLAYER ***************************************************/
                        /********************************************** AJAX PLAYER ***************************************************/
                        /********************************************** AJAX PLAYER ***************************************************/
                        
                        case "audioplayer":{                                
                            ?>
                                <div id="canvasplayeraudio" align="center">
                                        <?php 
                                        $wowza_server = get_field("servidor_wowza","option");
                                        $url="http://".$wowza_server.":1935/vods3/_definst_/mp3:amazons3/guaflix-vid-stream/wp-content/uploads/2015/07/Queen-Bohemian-Rhapsody.mp3/manifest.f4m";
                                        $url= urlencode($url);
                                        //echo $url;
                                        ///include_once("player/audioplayer.php");?>                                                ﻿                                        
                                        <object width="300px" height="40px">
                                            <param name="movie" value="http://fpdownload.adobe.com/strobe/FlashMediaPlayback_101.swf"></param>
                                            <param name="flashvars" value="src=<?php echo $url;?>&playButtonOverlay=false&autoPlay=true&streamType=recorded&bufferingOverlay=false&initialBufferTime=5"></param>
                                            <param name="allowscriptaccess" value="always"></param>
                                            
                                            <embed src="http://fpdownload.adobe.com/strobe/FlashMediaPlayback_101.swf" type="application/x-shockwave-flash" wmode="opaque" allowscriptaccess="always" allowfullscreen="true" width="100%" height="100%" flashvars="src=<?php echo $url;?>&playButtonOverlay=false&autoPlay=true&streamType=recorded&bufferingOverlay=false&initialBufferTime=5"></embed>
                                        </object>                                                
                                </div>  
                            <?php 
                            break;}
                        case "audioplayer2":{                                
                            ?>
                                <link href="<?php echo get_template_directory_uri(); ?>/audioplayer/lib/circle-player/skin/circle.player.css" rel="stylesheet" type="text/css" />                                
                                <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/audioplayer/lib/jquery.min.js"></script>
                                <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/audioplayer/dist/jplayer/jquery.jplayer.min.js"></script>
                                <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/audioplayer/dist/add-on/jquery.jplayer.inspector.min.js"></script>
                                <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/audioplayer/lib/circle-player/js/jquery.transform2d.js"></script>
                                <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/audioplayer/lib/circle-player/js/jquery.grab.js"></script>
                                <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/audioplayer/lib/circle-player/js/mod.csstransforms.min.js"></script>
                                <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/audioplayer/lib/circle-player/js/circle.player.js"></script>
                               
                                
                                <script type="text/javascript">
                                //<![CDATA[

                                $(document).ready(function(){
                                        var myCirclePlayer = new CirclePlayer("#jquery_jplayer_1",
                                        {
                                                mp3: "https://s3.amazonaws.com/guaflix-vid-stream/wp-content/uploads/2015/07/Queen-Bohemian-Rhapsody.mp3"		
                                        }, {
                                                cssSelectorAncestor: "#cp_container_1",
                                                swfPath: "<?php echo get_template_directory_uri(); ?>/audioplayer/dist/jplayer",
                                                supplied: "mp3",
                                                preload: "none",
                                                wmode: "window",
                                                useStateClassSkin: true,
                                                autoBlur: false,
                                                keyEnabled: true
                                        }); 
                                        setTimeout(function(){$(".cp-play").trigger( "click" );},100);
                                });                                
                                //]]>
                                </script> 
                                <div id="canvasplayeraudio" align="center">
                                    <div id="jquery_jplayer_1" class="cp-jplayer"></div>

                                    <!-- The container for the interface can go where you want to display it. Show and hide it as you need. -->

                                    <div id="cp_container_1" class="cp-container">
                                            <div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
                                                    <div class="cp-buffer-1"></div>
                                                    <div class="cp-buffer-2"></div>
                                            </div>
                                            <div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
                                                    <div class="cp-progress-1"></div>
                                                    <div class="cp-progress-2"></div>
                                            </div>
                                            <div class="cp-circle-control"></div>
                                            <ul class="cp-controls">
                                                    <li><a class="cp-play" tabindex="1">play</a></li>
                                                    <li><a class="cp-pause" style="display:none;" tabindex="1">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
                                            </ul>
                                    </div> 
                                </div>
                            <?php 
                            break;}                            
                        




			/********************************************** AJAX PROFILE ***************************************************/
			/********************************************** AJAX PROFILE ***************************************************/
			/********************************************** AJAX PROFILE ***************************************************/
			/********************************************** AJAX PROFILE ***************************************************/
			/********************************************** AJAX PROFILE ***************************************************/

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

		case "cards":{
			if( isset($_POST["todo"])){
				switch ($_POST["todo"]) {
					case 'add':
						if( isset($_POST["numCard_"]) && isset($_POST["nameCard_"]) && isset($_POST["month_"]) && isset($_POST["year_"]) && isset($_POST["id_"]) ){
							$addCard = add_card_user($_POST["numCard_"], $_POST["nameCard_"], $_POST["month_"],$_POST["year_"],$_POST["id_"]);	
							?>
								<input type="text" id="txt_ver1" class="form-control" value="<?php echo $addCard; ?>" aria-describedby="basic-addon4" >		
							<?php
						}
						break;
					
					case 'edit':
						if( isset($_POST["numCard_"]) && isset($_POST["nameCard_"]) && isset($_POST["month_"]) && isset($_POST["year_"]) && isset($_POST["id_"]) ){
							$editCard = edit_card_user($_POST["numCard_"], $_POST["nameCard_"], $_POST["month_"],$_POST["year_"],$_POST["id_"]);	
							?>
								<input type="text" id="txt_ver1" class="form-control" value="<?php echo $editCard; ?>" aria-describedby="basic-addon4" >		
							<?php
						}
						break;

					case 'erase':
						if( isset($_POST["id_card"] )){
							$eraseCard = erase_card_user($_POST["id_card"]);	
							?>
								<input type="text" id="txt_ver1" class="form-control" value="<?php echo $eraseCard; ?>" aria-describedby="basic-addon4" >		
							<?php	
						}
						break;

					default:
						# code...
						break;
				}
			}
			break;
		}

		/********************************************** AJAX PROFILE ***************************************************/
		/********************************************** AJAX PROFILE ***************************************************/
		/********************************************** AJAX PROFILE ***************************************************/
		/********************************************** AJAX PROFILE ***************************************************/
		/********************************************** AJAX PROFILE ***************************************************/

		default : echo  "*.*";
	}
}
?>