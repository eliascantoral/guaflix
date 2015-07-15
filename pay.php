<?php
/*
	Template name: Pay
*/
?>
<?php $prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';?>
<?php if(!is_login()){wp_redirect( get_variable("login") ); exit;}?>
<?php if(!isset($_GET["object"])){ wp_redirect(get_home_url()); exit;}else{$object_id = $_GET["object"];}?>
<?php if(!isset($_GET["paym"]) || $_GET["paym"]==""){ wp_redirect($prev_url); exit;}else{$paym  = $_GET["paym"];}?>
<?php $membresia = get_field("membresia", $object_id);
	$mem_dec = "";
	$cost = "";
	switch($paym){
		case "0":$mem_dec = "Compra"; $cost = get_field("compra", $object_id);break;
		case "1":$mem_dec = "Renta por día"; $cost = get_field("renta", $object_id);break;
		case "2":$mem_dec = "Compra por membresia"; $cost = get_field("membresia", $object_id); break;					
	}
	?>
<?php get_header(); ?>
<?php $userdata = get_info_user(is_login());?>

<div class="well well-lg" align="center">
	<div id="login_well_inside" align="left">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Descripci&oacute;n</h3>
			</div>
			<div class="panel-body">
				Hola <strong><?php echo $userdata[1]." ".$userdata[2];?></strong> esta apunto de adquirir el Objeto <strong><?php echo get_the_title($object_id)?></strong> 
				utilizando el metodo <strong><?php echo $mem_dec;?></strong> el cual tiene un costo de <strong><?php echo get_field("moneda_abreviado","option") . number_format((float)$cost+0,2,'.','');?></strong>
				<input type="hidden" id="pay_cost" value="<?php echo number_format((float)$cost+0,2,'.','');?>">
				<div class="clear"></div>
				<br>
				<?php if($paym=="1"){?>
					  <div class="form-group">
						<label for="exampleInputFile">Cantidad de d&iacute;as</label>
						<select class="form-control" id="day">
						  <option value="1">1</option>
						  <option value="2">2</option>
						  <option value="3">3</option>
						  <option value="4">4</option>
						  <option value="5">5</option>
						</select>
					  </div>
					<br>
				<?php }?>	
					  <div class="form-group">
						<label for="exampleInputFile">Tarjeta</label>
						<?php $tc_list = get_tcval_list(is_login());?>						
						<select class="form-control" id="tc">
							
								<?php								
								for($i=0;$i<sizeof($tc_list);$i++){?>
									<option value="<?php echo $tc_list[$i][0]?>"><?php echo $tc_list[$i][1]?> (<?php echo $tc_list[$i][2]?>)</option>
								<?php }?>							  
						</select>
					  </div>				
				<div class="clear"></div>
				<div class="alert alert-info" role="alert" align="center"><h3>Total: <?php echo get_field("moneda_abreviado","option")?> <span id="pay_total_text"><?php echo number_format((float)$cost+0,2,'.','');?></span></h3></div>
				<br>
				<div class="btn-group btn-group-justified" role="group">
					<div class="btn-group" role="group">
					  <button type="button" id="btn_pay" class="btn btn-default">Comprar</button>
					</div>
					<div class="btn-group" role="group">
					  <button type="button" id="btn_cancel" class="btn btn-default" data-toggle="dropdown">Cancelar</button>		
					</div>
				</div>
				<div class="alert alert-success action-alert" id="pay_messageok" role="alert"></div>
				<div class="alert alert-danger action-alert" id="pay_messagebad" role="alert"></div>
				
			</div>
		</div>
	</div>
</div>
<div id="ajax_answer" class="action-alert"></div>	
<input type="hidden" id="pay_info_answer" value="-">

<?php get_footer(); ?>
<script>
	var total_day=1;
	$("#btn_pay").click(function(){
		var card = document.getElementById("tc").value;
		ajax_("5","&user_=<?php echo is_login();?>&object_=<?php echo $object_id?>&paym=<?php echo $paym?>&day="+total_day+"&tc_="+card,false, "ajax_answer");	
		var the_json = document.getElementById("ajax_answer").innerHTML;
		var as = JSON.parse(the_json);
		if(as['r']=="1"){
			show_message("Todo salio bien, por favor espere un momento.","pay_messageok");
			setTimeout(function(){window.location.assign("?<?php echo get_variable("player")?>&object="+as['d']);},2000)
		}else{
			show_message(as['d'],"pay_messagebad");
		}
	});
	$("#day").change(function(){
		total_day = document.getElementById("day").value;
		cost = document.getElementById("pay_cost").value;
		document.getElementById("pay_total_text").innerHTML = (total_day*cost).toFixed(2);
		
	});
	$("#btn_cancel").click(function(){
		window.history.back();		
	});
</script>