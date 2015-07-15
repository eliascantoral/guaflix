<div class="col-xs-12 col-sm-6 col-md-8">
	<div class="well well-lg" align="left">

		<?php 
			$flagCantTarjetas = 1;
			$info_cards = array();
			$info_cards = get_info_cards_ByUserid(is_login());
			//print_array($info_cards);
			
			if(sizeof($info_cards)>0)
			{
				for( $i = 0; $i < sizeof($info_cards); $i++ )
				{
					if( $info_cards[$i][8] == 0 ){ 
					?>
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							<div class="panel panel-default">
						    	<div class="panel-heading" role="tab" id="heading<?php echo $i; ?>">
						      		<h4 class="panel-title">
							        	<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapseOne">
							          		<div  class="visa">
							          		</div>
							          		Visa Ending <?php echo substr($info_cards[$i][1],12) ?>
							        	</a>
						      		</h4>
						    	</div>
						    	<div id="collapse<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						      		<div class="panel-body">
						        		<div class="row">
						        			<div class="col-xs-12">
						        				<div class="form-group">
													<label for="exampleInputEmail1">Nombre en Tarjeta</label>
													<div class="row">
														<div class="col-xs-offset-2">
															<p class="form-control-static"><?php echo $info_cards[$i][2] ?></p>	
														</div>	
													</div>
												</div>
						        			</div>
						        			<div class="col-xs-12">
						        				<div class="form-group">
													<label for="exampleInputEmail1">Expira</label>
													<div class="row">
														<div class="col-xs-offset-2">
															<p class="form-control-static"><?php echo $info_cards[$i][3]."/".$info_cards[$i][4]; ?></p>	
														</div>	
													</div>
												</div>
						        			</div>
						        			<div class="col-xs-12 col-xs-offset-5">
						        				<div class="form-group">
							        				<button type="button" class="btn btn-danger"  onclick="getValCard(<?php echo $info_cards[$i][0]; ?>)"  data-toggle="modal" data-target=".bs-example-modal-sm">
							        					<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete
							        				</button>
													<button type="button" class="btn btn-info" onclick="editCard(<?php echo $info_cards[$i][0]; ?>)">
														<span class="glyphicon glyphicon-pencil"  aria-hidden="true"></span> Edit
													</button>
												</div>
						        			</div>
						        		</div>
						      		</div>
						    	</div>
						  	</div>
						</div>
					<?php
					}
				}
			}else{
				?>
					<h4>
						No se encontraron tarjetas registradas.
					</h4>
				<?php
			}
		?>
		
	</div>		
</div>
<div class="col-xs-6 col-md-4">
	<div class="panel panel-info">
		<div class="panel-heading" align="left">
			Mis Tarjetas 
		</div>
		<div class="panel-body">
			<ul class="list-group">
				<a href="<?php echo get_variable("profile") ?>&addCard=1">
					<li class="list-group-item">
						Agregar Tarjeta
					</li>
				</a>
				<a href="">
					<li class="list-group-item">
						Otra opci&oacute;n
					</li>
				</a>
			</ul>
		</div>				
	</div>
</div>




<div id="eraseCardModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-body">
				¿Está seguro que desea eliminar la tarjeta de crédito?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" id="deleteCard">
					Aceptar
				</button>
				<button type="button" class="btn btn-info" id="cancelErase">
					Cancelar
				</button>
			</div>
		</div>
  	</div>
</div>



<script>
	var id_card = 0;
	var message="";
	function getValCard(id_tarjeta){
		id_card = id_tarjeta;
	}

	$("#deleteCard").click(function (){
		ajax_("cards", "&todo=erase&id_card="+id_card, false, "pruebaDB");
		//alert(document.getElementById("txt_ver1").value);
		if(document.getElementById("txt_ver1").value==0){
			message+="La tarjeta no pudo ser eliminada intentelo más tarde.";
			$("#grp_mail").addClass("has-error");
			show_message(message,"addcardSuccess");	
			$("#eraseCardModal").modal('hide');
		}else{
			$("#eraseCardModal").modal('hide');
			message+="Tarjeta Eliminada exitosamente";
			show_message(message,"addcardSuccess");	
			setTimeout(function (){ window.location.assign("<?php echo get_variable("profile");?>"); }, 3200);
		}	

	});
	
	$("#cancelErase").click(function () {
		$("#eraseCardModal").modal('hide');
	});

	function editCard(id){
		window.location.assign("<?php echo get_variable("profile")."&editCard=";?>"+id);
	}

</script>
