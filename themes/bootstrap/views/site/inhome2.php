
         
           <div class="col-md-9 mainHome">
               <div class="row-fluid">
                   <div class="col-md-12"><h1>CATEGORIAS DESTACADAS</h1></div>
                   
<!-- +++++++++++++++++++++++++++++ CATEGORIAS ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->                   
                   <div class="col-md-12 no_horizontal_padding">
                       <section class="row-fluid">
                       	<?php foreach($model as $modelado)
                       	{
                       		$interno = Categoria::model()->findAllBySql("select * from tbl_categoria where id_padre =".$modelado->id." order by destacado desc limit 6");
                       		?>
                       		<article class="col-md-4">
                               <div class="row-fluid">
                                   <div class="col-md-12 no_horizontal_padding">
                                       <h3><?php echo $modelado->nombre;?></h3>
                                   </div>
                                   <div class="col-md-7 no_horizontal_padding">
                                       <ul class="categoriaHome">
                                       	<?php foreach ($interno as $inter)
										{?>
											<li><?php echo $inter->nombre;?></li>
										<?php	
										} ?>
                                       </ul>
                                   </div>
                                   <div class="col-md-5 no_horizontal_padding">
                                       <?php 	
                                        echo CHtml::image($modelado->getImgUrl(true),$modelado->nombre, array('width'=>'100%')); ?>  
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
                                           
                <?php $this->renderPartial('carousel_productos',array('data'=>$ultimos,'carousel'=>'ultimos')); ?>         
                    
    </div>
    
    <div class="col-md-12 margin_top">
                <h1>DESTACADOS</h1>
                                           
                <?php $this->renderPartial('carousel_productos',array('data'=>$destacados,'carousel'=>'destacados')); ?>         
                    
    </div>               
                                    
               </div>
           </div>
           
           <div class="col-md-3">
                <div class="row-fluid">
                    <div>
                       <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/imagenDerachaUp.png" width="100%"/>
                    </div>
                    <div class="margin_top">
                        <img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/imagenDerachaDown.png" width="100%"/>
                    </div>           
                </div>
           </div>
           
           <?php #echo $this->renderPartial('ofertaVolumen', array('volumeSales'=>NULL));?>
           

           
         