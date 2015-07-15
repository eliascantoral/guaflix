<div class="col-xs-10 col-md-offset-1">
	<div class="well well-lg" align="left">	
		<div id="login_well_inside" align="left">
			<div class="row">
				<div class="col-md-6">
					<div id="grp_name" class="input-group">  
						<label class="control-label" for="txt_num">Numero Tarjeta</label>
						<input type="text" id="txt_num" class="form-control" placeholder="" aria-describedby="basic-addon1" >
					</div>
					<div id="grp_last" class="input-group">  
						<label class="control-label" for="txt_name">Nombre en Tarjeta</label>
						<input type="text" id="txt_name" class="form-control" placeholder="" aria-describedby="basic-addon2" >
					</div>
					
					<div id="grp_date" class="input-group">  
						<label class="control-label" for="txt_last">Fecha Vencimiento </label>
						<div class="row">
							<div class="col-xs-5">
								<select name="month" id="month" class="form-control" size="1">
									<option value="-100"></option>
									<?php 
										for( $i = 1; $i <= 12 ; $i++ ){
											?>
												<option value="<?php echo $i ?>"><?php echo $i ?></option>
											<?php
										}
									 ?>
								</select>	
							</div>
							<div class="col-xs-6">
								<select name="year" id="year" class="form-control">
									<option value="-100"></option>
									<?PHP for($i=date("Y")-15; $i<date("Y"); $i++)
										echo "<option value='$i'>$i</option>";
									?>
									<?PHP for($i=date("Y"); $i<=date("Y")+15; $i++)
										echo "<option value='$i'>$i</option>";
									?>
								</select>	
							</div>
							<div class="col-xs-1">
								
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div id="imagenesCards1">
					</div>
					<div id="imagenesCards2">
					</div>
					<div id="imagenesCards3">
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-5 col-md-offset-5">
					<button class="btn btn-primary" id="btn_changeData" type="submit">Agregar</button>
					<button class="btn btn-danger" id="btn_back" type="submit">Cancelar</button>
				</div>
			</div>
		</div>
		<div id="pruebaDB" style="border:solid thin #000; display:none;">
		
		</div>
	</div>
	<div id="login_message" class="alert alert-danger action-alert" role="alert">

	</div>
	<div id="login_message2" class="alert alert-success action-alert" role="alert">

	</div>
</div>

<script>
	document.getElementById("month").selectedIndex = "0";
	document.getElementById("year").selectedIndex = "0";
	document.getElementById("txt_num").value = "";
	document.getElementById("txt_name").value ="";

	$("#btn_changeData").click(function(){
		var message = "";
		var numCard = document.getElementById("txt_num").value;
		var name = document.getElementById("txt_name").value;
		var mes = document.getElementById("month").value;
		var año = document.getElementById("year").value;
		
		if( ( numCard != "" ) &&  ( numCard.length == 16) ){
			$("#grp_name").addClass( "has-success ");
		}
		else{
			$("#grp_name").addClass( "has-error" );
			message+="Número de tarjeta inválido.";
		}

		if( name != "" ){
			$("#grp_last").addClass( "has-success ");
		}
		else{
			$("#grp_last").addClass( "has-error" );
			message+="Ingrese el nombre que está en la tarjeta.";
		}

		if( mes != -100 ){
			$("#grp_date").addClass( "has-success ");
		}
		else{
			$("#grp_date").addClass( "has-error" );
			message+="Ingrese el mes de vencimiento de tarjeta.";
		}

		if( año != -100 ){
			$("#grp_date").addClass( "has-success ");
		}
		else{
			$("#grp_date").addClass( "has-error" );
			message+="Ingrese el año de vencimiento de Tarjeta.";
		}

		if(message == ""){
			ajax_("cards", "&todo=add&numCard_="+numCard+"&nameCard_="+name+"&month_="+mes+"&year_="+año+"&id_=<?php echo $info_user[0]; ?>", false, "pruebaDB");
			if(document.getElementById("txt_ver1").value==0){
				message+="Existe una tarjeta con el número ingresado. Ingresela de Nuevo.";
				document.getElementById("txt_num").value = "";
				$("#grp_mail").addClass("has-error");
				show_message(message,"login_message");	
			}else{
				message+="Tarjeta Ingresada Correctamente.";
				show_message(message,"login_message2");	
				setTimeout(function (){ window.location.assign("<?php echo get_variable("profile")."&addCard=ok";?>"); }, 3200);
			}
		}else{
			show_message(message,"login_message");						
		}
	});

	$("#btn_back").click(function(){
		window.location.assign("<?php echo  get_variable("profile");?>");
	});

</script>