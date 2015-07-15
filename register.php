<?php
/*
	Template name: Register
*/

	//print_array($_SESSION);

?>


<?php get_header(); ?>
<?php $prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';?>

<div class="container-fluid">
	<div class="row" align="center">
		<div class="col-sm-12" style="border:solid thin #000; height:800px; background-color:#001F5C;">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<div id="login_well_inside" class="col-sm-6 col-sm-offset-3 well" style="margin-top:97px; border:solid thin #000;">
						<div class="col-sm-12" align="left">
							<div class="row">
								<div class="col-sm-12" style="margin-bottom:15px; border-bottom: solid thin #AAA;">
									<h3>
										<strong><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Registrarse</strong>
									</h3>	
								</div>
								<div class="col-sm-12">
									<form>
										<div id="grp_name" class="form-group">
											<label for="txt_name">
												Nombre
											</label>
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
												<input type="text" class="form-control" id="txt_name" placeholder="Nombre">
											</div>
										</div>	
										<div id="grp_last" class="form-group">
											<label for="txt_last">
												Apellido
											</label>
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
												<input type="text" class="form-control" id="txt_last" placeholder="Apellido">
											</div>
										</div>
										<div id="grp_mail" class="form-group">
											<label for="txt_mail">
												Email
											</label>
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></span>
												<input type="email" class="form-control" id="txt_mail" placeholder="Email">
											</div>
										</div>
										<div id="grp_pass" class="form-group">
											<label for="txt_pass">
												Contrase&ntilde;a
											</label>
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
												<input type="password" class="form-control" id="txt_pass" placeholder="Contraseña">
											</div>
										</div>
										<div id="grp_pass2" class="form-group">
											<label for="txt_pass2">
												Confirmar Contrase&ntilde;a
											</label>
											<div class="input-group">
												<span class="input-group-addon"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
												<input type="password" class="form-control" id="txt_pass2" placeholder="Contraseña">
											</div>
										</div>

										<div class="col-sm-12 form-group" style="font-size:13px; margin-top:10px">
											<label>
												<input id="accept" type="checkbox"> Acepto los términos y condiciones de Privacidad.
												<div class="col-sm-12" style="font-size:11px;">
													<label>
														<a href="#">Políticas de Privacidad</a>
													</label>
												</div>
											</label>
										</div>
										
									</form>
								</div>
								<div class="col-sm-12" align="center">								
									<button type="button" id="btn_login" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Registrarse</button>	
								</div>
								<div id="login_message" class="col-sm-12 alert alert-danger action-alert" role="alert" style="margin-top:15px;">

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

<script>
	$(".input-group").keyup(function(){
		$(this).removeClass( "has-success has-error" )
	});
	$("#btn_login").click(function(){
		var message = "";
		var name = document.getElementById("txt_name").value;
		var last = document.getElementById("txt_last").value;
		var mail = document.getElementById("txt_mail").value;
		var pass = document.getElementById("txt_pass").value;
		var pass2 = document.getElementById("txt_pass2").value;


		if( name != "" ){
			$("#grp_name").addClass( "has-success ");
		}
		else{
			$("#grp_name").addClass( "has-error" );
			message+="\nDebe ingresar un nombre.";
		}

		if( last != "" ){
			$("#grp_last").addClass( "has-success ");
		}
		else{
			$("#grp_last").addClass( "has-error" );
			message+="\nDebe ingresar un apellido.";
		}

		if(isValidEmailAddress(mail)){
				$("#grp_mail").addClass( "has-success" );
		}else{
				$("#grp_mail").addClass( "has-error" );				
				message+="eMail no valido.";
		}


		if( pass!="" ){
			if( pass2 != "" ){
				if( pass == pass2 ){
					$("#grp_pass").addClass( "has-success" );
					$("#grp_pass2").addClass( "has-success" );		
				}else{
					$("#grp_pass2").addClass( "has-error" );		
					message+="La contraseña no coincide.";
				}
			}else{
				$("#grp_pass2").addClass( "has-error" );		
				message+="La contraseña no coincide.";
			}
		}else{
				$("#grp_pass").addClass( "has-error" );	
				message+="Debe ingresar su contraseña.";				
		}

		if ( !document.getElementById("accept").checked ) {
			message += "Debes aceptar los términos y condiciones de privacidad.";
		}

		if(message == ""){
			ajax_("login", "&name_="+name+"&last_="+last+"&mail_="+mail+"&pass_="+pass, false, "pruebaDB");
			if(document.getElementById("txt_ver1").value==0)
			{
				message+="Ya existe una cuenta con ese eMail";
				$("#grp_mail").addClass("has-error");
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

<?php get_footer(); ?>
