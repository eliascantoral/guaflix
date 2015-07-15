<div class="col-xs-12 col-sm-6 col-md-8">
	<div class="well well-lg" align="left">	
		<form class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-4 control-label">
					Nombre
				</label>
		    	<div class="col-sm-8">
		    		<p class="form-control-static">
		      			<?php 
		      				echo $info_user[1]." ".$info_user[2];
		      			?>
		      		</p>
		    	</div>
		  	</div>
		</form>
		<form class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-4 control-label">
					Username
				</label>
		    	<div class="col-sm-8">
		      		<p class="form-control-static">
		      			<?php 
		      				echo $info_user[3];
		      			?>
		      		</p>
		    	</div>
		  	</div>
		</form>
		<form class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-4 control-label">
					Email
				</label>
		    	<div class="col-sm-8">
		    		<p class="form-control-static">
		      			<?php 
		      				echo $info_user[4];
		      			?>
		      		</p>		
		    	</div>
		  	</div>
		</form>
		<form class="form-horizontal">
			<div class="form-group">
				<label class="col-sm-4 control-label">
					Contraseña
				</label>
		    	<div class="col-sm-8">
		      		<p class="form-control-static">
		      			<?php 
		      				for($i = 0; $i<10; $i++)
		      				{
		      					echo "*";
		      				}
		      			?>
		      		</p>
		    	</div>
		  	</div>
		</form>
	</div>
</div>
<div class="col-xs-6 col-md-4">
	<div class="panel panel-info">
		<div class="panel-heading" align="left">
			Mi Cuenta 
		</div>
		<div class="panel-body">
			<ul class="list-group">
				<a href="<?php echo get_variable("profile"); ?>&cP=1">
					<li class="list-group-item">
						Cambiar Contrase&ntilde;a
					</li>
				</a>
				<a href="<?php echo get_variable("profile"); ?>&cD=1">
					<li class="list-group-item">
						Modificar Datos
					</li>
				</a>
			</ul>
		</div>				
	</div>
</div>





