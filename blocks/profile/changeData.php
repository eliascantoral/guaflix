<div class="col-xs-12 col-sm-6 col-md-8">
	<div class="well well-lg" align="left">	
		<div id="login_well_inside" align="left">
			<div id="grp_name" class="input-group">  
				<label class="control-label" for="txt_name">Nombre</label>
				<input type="text" id="txt_name" class="form-control" placeholder="Nombre" aria-describedby="basic-addon1" value="<?php echo $info_user[1]; ?>">
			</div>
			<div id="grp_last" class="input-group">  
				<label class="control-label" for="txt_last">Apellido</label>
				<input type="text" id="txt_last" class="form-control" placeholder="Apellido" aria-describedby="basic-addon2" value="<?php echo $info_user[2]; ?>">
			</div>
			<br>
			<div id="grp_mail" class="input-group">  
				<label class="control-label" for="txt_mail">eMail</label>
				<input type="text" id="txt_mail" class="form-control" placeholder="Email" aria-describedby="basic-addon3" value="<?php echo $info_user[4]; ?>">
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
			<button type="button" id="btn_changeData" class="btn btn-success">
				Guardar Cambios
			</button>
			</br>
			</br>
			<button type="button" id="btn_back_Data" class="btn btn-danger">
				Regresar
			</button>
		</div>				
	</div>
</div>

<script>
	$("#btn_changeData").click(function(){
		var message = "";
		var name = document.getElementById("txt_name").value;
		var last = document.getElementById("txt_last").value;
		var mail = document.getElementById("txt_mail").value;
		
		if( name != "" ){
			$("#grp_name").addClass( "has-success ");
		}
		else{
			$("#grp_name").addClass( "has-error" );
			message+="Debe ingresar un nombre.";
		}

		if( last != "" ){
			$("#grp_last").addClass( "has-success ");
		}
		else{
			$("#grp_last").addClass( "has-error" );
			message+="Debe ingresar un apellido.";
		}

		if(isValidEmailAddress(mail)){
				$("#grp_mail").addClass( "has-success" );
		}else{
				$("#grp_mail").addClass( "has-error" );				
				message+="eMail no valido.";
		}

		if(message == ""){
			ajax_("profile", "&name_="+name+"&last_="+last+"&mail_="+mail+"&id_=<?php echo $info_user[0]; ?>", false, "pruebaDB");
			if(document.getElementById("txt_ver1").value==0){
				message+="Ya existe una cuenta con ese eMail";
				$("#grp_mail").addClass("has-error");
				show_message(message,"login_message");	
			}else{
				message+="Cambios realizados exitosamente";
				show_message(message,"login_message2");	
				setTimeout(function (){ window.location.assign("<?php echo get_variable("profile")."&cD=ok";?>"); }, 3200);
			}
		}else{
			show_message(message,"login_message");						
		}
	});

	$("#btn_back_Data").click(function(){
		window.location.assign("<?php echo get_variable("profile");?>");
	});

</script>