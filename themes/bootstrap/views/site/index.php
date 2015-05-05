<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/helper.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/dropdown.vertical.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/dropdown_menu/css/dropdown/themes/default/default.css');
?>
<script>
$(document).ready(function () {
$('#myCarousel2').carousel({
    interval: 2000
});


$('.carousel').carousel('cycle');
});  
</script>

<div class="container">
 
       
    <div class="row-fluid">

          <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
        <?php if(Yii::app()->user->hasFlash('success')){?>
            <div class="alert in alert-block fade alert-success text_align_center col-md-12 margin_top_small">
                <?php echo Yii::app()->user->getFlash('success'); ?>
            </div>
        <?php } ?>
        <?php if(Yii::app()->user->hasFlash('error')){?>
            <div class="alert in alert-block fade alert-danger text_align_center col-md-12 margin_top_small">
                <?php echo Yii::app()->user->getFlash('error'); ?>
            </div>
        <?php } ?>

        <div class="col-md-12 main-content" role="main">
			
        <?php    
        // barra de busqueda

         $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                    'id'=>'form-busqueda',
                                    'action'=>Yii::app()->createUrl('tienda/index'),
                                    'htmlOptions' => array(
                                        'enctype' => 'multipart/form-data',
                                    ),
                                )); 
        ?> 
        <div class="row-fluid">
            <div class="col-md-10 col-xs-9 no_padding">
                <!-- <input class="form-control no_radius_right" id="busqueda" name="busqueda" type="text" placeholder="¿Qué estás buscando?"> -->
                <?php echo CHtml::textField('busqueda', '', 
                                    array('id'=>'busqueda','placeholder'=>'¿Qué estás buscando?','class'=>'form-control no_radius_right'));
                ?>
                <?php echo CHtml::hiddenField('textobuscado', 'si', 
                            array('id'=>'textobuscado')); ?>
            </div>
            <!-- Busuqeda -->
            <div class="col-md-2 col-xs-3 no_padding">
                <!-- <a href="#" class="btn form-control btn-sigmablue no_radius_left" id="btn_search_event">Buscar</a> -->
                <?php $this->widget('bootstrap.widgets.TbButton', array(
                                'buttonType'=>'submit',
                                'htmlOptions'=>array('class'=>'btn form-control btn-sigmablue no_radius_left'),
                                'label'=>'Buscar',
                            ));

                $this->endWidget(); 

                ?>                 
            </div>
        </div>

        <?php
        // Boton                
        ?>
			<div id="myCarousel" class="carousel slide margin_top_small">
               <!-- Carousel indicators -->
               <ol class="carousel-indicators">
                  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#myCarousel" data-slide-to="1"></li>
                  <li data-target="#myCarousel" data-slide-to="2"></li>
               </ol>   
               <!-- Carousel items -->
               <div class="carousel-inner">
                  <div class="item active">
                     <a href="https://wuelto.com/sigmatiendas" target="_blank">
                         <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/slider1.jpg" width="100%" title="Halloween YuppiPark">
                     </a>
                  </div>
                  <div class="item">
                     <a href="categorias/licencias" target="_blank">
                         <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/slider2.jpg" width="100%" title="Licencias Originales">
                     </a>
                  </div>
                  <div class="item">
                     <a href="categorias/equipos" target="_blank">
                         <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/slider3.jpg" width="100%" title="Impresoras">
                     </a>
                  </div>
               </div>
               <!-- Carousel nav -->
               <a class="carousel-control left" href="#myCarousel" 
                  data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
               <a class="carousel-control right" href="#myCarousel" 
                  data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
            </div> 
            
            
            <section class="row-fluid margin_top">
            <h2>Ofertas Especiales<small class="pull-right no_margin"><a href="<?php echo Yii::app()->baseUrl."/site/ofertas" ?>">Más ofertas</a></small></h2>
            <hr class="no_margin_top margin_bottom_medium" />
            	<?php            	
            	$prod = new Producto;
				$productos = $prod->front(); 
				
				foreach($productos as $produc)
				{
					$producto = Producto::model()->findByPk($produc);
					
                    $inventario_menor_precio = Inventario::model()->getMenor($producto->id);
                    ?>
    					<article class="col-md-3">
                    		<div class="caja"> 
                    		<?php 
    	                 	
    	                	if($producto->mainimage) // tiene imagen
    	                	{
    	                		$principal = Imagenes::model()->findByAttributes(array('orden'=>1,'producto_id'=>$producto->id)); ?>
    							<div class="productImage">
    					<?php	if($principal->getUrl())
    								$im = CHtml::image(str_replace(".","_thumb.",$principal->getUrl()), "Imagen ", array("width"=>"100%","style"=>"max-height:240px; overflow-y:hidden,max-width:240px; overflow-x:hidden"));
    							else 
    								echo '<img src="http://placehold.it/300x240" width="100%">';
    							 
    							echo "<a href='".$producto->getUrl()."'>".$im; ?>
    							
    							</div>
    							
    				<?php
    						$marca = Marca::model()->findByPk($producto->marca_id);
    						$a = "marcas/".$marca->nombre; ?>
            
                            <div class="namep">
                            <h3 class="productName no_margin_top no_margin_bottom">
                                <a href="<?php echo $producto->getUrl()?>"> <?php echo $producto->nombre; ?></a>
                               
                            </h3>
                            <span> <small><span class="muted">por </span><?php echo CHtml::link($marca->nombre,array($a)); ?></small></span>
                            </div>
                            
                             
                      <div class="lead margin_bottom_small">
                        <?php    if($producto->hasFlashsale())
                               echo 'Aplica oferta'; ?>
                
                       </div>        	

    		   <?php
    							echo '<p>Bs.<big>'.$inventario_menor_precio->precio.'</big><a role="button" href="'.Yii::app()->baseUrl.'/producto/detalle/'.$producto->id.'" class="btn btn-xs btn-danger pull-right">Comprar ahora »</a>';
    							
    	                	}
    						?>
    	                	
    	                   	</div>
                      	</article>
    					<?php
    				    }
                	    ?>
  
                                                                             
            </section>
            <section class="row-fluid margin_top">
                <h2>Ubícanos</h2>
            <hr class="no_margin_top margin_bottom_medium" />
            <div class="row-fluid">
                <div class="col-md-12" style="text-align: center">
                    <a href="<?php echo Yii::app()->baseUrl;?>/site/tiendas">
                        <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/img_sucursales.png" style="margin: 0 auto 0 auto" />
                    </a>
                </div>
            </div>
            </section>
            
            <section class="row-fluid margin_top">
             
                    <div class="col-md-4">
                        <div class="content">
                        <iframe style="border: none; background-color: #ffffff; overflow: hidden; width: 100%; height: 350px;" src="http://www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fsigmatiendas&amp;width=400&amp;height=370&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true&amp;appId=123361354501719" frameborder="0" scrolling="no" width="320" height="350"></iframe>
                        </div>
                    </div>
                    <div class="col-md-4" style="height: 350px;">
                        <div class="content">
                        <a class="twitter-timeline" height="350" href="https://twitter.com/Sigmatiendas" data-widget-id="530834988501975040">Tweets por @Sigmatiendas</a>
                        <script type="text/javascript">// <![CDATA[
                        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
                        // ]]></script>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="content">
                            <script src="//instansive.com/widget/js/instansive.js"></script><iframe src="//instansive.com/widgets/ec65216c130bcf8283bc9daeb4aa5a318dbb2447.html" id="instansive_ec65216c13" name="instansive_ec65216c13"  scrolling="no" allowtransparency="true" class="instansive-widget" style="width: 100%; border: 0; overflow: hidden;"></iframe>
                        </div>
                    </div>
                    
               
            </section>
            
            <section class="row-fluid margin_top">
                <h2>Marcas Destacadas</h2>
            <hr class="no_margin_top margin_bottom_medium" />
            
            <div id="myCarousel2" class="carousel slide">
               <!-- Carousel indicators -->
         
               <!-- Carousel items -->
               <div class="carousel-inner">
                  <div class="item active row-fluid">
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Blackberry"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/blackberry.png" />
                        </a> 
                     </div>
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Lenovo"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/lenovo.png" />
                        </a> 
                     </div>
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Samsung"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/samsung.png" />
                        </a> 
                     </div>
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/HP"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/hp.png" />
                        </a> 
                     </div>
                     
                  </div>
                  
                  <div class="item row-fluid">
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Caselogic"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/caselogic.png" />
                        </a> 
                     </div>
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Sandisk"; ?>"> 
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/sandisk.png" />
                        </a> 
                     </div>
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Kingston"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/kingston.png" />
                        </a> 
                     </div>
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Siragon"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/siragon.png" />
                        </a> 
                     </div>
                  </div>
                  
                  <div class="item row-fluid">
                        <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Argom"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/argom.png" />
                        </a> 
                     </div>
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Quo"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/quo.png" />
                        </a> 
                     </div>
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Nyck"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/nyck.png" />
                        </a> 
                     </div>
                     <div class="col-md-3">
                        <a href="<?php echo Yii::app()->baseUrl."/marcas/Forza"; ?>">
                            <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/marcas/forza.png" />
                        </a> 
                     </div>
                  </div>
                  
               </div>
               <!-- Carousel nav -->

            </div> 
            
             
            </section>

        </div>

        <!-- COLUMNA PRINCIPAL DERECHA OFF // -->
        <!-- COLUMNA IZQUIERDA (MENU) ON // -->

        <!-- COLUMNA IZQUIERDA (MENU) OFF // -->
    </div>
     <!-- CONTENIDO OFF -->
</div>                                       
<script>
	 
	 $('.link').popover({
        'selector': '',
        'placement': 'right',
        'title': '<a href="home.html">University of Tennessee-Knoxville</a>',
        'content': 'Facilities Services Department 2233 Volunteer Boulevard, Room 203 Knoxville, TN 37996-3010',
        'html': 'true'
      });
	
	
</script>
