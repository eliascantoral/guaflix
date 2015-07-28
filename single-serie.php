<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php $isfree = get_field("view_method")=="free";
        $accessmethod = get_field("view_method");
        $object = get_field("video");
        ///var_dump($object);
        $accessview = false;
        $status = false;
        if(is_login()) $status = user_object_status(is_login(), $post->ID);
        if(!$isfree){
                if(!is_login()){
                        $accessview = false; 
                }else{
                        if(!$status){
                                $accessview = false;                       
                        }else{
                                $accessview = true; 
                }							
            }
    }else{ $accessview = true;}  
    ?>


<div class="container" id="object_info_wrapper">
        <div class="row">
            <div class="col-xs-12 col-md-4" align="center">
                <div id="playaction">                    
                    <?php
                        if(has_post_thumbnail( $object_id )){
                                $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );                                            
                        }else{
                                $feat_image = get_template_directory_uri() . '/img/imagendefault.jpg';                              
                        }                                                                 
                        if($isfree || $accessview){?>
                                    <img id="d1" src="<?php echo $feat_image;?>" width="90%">  
                                    <div class="contenthover">
                                        <?php $mimetype = explode("/", $object['mime_type']);?>
                                        <a 
                                            <?php                                                 
                                                switch($mimetype[0]){
                                                    case "video":{?>href="<?php echo get_variable("player",$object_id);?>&object=<?php echo $post->ID;?>" <?php break;}
                                                    case "audio":{?>href="#" onclick="ajax_async('audioplayer', '', false, 'playaction')" <?php break;}
                                                    default :?>href="<?php echo $object['url']?>"<?php
                                                }?>
                                            class="mybutton"><img src="<?php echo get_template_directory_uri(); ?>/img/play.png" width="90%"></a>
                                    </div>                                  
                        <?php }else{?>
                                    <img id="d1" src="<?php echo $feat_image;?>" width="90%">  
                        <?php }?>      
                </div>                                               
                <br>
                <br>
                    <span class='st_facebook_large' displayText='Facebook'></span>
                    <span class='st_twitter_large' displayText='Tweet'></span>
                    <span class='st_pinterest_large' displayText='Pinterest'></span>
                    <span class='st_googleplus_large' displayText='Google +'></span>
                    <span class='st_email_large' displayText='Email'></span>                
                <br>
                <br>
                    <div>
                        <?php 
                            if(!$isfree){
                                if($status){
                                    switch($status[0]){							
                                            case "0":{//compra	
                                                get_payoptions($post->ID);
                                            break;}
                                            case "1":{//alquiler
                                                    $time = strtotime ("today midnight");
                                                    if($status[1]>=($time-1)){                                                        
                                                            get_payoptions($post->ID);
                                                    }else{
                                                            echo "El tiempo de renta ha terminado.";					
                                                    }
                                                    break;
                                            }
                                            case "2":{///Membresia
                                                    get_payoptions($post->ID);
                                                    break;
                                            }

                                    }                                
                                }else{
                                    get_payoptions($post->ID);
                                }                                 
                            }                                               
                        ?>
                </div>               
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="panel panel-default">
                        <div class="panel-heading">
                                <h4 class="media-heading"><?php the_title();?></h4>
                        </div>
                        <div class="panel-body">
                                <div id="object_content"><?php the_content(); ?></div>	
                        </div>
                </div>

                <div id="object_participant"></div>
                <div class="clear"></div> 
                <div id="object_rating"></div>
            </div>
        </div>	
        <div class="row">
            <div class="col-xs-12">
                <div>
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Contenido</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Comentarios</a></li>
                  </ul>
                  <div class="tab-content">
                      <div role="tabpanel" class="tab-pane active" id="home">
                          <div class="row" >
                            <?php 
                                $grupo = get_field('grupo');
                                //var_dump($grupo);
                            ?>                              
                              <div class="col-xs-12 col-md-4" >
                                <div class="list-group">
                                    <?php for($i=0;$i<sizeof($grupo);$i++){?>
                                        <a href="" class="list-group-item <?php echo $i==0?'active':'';?> groupchange" rel="<?php echo $i;?>"><span class="badge"><?php echo sizeof($grupo[$i]['capitulo']);?></span><?php echo $grupo[$i]['titulo'];?> </a>                                    
                                    <?php }?>                                                                     
                                </div>                                  
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-8">
                                  <?php for($i=0;$i<sizeof($grupo);$i++){?>
                                            <div class="panel-group group-content <?php echo $i!=0?'action-alert':''?>" id="accordion_<?php echo $i;?>" role="tablist" aria-multiselectable="true">
                                                <?php                                                          
                                                    $capitulo = $grupo[$i]['capitulo'];
                                                    for($e=0;$e<sizeof($capitulo);$e++){?>
                                                       <div class="panel panel-default">
                                                         <div class="panel-heading" role="tab" id="heading<?php echo $i."_".$capitulo[$e]?>">
                                                           <h4 class="panel-title">
                                                               <a href="#"><span class="glyphicon glyphicon-<?php 
                                                                                                                switch (get_post_type( $capitulo[$e] )){
                                                                                                                    case 'objeto':{echo 'play';break;}
                                                                                                                    case 'examen':{echo 'list';break;}
                                                                                                                    
                                                                                                                }                                                               
                                                                                                                ?>" aria-hidden="true"></span></a>
                                                             <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i."_".$capitulo[$e]?>" aria-expanded="true" aria-controls="collapse<?php echo $i."_".$capitulo[$e]?>">
                                                                  <?php echo get_the_title( $capitulo[$e] ); ?> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                             </a>
                                                           </h4>
                                                         </div>
                                                         <div id="collapse<?php echo $i."_".$capitulo[$e]?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $i."_".$capitulo[$e]?>">
                                                           <div class="panel-body">
                                                               <?php echo the_excerpt_max_charlength($capitulo[$e], "150");?>                                                             
                                                           </div>
                                                         </div>
                                                       </div>                                                                                                                 
                                                    <?php }?>                                               
                                            </div>                                  
                                  <?php }?>                                  
                              </div>
                          </div>
                      </div>
                    <div role="tabpanel" class="tab-pane" id="profile">                        
                    </div>
                  </div>

                </div>                
                
            </div>
            
        </div>
</div>

<script>
	$( document ).ready(function() {		
		ajax_async("3","&se="+<?php echo $post->ID;?>,false,"object_participant");
		ajax_async("4","&se="+<?php echo $post->ID;?>,false,"object_rating");
	});
        $(".groupchange").click(function(e){
            e.preventDefault();
            var group = $(this).attr('rel');
            $(".group-content").hide("fast");
            $("#accordion_"+group).show("fast"); 
            $(".groupchange").removeClass('active');
            $(this).addClass('active');
        })
        $('#d1').contenthover({
            overlay_background:'#000',
            overlay_opacity:0.8
        });        
</script>



<?php endwhile; endif; ?>
<?php get_footer(); ?>
