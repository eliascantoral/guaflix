<?php
/*
	Template name: Login
*/
?>
<?php get_header(); ?>
<?php $prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';?>

<div class="container-fluid">
	<div class="row" align="center">
		<div class="col-sm-12" style="border:solid thin #000; height:800px; background-color:#001F5C;">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div id="login_well_inside" class="col-sm-6 col-sm-offset-3 well" style="margin-top:152.5px; border:solid thin #000;">
						<div class="col-sm-12" align="left">
							<div class="row">
								<div class="col-sm-12" style="margin-bottom:15px; border-bottom: solid thin #AAA;">
									<h3>
										<strong><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Iniciar Sesión</strong>
									</h3>	
								</div>
								<div class="col-sm-12">
									<form>
										<div class="form-group">
											<label for="txt_mail">
												Email
											</label>
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></span>
												<input type="email" class="form-control" id="txt_mail" placeholder="Email">
											</div>
										</div>	
										<div class="form-group">
											<label for="txt_pass">
												Contraseña
											</label>
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
												<input type="password" class="form-control" id="txt_pass" placeholder="Contraseña">
											</div>
										</div>

										<div class="col-sm-offset-4 form-group">
											<label>
												<a href="#">¿Olvidaste tu contraseña o email?</a>	
											</label>
										</div>
									</form>
								</div>
								<div class="col-sm-12" align="center">								
									<button type="button" id="btn_login" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Iniciar Sesión</button>	
								</div>
								<div class="col-sm-12" style="margin-top:20px;">
									<div class="col-sm-11" style="border-top:solid thin #AAA; padding-top:20px;">
										<form>
											<div class="form-group">
												<label>
														¿Aún no tienes cuenta?	
												</label>
											</div>
										</form>
									</div>
								</div>
								<div class="col-sm-12" style="margin-bottom:15px;" align="center">
									<a href="<?php echo get_variable("register");?>">
										<button type="button" class="btn btn-warning btn-lg"><span class=" glyphicon glyphicon-edit" aria-hidden="true"></span> Registrarse</button>	
									</a>
								</div>
							</div>
							<div id="pruebaDB" style="display:none;">
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>	
</div>
<div class="clear">
	
</div>
<div id="ajax_answer"></div>

<?php get_footer(); ?>

<script>
	/*$(".input-group").keyup(function(){
		$(this).removeClass( "has-success has-error" )
	});*/
	$("#btn_login").click(function(){
		var message = "";
		var mail = document.getElementById("txt_mail").value;
		var pass = document.getElementById("txt_pass").value;
		if(isValidEmailAddress(mail)){
				$("#grp_mail").addClass( "has-success" );
		}else{
				$("#grp_mail").addClass( "has-error" );				
				message+="eMail no valido.";
		}

		if(pass!=""){
				$("#grp_pass").addClass( "has-success" );
		}else{
				$("#grp_pass").addClass( "has-error" );	
				message+="Debe ingresar su contraseña.";				
		}
		if(message == ""){
			ajax_("login", "&mail_="+mail+"&pass_="+pass, false, "pruebaDB");
			if(document.getElementById("txt_ver1").value==0){
				message+="eMail o contraseña incorrectos.";
				$("#grp_mail").addClass("has-error");
				$("#grp_pass").addClass( "has-error" );	
				show_message(message,"login_message");	
			}else{
				window.location.assign("<?php echo get_variable("home").get_variable("profile");?>");
			}
			
		}else{
			show_message(message,"login_message");						
		}
	});

	$("#login_well_inside").keyup(function(event){
	    if(event.keyCode == 13){
	        $("#btn_login").click();
	    }
	});

</script>


