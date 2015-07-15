<?php
include_once("logic.php");
ini_variables();
function ini_variables(){
	session_start();
	//print_array($_SESSION);
}

function print_array($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}
function array_contain($what, $where, $pos=null){		
	for($i=0; $i<sizeof($where);$i++){
		if($pos==null){				
			if($what == $where[$i]) return $i+1;
		}else{
			if($what == $where[$i][$pos-1]) return $i+1;
		}
		
	}
	return false;
}
function minimizer_string($cadena){
	$conv = array("á"=>"a","é"=>"e","í"=>"i","ó"=>"o","ú"=>"u","Á"=>"A","É"=>"E","Í"=>"I","Ó"=>"O","Ú"=>"U");
	$tofind = "áéíóúÁÉÍÓÚ";
	$replac = "aeiouAEIOU";
	return(strtr($cadena,$conv));
}	
function get_category_parent($term_id){
		$parent = get_term_by('id',  $term_id, 'area');
		$counter = 0;
		while($parent->parent!='0'&& $counter < 5){
			$parent = get_term_by('id',  $parent->parent, 'area');
			$counter++;
		}
		return $parent->term_id;
}



function the_excerpt_max_charlength($postid, $charlength) {
	$excerpt = get_the_excerpt($postid);
	$charlength++;
	$return = "";
	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$return.= mb_substr( $subex, 0, $excut );
		} else {
			$return.= $subex;
		}
		$return.= '[...]';
	} else {
		$return.= $excerpt;
	}
	return $return;
}


/******************************************************************************************************************************/





function get_variable($var){
	switch($var){
		case "home": return "http://http://localhost/guaflix//";
		case "ajax": return "?page_id=68";
		case "login": return "?page_id=88";
		case "register": return "?page_id=108";
		case "pay": return "?page_id=117";
		case "player": return "?page_id=104";
		case "profile": return "?page_id=107";
		default:{return "";}
	}
}
function is_login(){
	$user = false;
	if(isset($_SESSION["userid"])){$user = $_SESSION["userid"];}
	return $user;
}
?>