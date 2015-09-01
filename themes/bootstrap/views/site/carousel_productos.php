<style>
   /* .carouselHome .carousel-control.left{
        left: 5px;
    }
    
    .carouselHome .carousel-control.right{
        right:5px;    
    }
    */
    .carouselHome .carousel-control .glyphicon{
        line-height: 60px;
        position: relative;
        vertical-align: middle;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        
    }

    
    .carouselHome .carousel-control{
            position: absolute;
            top: 45px;
            width: 30px;
            height: 60px;
            font-size: 20px;
            color: #555;
            text-align: center;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.6);
            background: rgba(255,255,255,0.6);
            border-radius: 4px;
            border-top: solid 1px #999;
            border-bottom: solid 1px #999;
            border-left: solid 1px #CBCBCB;
            border-right: solid 1px #CBCBCB;
            
    }
    .carouselHome .carousel-control .arrow{
        display: inline-block;
        margin-top: -8px;
        font-size: 45px;
        font-weight: 500;
   }
    
</style>


<script>
$(document).ready(function () {
$('#<?php echo $carousel;?>').carousel({
   interval: 200000
});


//$('.carousel').carousel('cycle');
});  
</script>

<div id="<?php echo $carousel;?>Carousel" class="carousel slide carouselHome margin_top">
               <!-- Carousel indicators -->
          
               <!-- Carousel items -->
               <div class="carousel-inner">
                    <div class="item active">
                 <?php 
                 $i=1; 
                 foreach($data as $model) 
                 {
                 if(Imagenes::model()->findByAttributes(array('producto_id'=>$model->id, 'orden'=>1)))
				 {
				 	$imagen = Imagenes::model()->findByAttributes(array('producto_id'=>$model->id, 'orden'=>1));
					$url=Yii::app()->baseUrl.$imagen->url;
				 }
				 else
				 {
					 $url="http://placehold.it/131x150";
				 }?> 	
                
                 
          
                     <div>
                        <a href="#">

                            <img width="100%" style="max-height:150px" src="<?php echo $url;?>">
                        </a> 
                     </div>

                  
             <?php if($i%5==0):
                	if($i!=15): ?>
                </div>
                	<div class="item <?php echo $i==0?"active":""; ?>">
               <?php 
					else:
               ?> 
                </div>
              <?php endif; ?>
       
             <?php endif; ?>
                  
              <?php 
              	$i++;
				}
                ?> 
                </div> 
           
               
               <!-- Carousel nav -->
               
                <a class="carousel-control left" href="#<?php echo $carousel;?>" 
                  data-slide="prev"><span class="arrow">‹</span></a>
               <a class="carousel-control right" href="#<?php echo $carousel;?>" 
                  data-slide="next"><span class="arrow">›</span></a>

            </div>