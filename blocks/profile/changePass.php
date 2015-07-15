<div class="col-xs-12 col-sm-6 col-md-8">
	<div class="well well-lg" align="left">	
		<div id="login_well_inside" align="left">
			<div id="grp_old_pass" class="input-group"> 
				<label class="control-label" for="txt_old_pass">Contrase&ntilde;a Actual</label>
				<input type="password" id="txt_old_pass" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon4">
			</div>
			<div id="grp_pass" class="input-group"> 
				<label class="control-label" for="txt_pass">Contrase&ntilde;a</label>
				<input type="password" id="txt_pass" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon4">
			</div>
			<div id="grp_pass2" class="input-group"> 
				<label class="control-label" for="txt_pass2">Confirmar Contrase&ntilde;a</label>
				<input type="password" id="txt_pass2" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon5">
			</div>
			<div class="input-group"> 			
			</div>
			<br>
				
		</div>
		<div id="pruebaDB" style="border:solid thin #000; display:none;">
		
		</div>
	</div>
	<div id="login_message" class="alert alert-danger action-alert" role="alert">

	</div>
	<div id="login_message2" class="alert alert-success action-alert" role="alert">

	</div>
</div>
<div class="col-xs-6 col-md-4">
	<div class="panel panel-info">
		<div class="panel-heading" align="left">
			Mi Cuenta 
		</div>
		<div class="panel-body">
			<button type="button" id="btn_changePass" class="btn btn-success">
				Guardar Cambios
			</button>
			</br>
			</br>
			<button type="button" id="btn_back" class="btn btn-danger">
				Regresar
			</button>
		</div>				
	</div>
</div>

<script>
	$("#btn_changePass").click(function(){
		var message = "";
		var oldpass = document.getElementById("txt_old_pass").value;
		var pass = document.getElementById("txt_pass").value;
		var pass2 = document.getElementById("txt_pass2").value;

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

		if(message == ""){
			ajax_("profile", "&oldpass_="+oldpass+"&id_=<?php echo $info_user[0]; ?>", false, "pruebaDB");

			if(document.getElementById("txt_ver1").value==0){
				message+="Error en su contraseña actual.";		
				$("#grp_old_pass").addClass( "has-error" );	
				show_message(message,"login_message");	
			}else{
				ajax_("profile", "&pass_="+pass+"&id_=<?php echo $info_user[0]; ?>", false, "pruebaDB");
				if(document.getElementById("txt_ver1").value==0){
					message+="No se almacenó su contraseña. Intentelo más tarde.";		
					$("#grp_old_pass").addClass( "has-error" );	
					show_message(message,"login_message");		
				}else{
					message+="Cambios realizados exitosamente";
					show_message(message,"login_message2");	
					setTimeout(function (){ window.location.assign("<?php echo get_variable("profile")."&cP=ok";?>"); }, 3200);
				}
			}
		}else{
			show_message(message,"login_message");						
		}		
	});

	$("#btn_back").click(function(){
		window.location.assign("<?php echo get_variable("profile");?>");
	});
</script>

