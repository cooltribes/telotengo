<?php
    $this->breadcrumbs=array(

        $model->nombre,
    );

    ?>
        <div class="col-md-12 margin_top_small subcategory">
            <div class="row-fluid clearfix title">
                <div class="col-md-4 no_horizontal_padding"><div class="braker"></div></div>
                <div class="col-md-4 no_horizontal_padding text-center"><h1><?php echo $model->nombre;?></h1></div>
                <div class="col-md-4 no_horizontal_padding"><div class="braker"></div></div>                
            </div>
            <div class="margin_top">
                <?php echo isset($mainImg[0])?$mainImg[0]->getImage($name = $mainImg[0]->name,$index=$mainImg[0]->index, $categoria_id=$model->id):'<img src="http://placehold.it/1200x450" width="100%">';
                ?>
             </div>   
           
             
        </div>

        <div class="col-md-12 no_horizontal_padding margin_bottom_large">
            <div class="row-fluid">
                 <?php 
                 foreach($imagenes as $img) 
                 {?>
                     <div class="col-md-4 margin_top">
                        <?php echo $img->getLinkedImage($name = $img->name,$index=$img->index, $categoria_id=$model->id);?>
                        <h3 class="text-center"><?php echo $img->linkedTitle; ?></h3>
                    </div>
                 <?php 
                 }
                 if(count($imagenes)==0){
                     for($i=0;$i<6;$i++): ?>
                      <div class="col-md-4 margin_top">
                       <img src="http://placehold.it/380x270" width="100%">
                     </div>                   
                     <?php endfor; 
                 }
                 
                 ?>

                    
                    
                    
            </div>
        </div>
         <?php if(count($marcas)>0): ?>
            <div class="col-md-12 margin_top_large margin_bottom">
                <div class="row-fluid title subcategory">
                    <div class="col-md-4 no_horizontal_padding"><div class="braker"></div></div>
                    <div class="col-md-4 no_horizontal_padding text-center"><h1>Marcas</h1></div>
                    <div class="col-md-4 no_horizontal_padding"><div class="braker"></div></div>                 
                </div>
            </div>
            
            <div>
                <?php $this->renderPartial('carousel_marcas', array('marcas'=>$marcas, 'model'=>$model)); ?>
            </div> 
        <?php endif;?>

        
        
            
            
            
            
        </div>
