<?php
/*
	Template name: Profile
*/

	get_header();

	$info_user = array();
	$info_user = get_info_user(is_login());

	$cP = 0;
	$cD = 0;
	$cPass = 0;
	$cData = 0;


	$addCard = 0;
	$addTarjeta = 0;
	$editCard = 0;

	if(isset($_GET["cP"])){
		if($_GET["cP"]==1){
			$cP = 1;
		}else if( $_GET["cP"] == 'ok' ){
			$cPass = 100;
			$cP = 0;
		}
	}else if( isset($_GET["cD"]) ){
		if( $_GET["cD"]==1 ){
			$cD = 1;
		}else if( $_GET["cD"] == 'ok' ){
			$cData = 100;
			$cD = 0;
		}
	}else if( isset($_GET["addCard"])){
		if( $_GET["addCard"] == 1 ){
			$addCard = 1;
			$addTarjeta = 100;
		}
	}else if ( isset($_GET["editCard"]) ) {
		$editCard = 100;
		$addCard = 1;
	}

?>

<div class="well well-lg" align="center">
	<div class="row" align="center">
		<div class="col-md-6 col-md-offset-3" align="center">
			<?php 
				if( $addCard != 1 ){
			?>
			<div class="panel panel-primary">
				<div class="panel-heading" align="left">
					<?php
						if( ( $cD == 0 ) && ( $cP == 0 ) ){
							?>
								Mi Perfil
							<?php
						}else if( ( $cD == 1 ) && ( $cP == 0 ) ){
							?>
								Editar Información
							<?php
						}else if( ( $cD == 0 ) && ( $cP == 1 ) ){
							?>
								Editar Contraseña
							<?php
						}
					?>
				</div>
				<div class="panel-body">
					<div class="row">
						<?php
							if( ( $cD == 0 ) && ( $cP == 0 ) ){
								include("blocks/profile/data.php");	
							}else if( ( $cD == 1 ) && ( $cP == 0 ) ){
								include("blocks/profile/changeData.php");
							}else if( ( $cD == 0 ) && ( $cP == 1 ) ){
								include("blocks/profile/changePass.php");
							}
						?>
					</div>
					<div id="mensajito-alert" class="alert alert-success action-alert" role="alert">
						
					</div>
					<div id="indicador-alert" style="display:none;">
						<?php 
							if ( $cData == 100 ) {
								?>
									<input type="text" value="1" id="indicador-alert-text"/>
								<?php
							}else if ( $cPass == 100 ) {
								?>
									<input type="text" value="2" id="indicador-alert-text"/>
								<?php
							}
						?>
					</div>
				</div>
			</div>
			<?php } ?>

			<?php 
				if ( $cD != 1 ){
					if ( $cP != 1 ) { 
						?>
							<div class="panel panel-warning">
								<div class="panel-heading">
									<h3 class="panel-title" align="left">
										<?php if( $addTarjeta != 100 && $editCard != 100){ ?>
											Suscripci&oacute;n
										<?php }elseif( $addTarjeta == 100 && $editCard != 100 ){ ?>
											A&ntilde;adir Tarjeta
										<?php }elseif( $editCard == 100 ){ ?>
											Editar Tarjeta
										<?php } ?>
									</h3>
								</div>
								<?php if( $addTarjeta != 100  && $editCard != 100 ){ ?>
								<div id="activar_Membresia"class="panel-body" align="left">
									<?php 
										$membresia = false;
										if($membresia){

										}else{
											?>
												<button type="button" id="btn_membresia" class="btn btn-success" >
													Activar Membresía
												</button>
											<?php		
										}
									?>
								</div>
								<?php } ?>
								<div class="panel-body">
									<div id="addcardSuccess" class="alert alert-success action-alert" role="alert">

									</div>
									<div class="row">
										<?php
											if( ( $addCard == 0 ) && ( $editCard == 0 ) ){
												include("blocks/profile/cardsData.php");	
											}else if( ( $addCard == 1 ) && ( $editCard != 100 ) ){
												include("blocks/profile/addCardData.php");
											}else if( ( $editCard == 100 ) ){
												include("blocks/profile/editCardData.php");
											}
										?>
									</div>
									<div id="mensajito-alert" class="alert alert-success action-alert" role="alert">
										
									</div>
									<div id="login_message2" class="alert alert-success action-alert" role="alert">

									</div>
									<div id="indicador-alert" style="display:none;">
										<?php 
											if ( $addTarjeta == 100 ) {
												?>
													<input type="text" value="1" id="indicador-alert-text_Tarjeta"/>
												<?php
											}
										?>
									</div>
									<div id="pruebaDB" style="display:none;">
										
									</div>
								</div>
							</div>
						<?php
					}
				}
			?>
		</div>
	</div>
</div>


<?php get_footer(); ?>



