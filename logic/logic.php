<?php
	
	

	/**************************************************************************************************************************/
	function get_objectdata($object_id){
		//$return = array();
		$post = get_post($object_id);
		//print_array($post);
		$post_title = $post->post_title;
		$abst_size = strlen($post_title)>35?65:130;
		$time = get_field("tiempo",$post->ID);
		$field = array();
		$autor = get_field("participant",$post->ID);
		if($autor){
			array_push($field,array("Autor",get_the_title($autor[0])));
		}		
		$return = array($post->ID,$post_title,get_permalink($post->ID), the_excerpt_max_charlength($post->ID,$abst_size),"", $field);
		return $return;
	}
	function get_sliderobjects_array($slider){
		$category = get_field("categoria", $slider);
		$category_list = "";
		$return = array();
		$index = 0;
		for($i=0;$i<sizeof($category);$i++){
			$category_list .= strlen($category_list)>0?",":"";
			$category_list .=$category[$i];
		}
		$option = get_field("opciones", $slider);
		if ( is_user_logged_in() ) { 
//			print_array($option);
//			if(array_contain('new',$option)){echo "NEW";}
//			print_array($category);		
		}
		
		// WP_Query arguments
		if(sizeof($option)>0){
			if(array_contain('new',$option)){
				$args = array (
					'posts_per_page'         => '10',
					'post_type'              => array( 'objeto', 'serie' ),
					'post_status'            => 'publish',
					'cat'                    => $category_list,
					'order'                  => 'DESC',
					'orderby'                => 'date',
				);				
			}else{
				$args = array (					
					'posts_per_page'         => '10',
					'post_type'              => array( 'objeto', 'serie' ),
					'post_status'            => 'publish',
					'cat'                    => $category_list,
					'order'                  => 'ASC',
					'orderby'                => 'title',
				);
			}
		}else{
			$args = array (
				'posts_per_page'         => '10',
				'post_type'              => array( 'objeto', 'serie' ),
				'post_status'            => 'publish',
				'cat'                    => $category_list,
				'orderby'                => 'rand',
			);			
		}

		// The Query
		$category_posts = new WP_Query($args);

		if($category_posts->have_posts()) : 
			while($category_posts->have_posts()) : 
				$category_posts->the_post();
				$return[$index] = get_the_ID();
				$index++;
			endwhile;
		endif; 		
		return $return;
	}
	function get_slider($id){		
		$post = get_post($id);		
		get_slider_box(array($id, $post->post_title, false, "100%", get_sliderobjects_array($id)));
	}
	
	function user_object_status($user, $post){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->user_object_status($user, $post);

	}
	
	
	function get_payoptions($object_id){
		?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="media-heading">Opciones de compra</h4>
				</div>
				<div class="panel-body">
					<div id="object_content">
						<ul class="nav nav-pills nav-stacked">
							<?php $membresia = get_field("membresia", $object_id);
								if($membresia!=null && $membresia!=""){?>		
									<li role="presentation"><a href="<?php echo get_variable("pay")."&object=".$object_id."&paym=2"?>">Con membres&iacute;a: <?php echo $membresia=="0"?"Gratis":$membresia;?></a></li>
								<?php }?>
								<?php $renta = get_field("renta", $object_id);
								if($renta!=null && $renta!=""){?>
									<li role="presentation"><a href="<?php echo get_variable("pay")."&object=".$object_id."&paym=1"?>">Renta por d&iacute;a: <?php echo $renta=="0"?"Gratis":$renta;?></a></li>
								<?php }?>
								<?php $compra = get_field("compra", $object_id);
								if($compra!=null && $compra!=""){?>				
									<li role="presentation"><a href="<?php echo get_variable("pay")."&object=".$object_id."&paym=0"?>">Compra por: <?php echo $compra=="0"?"Gratis":$compra;?></a></li>
								<?php }?>					
						</ul>					
					</div>	
				</div>
			</div>		
		<?php				
	}
	function get_playoption($object_id){
		?>
			<ul class="nav nav-pills">
				<li role="presentation" class="active"><a href="<?php echo get_variable("player",$object_id);?>&object=<?php echo $object_id;?>">
					<span class="glyphicon glyphicon-play" aria-hidden="true"> Continua</a>
				</li>
			</ul> 											
		<?php		
		
	}
	function get_tcval_list($userid){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->get_tcval_list($userid);
	}
	
	function get_theuserdata($userid){
		return array($userid, "Augusto Mazariegos");		
	}
	function make_pay($user, $total, $tc){
		//$url = "http://www.webservicex.com/globalweather.asmx?wsdl";
		//$client = new SoapClient($url);
		//$fcs = $client->__getFunctions();		
		//$res = $client->GetWeather(array('CityName' => 'Lagos', 'CountryName' => 'Nigeria'));
		$res = true;
		for($i = 0; $i<100;$i++){			
			for($e = 0; $e<100;$e++){
				for($x = 0; $x<10;$x++){
					
				}
			}			
		}
		return $res;		
	}
	function save_pay($userid, $tc, $object, $description, $total, $type){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->save_pay($userid, $tc, $object, $description, $total, $type);	
	}
	function user_subscription($user){
		return true;		
	}
	function add_userobject($user, $object, $paym, $total, $days = null){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->add_userobject($user, $object, $paym, $total, $days);	
	}


/*******************************user logic************************************************/
	function create_user_new($name, $last, $mail, $pass){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->create_user_new($name, $last, $mail, $pass);		
	}

	function get_info_user($id){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->get_info_user($id);			
	}

	function add_card_user($num, $name, $month, $year, $id){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->add_card_user($num, $name, $month, $year, $id);	
	}

	function edit_card_user($num, $name, $month, $year, $id){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->edit_card_user($num, $name, $month, $year, $id);	
	}

	function erase_card_user($id){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->erase_card_user($id);		
	}

	function get_info_cards_ByUserid($id){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->get_info_cards_ByUserid($id);	
	}

	function check_user($mail, $pass){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->check_user($mail, $pass);		
	}

	function change_data($id, $name, $last, $mail){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->change_data($id, $name, $last, $mail);	
	}

	function change_pass($id, $pass){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->change_pass($id, $pass);		
	}

	function check_old_pass($id, $oldpass){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->check_old_pass($id, $oldpass);	
	}

	function get_info_card_ById($id){
		include_once("backend/backend.php");
		$backend = new backend();
		return $backend->get_info_card_ById($id);		
	}
/*****************************user logic*******************************************************/	
	
?>