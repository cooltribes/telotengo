
        <div class="col-md-12 margin_top_small subcategory">
            <div class="breadcrumbs">
                <a><span>Inicio</span></a>/&nbsp;
                <a><span class="current">Sub Categoria</span></a>
            </div>
            <div class="row-fluid title">
                <div class="col-md-4 no_horizontal_padding"><div class="braker"></div></div>
                <div class="col-md-4 no_horizontal_padding text-center"><h1><?php echo $model->nombre;?></h1></div>
                <div class="col-md-4 no_horizontal_padding"><div class="braker"></div></div>                
            </div>
            <a href="#">
                <img src="http://placehold.it/1200x450" width="100%" class="margin_top">
            </a>
            
        </div>
        <div class="col-md-12 no_horizontal_padding">
            <div class="row-fluid">
                 <?php
                 foreach($hijos as $hijo)
				 {?>
				 	 <div class="col-md-4 margin_top">
                        <a href="#"><img src="http://placehold.it/380x270" width="100%"></a>
                    </div>
				 <?php
				 }
                 ?>

                    
                    
                    
            </div>
        </div>
        <div class="col-md-12 margin_top_large">
            <div class="row-fluid title">
                <div class="col-md-5 no_horizontal_padding"><div class="braker"></div></div>
                <div class="col-md-2 no_horizontal_padding text-center"><h1>MARCAS</h1></div>
                <div class="col-md-5 no_horizontal_padding"><div class="braker"></div></div>                
            </div>
        </div>
        
        <div class="col-md-10 col-md-offset-1">
            <?php $this->renderPartial('carousel_marcas'); ?>
        </div>
            
        
        
            
            
            
            
        </div>
