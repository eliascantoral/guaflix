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
		//print_array($option);
		//print_array($category);
		
		// WP_Query arguments
		$args = array (
			'post_type'              => 'objeto',
			'post_status'            => 'publish',
			'cat'                    => $category_list,
			'order'                  => 'DESC',
			'orderby'                => 'date',
		);

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
?>