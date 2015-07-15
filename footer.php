			<div id="ajax_loader">
			
			</div>		
		</div><!--page-->
	</div><!--page_wrapper-->	
	<br>
	<br>
	<br>
	<div class="footer">
	  <div class="panel-footer "><?php echo sprintf( __( '%1$s %2$s %3$s. All Rights Reserved.', 'blankslate' ), '&copy;', date( 'Y' ), esc_html( get_bloginfo( 'name' ) ) ); echo sprintf( __( ' Theme By: %1$s.', 'myappsoftware' ), '<a href="http://myappsoftware.com/">Myappsoftware</a>' ); ?></div>
	</div>
<?php wp_footer(); ?>	
</body>
</html>

<script>
	function show_message(message, where){
		$("#"+where).text(message);
		$("#"+where).show("fast");
		setTimeout(function(){$("#"+where).hide("fast");},3000)
	}
	function ajax_(action, data, update, dest){		
		$.ajax({
		  async:false, 
		  cache:false,
		  dataType:"html", 
		  type: 'POST',   
		  url: "<?php echo get_variable("ajax");?>",
		  data: "action="+ action + data, 
		  success:  function(respuesta){				
			if(update){
				if(dest==""){
					location.reload();
				}else{
					
					 window.location.assign(dest);
				}
				
			}else if(dest!=""){						
				document.getElementById(dest).innerHTML=respuesta;
			}
			$("#ajax_loader").fadeOut("fast");
		  },
		  beforeSend:function(){
			
			$("#ajax_loader").fadeIn( "slow" );
		  },
		  error:function(objXMLHttpRequest){$("#ajax_loader").fadeOut("fast");console.log(objXMLHttpRequest);}
		});
		
	}
	function ajax_async(action, data, update, dest){
		
		$.ajax({
		  async:true, 
		  cache:false,
		  dataType:"html", 
		  type: 'POST',   
		  url: "<?php echo get_variable("ajax");?>",
		  data: "action="+ action + data, 
		  success:  function(respuesta){				
			if(update){
				if(dest==""){
					location.reload();
				}else{
					
					 window.location.assign(dest);
				}
				
			}else if(dest!=""){						
				document.getElementById(dest).innerHTML=respuesta;
			}
			$("#ajax_loader").fadeOut("fast");
		  },
		  beforeSend:function(){
			$("#ajax_loader").fadeIn( "slow" );
		  },
		  error:function(objXMLHttpRequest){$("#ajax_loader").fadeOut("fast");console.log(objXMLHttpRequest);}
		});
		
	}	
	<?php if(is_login()){?>
		$("#logout_link").click(function(){
		
			ajax_("logout", "&userid=<?php echo is_login();?>", true, "<?php echo get_variable("home");?>");	
		});
	<?php }?>	
	
	$("#search_text").keyup(function() {
			var search_text = document.getElementById("search_text").value;
			if(search_text.length>1){
				$("#page_wrapper").hide("fast");
				$("#finder_wrapper").show("fast");
				ajax_async("0","&se="+search_text,false,"finder_wrapper");
			}else{
				$("#page_wrapper").show("fast");
				$("#finder_wrapper").hide("fast");	
			}
	});
	$(".list_category").click(function(){
		var category = $(this).attr('id');	
		$("#page_wrapper").hide("fast");
		$("#finder_wrapper").show("fast");
		ajax_async("1","&se="+category,false,"finder_wrapper");		
	});
	
	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		return pattern.test(emailAddress);
	};	
</script>