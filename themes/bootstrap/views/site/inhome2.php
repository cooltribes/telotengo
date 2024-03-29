           <div class="col-md-9 mainHome">
               <div class="row-fluid">
                   <div class="col-md-12"><h1>CATEGORIAS DESTACADAS</h1></div>
                   
<!-- +++++++++++++++++++++++++++++ CATEGORIAS ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->                   
                   <div class="col-md-12 no_horizontal_padding">
                       <section class="row-fluid categoriasHome">
                       	<?php foreach($model as $modelado)
                       	{
                       		$interno = Categoria::model()->findAllBySql("select * from tbl_categoria where id_padre =".$modelado->id." order by destacado desc limit 4");
                       		?>
                       		<article class="col-md-4 categoriaRow" style="overflow-y:hidden;">
                               <div class="row-fluid">
                                   <div class="col-md-12 no_horizontal_padding">
                                             <h3><a href='<?php echo Yii::app()->createUrl('categoria/index', array('url'=>$modelado->seo->amigable))?>'><?php echo $modelado->nombre?></a></h3>
                                   </div>
                                   <div class="col-md-7 no_horizontal_padding">
                                       <ul class="categoriaHome">
                                       	<?php foreach ($interno as $inter)
										{?>
											<li><a href='<?php echo Yii::app()->createUrl('tienda/index', array('categoria'=>$inter->url_amigable))?>'><?php echo $inter->nombre?></a></li>
										<?php	
										} ?>
                                       </ul>
                                   </div>
                                   <div class="col-md-5 no_horizontal_padding">
                                        <a href='<?php echo Yii::app()->createUrl('categoria/index', array('url'=>$modelado->seo->amigable))?>'>
                                   		
                                   	
                                       <?php 	
                                          echo CHtml::image($modelado->getImgUrl(false),$modelado->nombre, array('class'=>'imagenCategoria', 'width'=>'100%')); 
                                        ?>
                                     </a>    
                                   </div>
                               </div>                       
                           </article> 
                       	
                       	<?php	
                       	}?>    
                           
                       </section>                                            
                   </div>
<!-- +++++++++++++++++++++++++++++ CATEGORIAS ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->  


    <div class="col-md-12 margin_top">
                <h1>ULTIMOS PUBLICADOS</h1>
                                           
                <?php $this->renderPartial('carousel_productos',array('data'=>$ultimos,'carousel'=>'ultimos','similares'=>0)); ?>         
                    
    </div>
    
    <div class="col-md-12 margin_top destacados">
                <h1>DESTACADOS</h1>
                                           
                <?php $this->renderPartial('carousel_productos',array('data'=>$destacados,'carousel'=>'destacados','similares'=>0)); ?>         
                    
    </div>               
                                    
               </div>
           </div>
           
           <div class="col-md-3 ofertas">
                <div class="row-fluid">
                    <div>
                       <a href="<?php echo Funciones::getBanner(2,1);?>"><img src="<?php echo Funciones::getBanner(2,2);?>" width="100%"/></a>
                    </div>
                    <div class="margin_top">
                        <a href="<?php echo Funciones::getBanner(3,1);?>"><img src="<?php echo Funciones::getBanner(3,2);?>" width="100%"/></a>
                    </div>           
                </div>
           </div>
           
           <?php #echo $this->renderPartial('ofertaVolumen', array('volumeSales'=>NULL));?>
           

           
         