<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( ' | ', true, 'right' ); ?></title>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style/bootstrap/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/jqueryui/jquery-ui.css">
<link href="<?php echo get_template_directory_uri(); ?>/js/owl-carousel/owl.carousel.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/js/owl-carousel/owl.theme.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/js/owl-carousel/owl.transitions.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style/ihover.css">
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />


<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/owl-carousel/owl.carousel.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jqueryui/jquery-ui.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/style/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "8cd12b29-5346-47d7-aac0-79e1d18d9aa1", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<?php wp_head(); ?>
</head>
<?php 
	$visitor_access = get_field("acceso","option");
	switch($visitor_access){
		case "secret":{
				if(!is_login() && (get_variable("login")!="?page_id=".get_the_ID() || get_variable("register")!="?page_id=".get_the_ID() )) {wp_redirect( get_variable("login") ); exit;}
			break;}
		case "home":{
			if(!is_login() && get_post_type( get_the_ID() )=="objeto" && (get_variable("login")!="?page_id=".get_the_ID() || get_variable("register")!="?page_id=".get_the_ID() )){wp_redirect( get_variable("login") ); exit;}
			break;
		}
		case "object":{
			if(!is_login() && get_post_type( get_the_ID() )=="player" && (get_variable("login")!="?page_id=".get_the_ID() || get_variable("register")!="?page_id=".get_the_ID() )){wp_redirect( get_variable("login") ); exit;}
			break;
		}
	}
?>
<body <?php body_class(); ?>>
		
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="<?php echo get_home_url(); ?>"><img alt="Brand" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" height="100%"></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Categor&iacute;as <span class="caret"></span></a>


				  
						 <?php 
							$args = array(
							'type'                     => 'post',
							'child_of'                 => 0,
							'parent'                   => '0',
							'orderby'                  => 'name',
							'order'                    => 'ASC',
							'hide_empty'               => 0,
							'hierarchical'             => 1,
							'exclude'                  => '',
							'include'                  => '',
							'number'                   => '',
							'taxonomy'                 => 'category',
							'pad_counts'               => false 
							);
							$category = get_categories( $args );
							//print_array($category);
							echo "<ul class='dropdown-menu multi-level' role='menu' aria-labelledby='dropdownMenu'>";
							for($i = 0; $i<sizeof($category);$i++){		
								echo "<li";
								$parent =  $category[$i]->term_id;								
										$subargs = array(
											'type'                     => 'post',
											'child_of'                 => 0,
											'parent'                   => $parent,
											'orderby'                  => 'name',
											'order'                    => 'ASC',
											'hide_empty'               => 0,
											'hierarchical'             => 1,
											'exclude'                  => '',
											'include'                  => '',
											'number'                   => '',
											'taxonomy'                 => 'category',
											'pad_counts'               => false 
										);
										$subcategory = get_categories( $subargs );
										if(sizeof($subcategory)>0){
													echo " class='dropdown-submenu'>";
													echo "<a href='#' class='list_category' id='".$category[$i]->term_id."'>".$category[$i]->name."</a>";
													echo "<ul class='dropdown-menu'>";
													for($e=0;$e<sizeof($subcategory);$e++){
															echo "<li><a href='#'  class='list_category' id='".$subcategory[$e]->term_id."'>".$subcategory[$e]->name."</a></li>";				
													}
													echo "</ul>";
											$subcategory = array();					
										}else{echo "><a href='#' class='list_category' id='".$category[$i]->term_id."'>".$category[$i]->name."</a>";}			
								echo "</li>";
							}
							echo "</ul>";	
						?>
				</li>
			  </ul>
			  <form class="navbar-form navbar-left" role="search">
				<div class="form-group">
				  <input type="text" id="search_text" class="form-control" placeholder="Buscar">
				</div>
				<!--<button type="submit" class="btn btn-default">Submit</button>-->
			  </form>
			  <ul class="nav navbar-nav navbar-right">	
				<?php if(!is_login()){?>
						<li><a href="<?php echo get_variable("login");?>">Ingresar</a></li>
						<li class="dropdown"> <a href="<?php echo get_variable("register");?>">Registrarme</a></li>			
				<?php }else{?>
						<li><a href="<?php echo get_variable("profile");?>">Mi Perfil</a></li>						
						<li class="dropdown"> <a href="#" id="logout_link">Salir</a></li>							
				<?php }?>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	<div id="finder_wrapper">
		
	</div>
	<div class="clear"></div>
	<div id="page_wrapper" align="center">
           

		<div id="page" align="left">