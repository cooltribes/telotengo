<!-- CONTENIDO ON -->
<div class="container margin_top">

	<h1><?php echo $categoria->nombre; ?></h1><hr class="no_margin_top"/>
	<div class="row-fluid">
	    <div class="col-md-3">
	        
	    </div>
	    <div class="col-md-9 no_padding_right">
	        <div class="row-fluid">
	            <div class="col-md-12 no_padding no_margin">
	               <?php	echo '<img width="100%" src="'.Yii::app()->baseUrl.'/images/categoria/'.$categoria->imagen_url.'"/>';?>
	                
	            </div>
	            
	            <?php 
	            $hijos = Categoria::model()->findAllByAttributes(array('id_padre'=>$categoria->id));
	            
	            foreach($hijos as $hijo): ?>
                  <div class="col-md-4 no_padding no_margin">  
                      <a title="Ir a <?php echo $categoria->nombre; ?>" href="<?php echo Yii::app()->baseUrl."/categorias/".$hijo->url_amigable; ?>" target="_self">
                            <img width="100%" title="<?php echo $categoria->nombre; ?>" src="<?php echo Yii::app()->baseUrl."/images/categoria/".$hijo->imagen_url; ?>" alt="<?php echo $categoria->nombre; ?>" />
                      </a>
                  </div>    
                <?php endforeach;?>
	            
	            
	                
	            
	            
	            
	            
	            
	            
	        </div>
            
        </div>
	    
	    
	</div>
	

</div>