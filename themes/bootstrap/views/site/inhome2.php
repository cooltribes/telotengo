<img src="<?php echo Yii::app()->theme->baseUrl;?>/images/home/banner.jpg" width="100%"/>
<div class="col-md-8 col-md-offset-2">
        <div class="row-fluid margin_top">           
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
                    <div class="col-md-12">
                        <img width="100%" src="http://placehold.it/196x432">
                    </div>
                    <div class="col-md-12 margin_top">
                        <img width="100%" src="http://placehold.it/196x462">
                    </div>           
                </div>
           </div>
           
           <div class="col-md-12 volumeSales margin_top_large">
               <h1>
                   OFERTAS DESTACADAS POR VOLUMEN
               </h1>
           </div>
           <div class="col-md-9 volumeSales">
               <div class="row-fluid">
                           <?php $this->renderPartial('volume_sales',array('volumeSales'=>NULL)); ?>
                   
               </div>
               
           
           </div>
           <div class="col-md-3 margin_top">
                <div class="row-fluid">
                    <div class="col-md-12">
                         <img width="100%" src="http://placehold.it/196x330">
                    </div>
                    <div class="col-md-12 margin_top">
                         <img width="100%" src="http://placehold.it/196x328">
                    </div>           
                </div>
           </div>
           
            
        </div>
</div>
